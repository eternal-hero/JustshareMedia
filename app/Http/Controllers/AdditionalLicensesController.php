<?php

namespace App\Http\Controllers;

use App\Models\AdditionalCoupon;
use App\Models\AdditionalLicense;
use App\Models\GalleryItem;
use App\Models\Subscription;
use App\Models\TaxRate;
use App\Repositories\PaymentRepository;
use App\Services\Payment\CustomerProfileParams;
use App\Services\Payment\CustomerProfileService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdditionalLicensesController extends Controller
{
    public function chargeExistingPaymentMethod(Request $request, GalleryItem $video, CustomerProfileService $customerProfileService, PaymentRepository $paymentRepository) {
        $user = $request->user();
        $alreadyLicensedNumber = AdditionalLicense::where('created_at', '>=', Carbon::now()->subDays(30)->toDateTimeString())->where('user_id', $user->id)->count();
        if($alreadyLicensedNumber > 3) {
            return response('Max number of additional videos', 401);
        }
        $subscription = Subscription::where('user_id', $user->id)->first();
        if($subscription->status != Subscription::STATUS_ACTIVE) {
            return response('Subscription is not active', 401);
        }

        if($request->coupon) {
            $coupon = AdditionalCoupon::where('code', $request->coupon)->first();
            $tax = TaxRate::getTaxRate($user->state);
            $discountedPrice = 399 - $coupon->value;
            $total = $discountedPrice * $tax / 100 + $discountedPrice;
        } else {
            $tax = TaxRate::getTaxRate($user->state);
            $price = 399;
            $total = $price * $tax / 100 + $price;
        }
        $total = round($total, 2);

        $chargeResponse = $customerProfileService->charge($user, $total, $subscription->order, 'Additional video: '. $video->title);
        if($chargeResponse->isSuccessful()) {
            $transaction = $paymentRepository->createTransactionFromCompletedAttempt($chargeResponse->getReference(), $subscription->order);
            $paymentRepository->createAdditionalLicence($video, $user, $transaction);

            return redirect()->to(route('video.customize', ['id' => $video->id, 'type' => 'additional']));
        } else {
            $error = $chargeResponse->getMessage();

            return view('additional-payments.payment-error', compact('error'));
        }
    }

    public function newPaymentMethod(Request $request, GalleryItem $video) {
        $states = \App\Helpers::getStates();
        return view('additional-video-payment', compact('states', 'video'));
    }

    public function chargeForAdditionalVideo(Request $request, GalleryItem $video, CustomerProfileService $customerProfileService, PaymentRepository $paymentRepository) {
        $user = Auth::user();
        $alreadyLicensedNumber = AdditionalLicense::where('created_at', '>=', Carbon::now()->subDays(30)->toDateTimeString())->where('user_id', $user->id)->count();
        if($alreadyLicensedNumber > 3) {
            return response('Max number of additional videos', 401);
        }
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'card_number' => 'required|digits_between:13,19',
            'cvv' => 'required|min:3|numeric',
            'exp_month' => 'required|not_in:0',
            'exp_year' => 'required|not_in:0',
        ]);
        $customerParams = new CustomerProfileParams();
        $customerParams->setUser($user);
        $customerParams->setCardNumber($request->post('card_number'));
        $customerParams->setExpirationDate($request->input('exp_year') . '-' . $request->input('exp_month'));
        $customerParams->setCVV($request->post('cvv'));
        $order = $user->activeOrder();
        $tax = TaxRate::getTaxRate($user->state);

//        dd($request->coupon);
        if($request->coupon) {
            $coupon = AdditionalCoupon::where('code', $request->coupon)->first();
            $tax = TaxRate::getTaxRate($user->state);
            $discountedPrice = 399 - $coupon->value;
            $total = $discountedPrice * $tax / 100 + $discountedPrice;
        } else {
            $price = 399;
            $total = $price * $tax / 100 + $price;
        }
        $total = round($total, 2);

        $chargeResponse = $customerProfileService->chargeCard($customerParams, $order, $total, 'Additional video: '. $video->title);
        if($chargeResponse->isSuccessful()) {
            $transaction = $paymentRepository->createTransactionFromCompletedAttempt($chargeResponse->getReference(), $order);
            $paymentRepository->createAdditionalLicence($video, $user, $transaction);
            return redirect()->to(route('video.customize', ['id' => $video->id, 'type' => 'additional']));
        } else {
            $error = $chargeResponse->getMessage();
            return view('additional-payments.payment-error', compact('error'));
        }
    }
}
