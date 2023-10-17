<?php

namespace App\Http\Controllers;

use App\Models\OperateLocation;
use App\Models\Order;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\TransactionAttempt;
use App\Models\User;
use App\Repositories\PaymentRepository;
use App\Services\Payment\CustomerProfileParams;
use App\Services\Payment\CustomerProfileService;
use App\Services\Payment\GatewayObjects\CustomerAddress;
use App\Services\Licensing\LicenseDates;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use net\authorize\api\contract\v1\CustomerAddressType;
use function GuzzleHttp\Psr7\str;

class DashboardController extends Controller
{
    /**
     * Dashboard homepage
     *
     * @return view
     */
    public function index(LicenseDates $licenseDates)
    {
        $user = Auth::user();
        $subscription = Subscription::where('user_id', $user->id)->first();
        if($subscription->status == Subscription::STATUS_ACTIVE) {
            $renewalDate = $licenseDates->renewalDate($user);
        } else {
            $renewalDate = $subscription->end_at;
        }
        $additionalEmails = $user->additionalEmails;

        return view ('dashboard/index')->with(compact('user', 'subscription', 'renewalDate', 'additionalEmails'));
    }

    /**
     * Profile password update form.
     *
     * @return view
     */
    public function password()
    {
        return view('dashboard/password');
    }

    /**
     * Process a password update attempt
     *
     * @param Request $request
     * @return response
     */
    public function passwordUpdate(Request $request)
    {
        // Parameter validation
        $request->validate([
            'current_password' => 'required|min:5|max:64',
            'new_password' => 'required|min:5|max:64',
            'confirm_password' => 'required|min:5|max:64'
        ]);

        // Make sure new passwords match
        if ($request->input('new_password') != $request->input('confirm_password')) {
            return redirect()->back()->with('error', 'Your new passwords didn\'t match');
        }

        // Validate current password
        $credentials = ['email' => \Auth::user()->email, 'password' => $request->input('current_password')];
        if (! \Auth::attempt($credentials)) {
            return redirect()->back()->withInput()->with('error', 'Your current password was incorrect');
        }

        // Set new password
        $user = \Auth::user();
        $user->password = \Hash::make($request->input('new_password'));
        $user->save();

        // Password updated successfully
        return redirect()->route('dashboard.password')->with('success', 'Password updated successfully');
    }

    /**
     * User profile update landing
     *
     * @return void
     */
    public function profile()
    {
        $profile = \Auth::user();

        $isFullProfile = true;
        $operateLocations = OperateLocation::where('user_id', $profile->id)->get();
        $fname = $profile->first_name;
        $lname = $profile->last_name;
        $company = $profile->company;
        $phone = $profile->phone;
        $address = $profile->address;
        $city = $profile->city;
        $hasOperateLocation = count($operateLocations) ? true : false;

        if($fname == '' || $lname == '' || $company == '' || $phone == '' || $address == '' || $city == '' || !$hasOperateLocation) {
            $isFullProfile = false;
        }

        return view('dashboard/profile')->with(compact('profile', 'isFullProfile'));
    }

    /**
     * User attempting a profile update
     *
     * @param Request $request
     * @param User $user
     * @param CustomerProfileService $paymentService
     * @return void
     */
    public function profileUpdate(Request $request, User $user, CustomerProfileService $paymentService)
    {
        $request->validate([
            'first_name' => 'required|min:2|max:16',
            'last_name' => 'required|min:2|max:16',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|min:10|max:16',
            'company' => 'required|min:5|max:64',
            'address' => 'required|min:5',
            'lat' => 'required',
            'lng' => 'required',
            'address2' => 'max:32',
            'city' => 'required|min:3|max:64',
            'state' => 'required|min:2|max:64',
            'zip' => 'required|min:5|max:64',
        ]);

        $operateLocations = OperateLocation::where('user_id', $user->id)->get();
        if(!count($operateLocations)) {
            $firstOperateLocation = new OperateLocation();
            $firstOperateLocation->user_id = $user->id;
            $firstOperateLocation->name = 'Default Location';
            $firstOperateLocation->latitude = $request->input('lat');
            $firstOperateLocation->longitude = $request->input('lng');
            $firstOperateLocation->address = $request->input('address');
            $firstOperateLocation->save();
        }

// use this to update address
//        $paymentService->updateAddress($user, 'dsadsadas address');

        $showPopup = false;
        if(!$user->is_signup_completed) {
            $showPopup = true;
            $user->is_signup_completed = true;
            $user->save();
        }

        $user->update($request->only(['first_name', 'last_name', 'email', 'phone', 'company', 'address', 'lat', 'lng', 'address2', 'city', 'state', 'zip']));

        return redirect()->back()->with(['success', 'Your profile has been updated.', 'showPopup' => $showPopup]);
    }

