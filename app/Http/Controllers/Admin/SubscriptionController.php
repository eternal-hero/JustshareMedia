<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AuthorizeNet;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\TaxRate;
use App\Models\User;
use App\Repositories\PaymentRepository;
use App\Services\Payment\CustomerProfileService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use net\authorize\api\contract\v1 as AnetAPI;

// TODO remove this once client subscribe all users
/*
 *
 *
 * */
class SubscriptionController extends Controller
{

    public function adminCancel(Subscription $subscription, PaymentRepository $paymentRepository) {
        $paymentRepository->cancelSubscription($subscription);

        return redirect()->back();
    }

    public function statusStates(Subscription $subscription) {
        $states = $subscription->previousStates;

        return view('admin/orders/status-states')->with(compact('subscription', 'states'));
    }

    public function leads(Request $request) {
        $subscriptionID = str_replace('sub_', '', $request->subscription);
        $subscription = Subscription::find($subscriptionID);
        if(!$subscription) {
            return false;
        }
        if($request->lead == 0) {
            $subscription->lead_id = null;
            $subscription->save();
        } else {
            $subscription->lead_id = $request->lead;
            $subscription->save();
        }
    }

    public function subscribeUser(User $user, Order $order, $date) {
        $startDate = date('Y-m-d', strtotime($date));
        $authorize = new AuthorizeNet();
        $term = $order->term;
        $plan = SubscriptionPlan::find($order->plan_id);
        $coupon = Coupon::find($order->coupon_id);
        if($coupon) {
            $couponCode = $coupon->code;
        } else {
            $couponCode = false;
        }
        $price = Order::calculatePrice($plan->id, $term, $user->state, $couponCode)['price'];
        $amount = number_format($price, 2, '.', '');
//        dd($amount);
        $subscriptionParams = [
            'intervalInMonths' => $term == 'yearly' ? 12 : 1,
            'subscriptionName' => $plan->name,
//            'startDate' => $term == 'yearly' ? date('Y-m-d', strtotime('+ 1 year')) : date('Y-m-d', strtotime( ' + 1 month')),
            'startDate' => $startDate,
//            'startDate' => '2021-08-17 17:14:10',
            'amount' => $amount,
            'TotalOccurrences' => 9999,
            'invoiceNumber' => $order->id,
        ];
        $customer = [
            'customerProfileId' => $user->authorize_customer_id,
            'customerPaymentProfileId' => $user->authorize_customer_payment_profile_id,
            'customerAddressId' => $user->customerAddressId,
        ];
        $subscriptionResponse = $authorize->createSubscriptionFromCustomerProfile($customer, $subscriptionParams);

        if ($subscriptionResponse['status'] == true) {
            $subscription = new \App\Models\Subscription();
            $subscription->plan_id = $plan->id;
            $subscription->user_id = $user->id;
            $subscription->order_id = $order->id;
            $subscription->term = $term;
            $subscription->status = 'active';
            $subscription->start_at = $startDate;
            $end_at = new \DateTime($subscription->start_at);
            $dateinterval = $term == 'yearly' ? 'P1Y' : 'P1M';
            $end_at->add(new \DateInterval($dateinterval));
            $subscription->end_at = $end_at;
            $subscription->authorize_subscription_id = $subscriptionResponse['subscriptionId'];
            $subscription->save();
            $order->status = 'active';
            $order->save();
            echo 'User subscribed';
        } else {
            dd($subscriptionResponse);
            echo 'Error';
        }
    }

    public function chargeUser(User $user, Order $order) {
        $authorize = new AuthorizeNet();
        $term = $order->term;
        $plan = SubscriptionPlan::find($order->plan_id);
        $coupon = Coupon::find($order->coupon_id);
        if($coupon) {
            $couponCode = $coupon->code;
        } else {
            $couponCode = false;
        }
        $price = Order::calculatePrice($plan->id, $term, $user->state, $couponCode)['price'];
        $amount = number_format($price, 2, '.', '');
        $profileid = $user->authorize_customer_id;
        $paymentprofileid = $user->authorize_customer_payment_profile_id;
        $response = $authorize->chargeCustomerProfile($profileid, $paymentprofileid, $amount);
        if($response['status'] == true) {
            $transaction = new \App\Models\Transaction();
            $transaction->user_id = $user->id;
            $transaction->order_id = $order->id;
            $transaction->type = 'payment';
            $transaction->status = 'completed';
            $transaction->authorize_transaction_id = $response ['authorize_transaction_id'];
            $transaction->authorize_auth_code = $response ['authorize_auth_code'];
            $transaction->authorize_transaction_code = $response ['authorize_transaction_code'];
            $transaction->authorize_transaction_description = $response ['authorize_transaction_description'];
            $transaction->amount = $amount;
            $transaction->save();
            echo 'Charged';
        } else {
            dd($response);
            echo 'Error';
        }

    }


    public function updateUser(User $user, string $cc, string $m, string $y, string $cvv) {
        $params['cardnumber'] = $cc;
        $params['expDate'] = $y . '-' .$m;
        $params['cvv'] = $cvv;

        // create new customer account
        $authorize = new AuthorizeNet();
        $result = $authorize->createCustomerProfile($user, $params);
        if($result['status']) {
            // update model with new cc
            $user->authorize_customer_id = $result['customerProfileId'];
            $user->authorize_customer_address_id = $result['customerAddressId'];
            $user->authorize_customer_payment_profile_id = $result['customerPaymentProfileId'];
            $user->cardnumber = $cc;
            $user->save();
            dd($result);
        } else {
            dd($result);
        }


    }

    public function updateSubscriptionType($subsc, $type) {

        $subscription = Subscription::find($subsc);
        $subscription->switch_to = $type;
        $subscription->save();

        $endAtDate = $subscription->end_at;
        return view('admin/subscription-update/success')->with(compact('endAtDate', 'type'));
    }

    public function canceled() {
        $canceledSubscriptions = Subscription::where('status', 'canceled')->orWhere('should_cancel_at', '!=', null)->with('cancelReason')->get();

        return view('admin/subscription-update/canceled')->with(compact('canceledSubscriptions'));
    }

}
