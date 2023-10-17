<?php


namespace App\Helpers;


use App\Models\Order;
use App\Models\Subscription;
use App\Repositories\PaymentRepository;
use App\Services\Payment\CustomerProfileService;
use Carbon\Carbon;

class ChargeSubscriptions
{
    public function __invoke(CustomerProfileService $customerProfileService, PaymentRepository $paymentRepository)
    {
        $now = Carbon::now();
        $subscriptions = Subscription::whereDate('end_at', $now)
            ->where('should_cancel_at', '=', null)
            ->where('status', '!=', Subscription::STATUS_CANCELED)->get();
        foreach ($subscriptions as $subscription) {
            if($subscription->switch_to) {
                $subscription->term = $subscription->switch_to;
                $subscription->switch_to = null;
                $subscription->save();
                $order = Order::find($subscription->order_id);
                $order->term = $subscription->term;
                $order->save();
            }
            if (!$subscription->order) {
                continue;
            }
            $couponCode = false;
            if ($subscription->order->coupon_id) {
                $coupon = \App\Models\Coupon::find($subscription->order->coupon_id);
                if ($coupon) {
                    $couponCode = $coupon->code;
                }
            }
            if($subscription->custom_price) {
                $originalPrice = $subscription->custom_price;
                $tax = Order::calculateTax($originalPrice, $subscription->user->state);
                $price = $originalPrice + $tax;
            } else {
                $amount = \App\Models\Order::calculatePrice($subscription->plan_id, $subscription->term, $subscription->user->state, $couponCode);
                $price = $amount['price'];
            }
            if(!$subscription->user->authorize_customer_id || !$subscription->user->authorize_customer_address_id || !$subscription->user->authorize_customer_payment_profile_id) {
                continue;
            }
            $chargeResponse = $customerProfileService->charge($subscription->user, $price, $subscription->order, 'Subscription charge');
            if ($chargeResponse->isSuccessful()) {
                $transaction = $paymentRepository->createTransactionFromCompletedAttempt($chargeResponse->getReference(), $subscription->order);
                if ($subscription->term == 'yearly') {
                    $endsAt = $now->copy()->addYear(1);
                } else {
                    $endsAt = $now->copy()->addMonth(1);
                }
                $subscription->end_at = $endsAt;
                $subscription->last_payment_at = $now;
                $subscription->transaction_id = $transaction->id;
                $subscription->status = Subscription::STATUS_ACTIVE;
                $subscription->save();
            } else {
                $subscription->status = Subscription::STATUS_UNPAID;
                $subscription->save();
            }
        }
    }
}
