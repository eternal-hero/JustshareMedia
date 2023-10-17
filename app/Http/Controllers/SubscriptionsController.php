<?php

namespace App\Http\Controllers;

use App\Helpers\AuthorizeNet;
use App\Mail\CanceledSubsNotifMail;
use App\Models\CancelReason;
use App\Models\Coupon;
use App\Models\GalleryItem;
use App\Models\LicensedVideo;
use App\Models\OperateLocation;
use App\Models\Order;
use App\Models\Subscription;
use App\Models\TaxRate;
use App\Models\User;
use App\Repositories\PaymentRepository;
use App\Services\Payment\CustomerProfileService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use PDF;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        /**@var User $user */

        $user = \Auth::user();
//        $subscription = $user->getSubscribtions();
        $subscription = Subscription::where('user_id', $user->id)->with('plan')->with('order')->first();
        $now = Carbon::now();
        if($subscription->term == 'yearly') {
            $createdAt = new \DateTime($subscription->created_at);
            $yearsAfterFirstSubscription = $now->diffInYears($createdAt->format('Y-m-d'));
//            $renewalDate = $subscription->created_at->copy()->addYears($yearsAfterFirstSubscription + 1);
            $renewalDate = $subscription->end_at;
        } else {
            $createdAt = new \DateTime($subscription->created_at);
            $monthsAfterFirstSubscription = $now->diffInMonths($createdAt->format('Y-m-d'));
//            $renewalDate = $subscription->created_at->copy()->addMonths($monthsAfterFirstSubscription + 1);
            $renewalDate = $subscription->end_at;
        }
        $cancelReasons = CancelReason::orderBy('order')->get();

        return view('dashboard/my-subscriptions/subscriptions', compact('user', 'subscription', 'renewalDate', 'cancelReasons'));
    }

    public function cancelSubscription(Request $request, $subscriptionId, PaymentRepository $paymentRepository)
    {
        /**@var User $user */
        $user = \Auth::user();
//        $subscription = Subscription::where('user_id', $user->id)->where('authorize_subscription_id', $subscriptionId)->first();
        $subscription = Subscription::find($subscriptionId);
        $cancelSubscriptionRequest = $paymentRepository->cancelSubscription($subscription);
        $result = [
          'status' => true,
          'message' => 'Subscription is canceled.',
        ];

        $admins = User::where('is_admin', 1)->get();
        foreach ($admins as $admin) {
            Mail::to($admin)->send(new CanceledSubsNotifMail($subscription->user->company, $cancelSubscriptionRequest->should_cancel_at));
        }
        $request->session()->flash('cancelResult', $result);

        return redirect()->route('my-subscriptions.index');

//        return view('dashboard/my-subscriptions/subscriptions', compact('user', 'subscription', 'result', 'cancelReasons' ));
    }

    /**
     * Render PDF file with the invoice
     * @param int $id
     * @return mixed
     */
    public function invoice(int $id): mixed
    {
        $order = Order::find($id);
        $pdf = PDF::loadView('pdf.invoice', ['order' => $order]);
        return $pdf->download('invoice'. $order->id.'.pdf');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function licensedVideos()
    {
        $user = \Auth::user();
        $licensedVideos = LicensedVideo::getIndexLicensedVideos($user);
        return view('dashboard/licensed-videos/index', compact('user', 'licensedVideos'));
    }

    /**
     * @param $id integer
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function viewLicensedVideo(int $id)
    {
        $user = \Auth::user();
        $video = LicensedVideo::find($id);
        $licensedVideos = LicensedVideo::getLicensedVideos($user, $video->video_id);
        $video = GalleryItem::find($video->video_id);
        return view('dashboard/licensed-videos/view-licensed-video', compact('video', 'user', 'licensedVideos'));
    }

    /**
     * @param $video_id
     * @param $location_id
     * @return mixed
     */
    public function downloadLicenseFile($video_id, $location_id,)
    {
        $user = \Auth::user();
        $licensedVideo = LicensedVideo::getOneLicensedVideo($user, $video_id, $location_id);
        $pdf = PDF::loadView('pdf.licence', compact('user', 'licensedVideo'));
        return $pdf->download('license_' . $user->company . '_' . $licensedVideo->video_title . '_'.$licensedVideo->location_name.'.pdf');

    }

    /**
     * @param $video_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function addMoreLocations($video_id)
    {
        /**
         * @var $user User
         */
        $user = \Auth::user();
        $licensedVideo = LicensedVideo::getOneLicensedVideo($user, $video_id);
        $video = GalleryItem::find($video_id);
        $locations = $user->getNotAttachedOperationalLocations($video->id);
        return view('dashboard/licensed-videos/add-more-locations', compact('licensedVideo', 'locations', 'user', 'video'));
    }

    public function reactivate() {
        $user = Auth::user();
        $subscription = Subscription::where('user_id', $user->id)->first();
        if(!$subscription) {
            Log::error('No subscription on reactivate, UID: ' . $user->id);
            throw new \Exception(500);
        }

        if($subscription->status != 'canceled') {
            return redirect()->route('dashboard');
        }

        if($subscription->custom_price) {
            $taxRate = TaxRate::getTaxRate($user->state);
            $price = $subscription->custom_price;
            $taxAmount = $price * $taxRate / 100;
            $totalAmount = $price+$taxAmount;
        } else {
            $order = Order::where('id', $subscription->order_id)->first();
            $coupon = Coupon::find($order->coupon_id);
            $term = $subscription->term;
            $plan = \App\Models\SubscriptionPlan::find(1);
            $total = \App\Models\Order::calculatePrice($plan->id, $term, $user->state, $coupon);

            $taxRate = $total['tax_rate'];
            $price = $total['original'];
            $taxAmount = $total['tax'];
            $totalAmount = $total['price'];
        }

        $currentCreditCard = str_repeat('*', strlen($user->cardnumber) - 4) . substr($user->cardnumber, -4);


        return view('dashboard.my-subscriptions.reactivate', compact('user', 'subscription', 'taxRate', 'price', 'taxAmount', 'totalAmount', 'currentCreditCard'));
    }

    public function reactivateAttempt(PaymentRepository $paymentRepository, CustomerProfileService $customerProfileService, Request $request) {
        $user = Auth::user();
        $subscription = Subscription::where('user_id', $user->id)->first();
        $subscriptionType = $request->type;
//        dd($subscriptionType);
        if($subscriptionType == 'custom') {
            $taxRate = TaxRate::getTaxRate($user->state);
            $price = $subscription->custom_price;
            $taxAmount = $price * $taxRate / 100;
            $totalAmount = $price+$taxAmount;
        } else {
            $order = Order::where('id', $subscription->order_id)->first();
//            dd($request->coupon);
            if($request->coupon) {
                $coupon = Coupon::where('code', $request->coupon)->first();
            } else {
                $coupon = Coupon::find($order->coupon_id);
            }

            if($coupon) {
                $couponCode = $coupon->code;
            } else {
                $couponCode = false;
            }

//            $term = $subscription->term;
            $plan = \App\Models\SubscriptionPlan::find(1);
            $total = \App\Models\Order::calculatePrice($plan->id, $subscriptionType, $user->state, $couponCode);

            $taxRate = $total['tax_rate'];
            $price = $total['original'];
            $taxAmount = $total['tax'];
            $totalAmount = $total['price'];
        }


        $now = Carbon::now();
        $chargeResponse = $customerProfileService->charge($user, $totalAmount, $subscription->order, 'Reactivate subscription');
        if ($chargeResponse->isSuccessful()) {
            $transaction = $paymentRepository->createTransactionFromCompletedAttempt($chargeResponse->getReference(), $subscription->order);
            if ($subscriptionType == 'yearly') {
                $endsAt = $now->copy()->addYear(1);
            } else {
                $endsAt = $now->copy()->addMonth(1);
            }
            $subscription->end_at = $endsAt;
            $subscription->last_payment_at = $now;
            $subscription->transaction_id = $transaction->id;
            $subscription->status = Subscription::STATUS_ACTIVE;
            $subscription->reactivated_at = $now;
            $subscription->term = $subscriptionType;

            $subscription->should_cancel_at = null;
            $subscription->reactivation_email_count = null;
            $subscription->reactivate_email_cancel_code = null;
            $subscription->switch_to = null;

            $subscription->save();

            return view('dashboard.my-subscriptions.reactivate-successful');
        } else {
            $subscription->status = Subscription::STATUS_CANCELED;
            $subscription->save();
            return back()->with('error', $chargeResponse);
        }
    }

    public function submitCancelReason(Request $request) {
        $subscription = Subscription::find($request->subscription_id);
        $subscription->reason_id = $request->reason_id;
        $subscription->cancel_comment = $request->comment;
        $subscription->save();

        return \response()->json([]);
    }

    public function validateCoupon(Request $request)
    {
        $user = Auth::user();
//        $currentSubscription = $user->subscription;

        // if (! ctype_alnum($request->input('coupon'))) return 'Missing coupon';
        if (! $request->input('plan')) return 'Invalid plan';
        if (! $request->input('term')) return 'Invalid term';

        // Verify coupon code
        $coupon = \App\Models\Coupon::where('code', $request->input('coupon'))->first();
//dd($coupon);
        $state = $request->input('state_code');

        // Calculate total with this plan, term, and coupon
        $total = \App\Models\Order::calculatePrice($request->input('plan'), $request->input('term'), $state, $request->input('coupon'));
        $totalWithoutCoupon = \App\Models\Order::calculatePrice($request->input('plan'), $request->input('term'), $request->input('state_code'));
        if (! $total) return 'Price calculation error';
        //if (! $total['special']) return 'No coupon for this plan and term';

//        if($currentSubscription->custom_price) {
//            $taxRate = TaxRate::getTaxRate($state);
//            $return = [
//                'tax' => number_format($currentSubscription->custom_price - ($taxRate * $currentSubscription->custom_price / 100), 2),
//                'tax_rate' => number_format(TaxRate::getTaxRate($state), 2),
//                'total' => number_format($currentSubscription->custom_price * $taxRate / 100, 2),
//                'originalTotal' => number_format($currentSubscription->custom_price,2),
//                'couponValue' => number_format(0, 2),
////                'origSubTotal' => number_format($totalWithoutCoupon['original'], 2)
//            ];
//        }

        $return = [
            'tax' => number_format($total['tax'], 2),
            'tax_rate' => number_format(TaxRate::getTaxRate($state), 2),
            'total' => number_format($total['price'], 2),
            'originalTotal' => number_format($total['original'] - $total['coupon_value'],2),
            'couponValue' => number_format($total['coupon_value'], 2),
            'origSubTotal' => number_format($totalWithoutCoupon['original'], 2)

        ];
        if ($coupon) {
            $return = array_merge([
                'coupon' => $request->input('coupon'),
                'couponRecurring' => $coupon->isRecurring() ? true : false,
                'description' => 'Congrats, you saved a ' . ($coupon->isRecurring() ? 'recurring' : 'one time') . ' $' . number_format($total['original'] - $total['price'] + $total['tax'], 2) . ' on your order!'
            ], $return);
        };

        // Successful coupon for this term, return special pricing
        return response()->json($return);
    }
}