    /**
     * Current profile's My Orders page
     *
     * @return void
     */
    public function orders()
    {
//        $orders = \App\Models\Order::where('user_id', \Auth::user()->id)->get();
        $user = Auth::user();

        $userTransactions = Transaction::where('user_id', $user->id)->get();
        $transactions = [];
        foreach ($userTransactions as $userTransaction) {
            $transactionAttempt = TransactionAttempt::where('reference', $userTransaction->reference)->first();
            if($transactionAttempt) {
                $requestObj = json_decode($transactionAttempt->authorize_request_obj);
                $type = $requestObj->order->description;
            } else {
                $type = '';
            }
            $transactions[] = [
                'id' => $userTransaction->id,
                'date' => $userTransaction->created_at->format('Y-m-d h:i:s'),
                'type' => $type,
                'amount' => $userTransaction->amount
            ];
        }

        return view('dashboard/orders')->with(compact('transactions'));
    }

    /**
     * Load a specific order
     *
     * @return void
     */
    public function order(int $id)
    {
        // Validate order
        $order = \App\Models\Order::find($id);
        if (! $order) return redirect()->route('dashboard');

        // Validate user access
        if (\Auth::user()->id != $order->user->id) return redirect()->route('dashboard');

        // Setup plan data
        $plan = \App\Models\SubscriptionPlan::find($order->plan_id);

        // Return order view
        return view('dashboard/order')->with('order', $order);
    }

    /**
     * Render brand colors view
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function brandColors()
    {
        return view('dashboard/brand-colors')->with(['user' => Auth::user()]);
    }

    /**
     * Render brand colors view
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function updateBrandColors(Request $request, User $user)
    {
        $user->update($request->only(['colors']));
        return redirect()->back()->with('success', 'Your Brand Colors has been updated.');
    }

    public function billing(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $currentCreditCard = str_repeat('*', strlen($user->cardnumber) - 4) . substr($user->cardnumber, -4);
        $states = \App\Helpers::getStates();

        return view('dashboard/billing')->with(compact('user', 'currentCreditCard', 'states'));
    }

    public function billingUpdate(Request $request, CustomerProfileService $paymentService) {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'card_number' => 'required|digits_between:13,19',
            'cvv' => 'required|min:3|numeric',
            'exp_month' => 'required|not_in:0',
            'exp_year' => 'required|not_in:0',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
        ]);
        $user = Auth::user();
        $customerProfileParams = new CustomerProfileParams();
        $customerProfileParams->setCardNumber($request->input('card_number'));
        $customerProfileParams->setExpirationDate($request->input('exp_year') . '-' . $request->input('exp_month'));
        $customerProfileParams->setCVV($request->input('cvv'));
        $customerProfileParams->setUser($user);
        $customerAddress = new CustomerAddress(new CustomerAddressType());
        $customerAddress->setAddress($request->input('address'));
        $customerAddress->setCity($request->input('city'));
        $customerAddress->setState($request->input('state'));
        $customerAddress->setZip($request->input('zip'));
        $customerAddress->setCompany($user->company);
        $customerAddress->setCountry('US');
        $customerAddress->setEmail($user->email);
        $customerAddress->setFirstName($request->input('first_name'));
        $customerAddress->setLastName($request->input('last_name'));
        $customerAddress->setPhoneNumber($user->phone);

        $customerUpdateResponse = $paymentService->update($customerProfileParams, $customerAddress);
        if($customerUpdateResponse->isSuccessful()) {
            $error = false;
            $user->cardnumber = $request->input('card_number');
            $user->address = $request->input('address');
            $user->zip = $request->input('zip');
            $user->state = $request->input('state');
            $user->city = $request->input('city');
            $user->save();
        } else {
            $error = $customerUpdateResponse->getMessage();
            Log::info('Update request. User: ' . $user->id);
            Log::info($customerUpdateResponse->getMessage());
        }

        return redirect()->back()->with('error', $error);
    }

    public function manualPay(CustomerProfileService $customerProfileService, PaymentRepository $paymentRepository) {
        $now = Carbon::now();
        $user = Auth::user();
        $subscription = Subscription::where('user_id', $user->id)->first();
        $couponCode = false;
        if($subscription->order->coupon_id) {
            $coupon = \App\Models\Coupon::find($subscription->order->coupon_id);
            if($coupon) {
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
        $amount = \App\Models\Order::calculatePrice($subscription->plan_id, $subscription->term, $subscription->user->state_code, $couponCode);
        $chargeResponse = $customerProfileService->charge($subscription->user, $price, $subscription->order, 'Subscription charge');
        if($chargeResponse->isSuccessful()) {
            $transaction = $paymentRepository->createTransactionFromCompletedAttempt($chargeResponse->getReference(), $subscription->order);
            if($subscription->term == 'yearly') {
                $endsAt = $now->copy()->addYear(1);
            } else {
                $endsAt = $now->copy()->addMonth(1);
            }
            $subscription->end_at = $endsAt;
            $subscription->status = Subscription::STATUS_ACTIVE;
            $subscription->save();
            $message = 'Your subscription is paid.';
            $status = true;
        } else {
            $subscription->status = Subscription::STATUS_UNPAID;
            $subscription->save();
            $message = $chargeResponse->getMessage();
            $status = false;
        }

        return view('dashboard/manual-payment')->with(compact('message', 'status'));
    }
}
