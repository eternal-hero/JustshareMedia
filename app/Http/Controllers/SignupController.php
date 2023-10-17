<?php

namespace App\Http\Controllers;

use App\Models\AdditionalCoupon;
use App\Models\GalleryItem;
use App\Models\OperateLocation;
use App\Models\PendingSubscription;
use App\Models\SubscriptionPlan;
use App\Models\TaxRate;
use App\Models\TransactionAttempt;
use App\Repositories\PaymentRepository;
use App\Rules\AddressRule;
use App\Rules\CustomFullnameRule;
use App\Services\Payment\CustomerProfileParams;
use App\Services\Payment\CustomerProfileService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AuthorizeNet;

class SignupController extends Controller
{
    /**
     * Signup landing page
     *
     * @return void
     */
    public function index()
    {
        return view('auth/signup');
    }

    public function index2() {
        $recentItems = GalleryItem::where('public', 1)->orderBy('updated_at', 'desc')->limit(3)->get();
        $prices = SubscriptionPlan::find(1);
        $contractPrice = $prices->contract;
        $annualPrice = $prices->yearly;
        return view('auth/signup2')->with(compact('recentItems', 'contractPrice', 'annualPrice'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        $user = \App\Models\User::where('email', $request->input('email'))->first();
        if (! $user) {
            return response()->json([
                'exists' => 0
            ]);
        } else {
            return response()->json([
                'exists' => 1
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function validateCoupon(Request $request)
    {
       // if (! ctype_alnum($request->input('coupon'))) return 'Missing coupon';
        if (! $request->input('plan')) return 'Invalid plan';
        if (! $request->input('term')) return 'Invalid term';

        // Verify coupon code
        $coupon = \App\Models\Coupon::where('code', $request->input('coupon'))->first();

        $state = $request->input('state_code');

        // Calculate total with this plan, term, and coupon
        $total = \App\Models\Order::calculatePrice($request->input('plan'), $request->input('term'), $state, $request->input('coupon'));
        $totalWithoutCoupon = \App\Models\Order::calculatePrice($request->input('plan'), $request->input('term'), $request->input('state_code'));
        if (! $total) return 'Price calculation error';
        //if (! $total['special']) return 'No coupon for this plan and term';
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

    public function validateCouponAdditional(Request $request) {
//        dd($request->coupon);
        $user = Auth::user();
        $coupon = AdditionalCoupon::where('code', $request->coupon)->first();
        $tax = number_format(TaxRate::getTaxRate($user->state), 2);
        $fmt = new \NumberFormatter( 'us_US', \NumberFormatter::CURRENCY );
        if(!$coupon) {
            return [
                'status' => false,
                'data' => [
                    'price' => $fmt->formatCurrency(399, 'USD'),
                    'tax' => number_format($tax, 2) . '%',
                    'discount' => $fmt->formatCurrency(0, 'USD'),
                    'total' => $fmt->formatCurrency(399 + 399 * $tax / 100, 'USD')
                ]
            ];
        } else {
            $discountedPrice = 399 - $coupon->value;
            return [
              'status' => true,
              'data' => [
                  'price' => $fmt->formatCurrency(399, 'USD'),
                  'tax' => number_format($tax, 2) . '%',
                  'discount' => $fmt->formatCurrency($coupon->value, 'USD'),
                  'total' => $fmt->formatCurrency($discountedPrice + $discountedPrice * $tax / 100, 'USD')
              ]
            ];
        }
    }

    public function getProfile(Request $request)
    {
        // Variables
        $failed = ['result' => 'error', 'message' => 'Login failed'];
        $badpassword = ['result' => 'error', 'message' => 'Invalid Password'];
        $disabled = ['result' => 'error', 'message' => 'Your account is disabled. Please contact us for assistance.'];
        $subscribed = ['result' => 'error', 'message' => 'Your account already subscribed. Please contact us for assistance.'];
        // Validation
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        // Find user
        $user = \App\Models\User::where('email', $request->input('email'))->first();
        if (! $user) return response()->json($failed);

        // Check password
        if (! \Hash::check($request->input('password'), $user->password)) {
            // Bad password
            return response()->json($badpassword);
        }

        // Make sure user is not disabled
        if (! $user->isEnabled()) return response()->json($disabled);

        // Make sure user is not subscribed
        if ($user->isSubscribed()) return response()->json($subscribed);

        // User auth is good
        return response()->json([
            'result' => 'success',
            'message' => 'Login succeeded',
            'profile' => $user->getProfile()
        ]);
    }

    public function getProfileLoggedIn(Request $request)
    {
        // Variables
        $failed = ['result' => 'error', 'message' => 'Login failed'];
        $disabled = ['result' => 'error', 'message' => 'Your account is disabled. Please contact us for assistance.'];
        $subscribed = ['result' => 'error', 'message' => 'Your account already subscribed. Please contact us for assistance.'];

        // Find user
        $user = \Auth::user();
        if (! $user) return response()->json($failed);

        // Make sure user is not disabled
        if (! $user->isEnabled()) return response()->json($disabled);

        // Make sure user is not subscribed
        if ($user->isSubscribed()) return response()->json($subscribed);

        // User auth is good
        return response()->json([
            'result' => 'success',
            'message' => 'Login succeeded',
            'profile' => $user->getProfile()
        ]);
    }

    /**
     * @return false|string
     */
    public function step1()
    {
        $plans = [];
        $plan = \App\Models\SubscriptionPlan::first(); // Only allow selecting Standard Video plan
        foreach (\App\Helpers::getOrderTerms() as $term) {
            $tmp = [];
            $tmp['term'] = $term;
            foreach ($plan->getAttributes() as $k => $v) {
                $tmp[$k] = $v;
            }
            $tmp['features'] = [];
            $features = explode(';', $plan->features);
            foreach ($features as $feature) {
                $tmp['features'][] = $feature;
            }
            if ($term == 'yearly') {
                $tmp['features'][] = '12 months of access';
            }
            // Override colors
            switch ($term) {
                case 'monthly':
                    $tmp['color'] = 'primary';
                    break;
                case 'yearly':
                    $tmp['color'] = 'danger';
                    break;
                case 'contract':
                    $tmp['color'] = 'success';
                    break;
            }
            // Set data
            $plans[] = $tmp;
        }
        return json_encode([
            'plans' => $plans
        ]);
    }

    /**
     * @param Request $request
     * @return array|false|float
     */
    public function step2(Request $request)
    {
        usleep(500000);
        $request->validate([
            'plan' => 'required',
            'term' => 'required',
        ]);
        return \App\Models\Order::calculatePrice($request->post('plan'), $request->post('term'), $request->post('state_code'));
    }

    /**
     * @param Request $request
     * @param CustomerProfileService $paymentService
     * @param PaymentRepository $paymentRepository
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function step3(Request $request, CustomerProfileService $paymentService, PaymentRepository $paymentRepository)
    {
        // Validate request paramters
        $request->validate([
            'plan' => 'required',
            'term' => 'required',
            'email' => 'required|email',
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'company' => 'required|min:5',
            'address' => [new AddressRule()],
            'city' => 'required|min:3',
            'state' => 'required|min:2',
            'zip' => 'required|min:5',
            'phone' => 'required|min:10',
            'cardnumber' => 'required|digits_between:13,19',
            'cvv' => 'required|min:3',
            'expmonth' => 'required',
            'expyear' => 'required',
            'agreement' => 'accepted',
            //'g-recaptcha-response' => 'required|captcha', // json requests make this token time out, needs some reload ability
        ]);

        if (\Auth::guest()){
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required',
            ]);
        }

        // Check for existing user
        $user = \App\Models\User::where('email', $request->input('email'))->first();
        if (!$user) {
            $request->validate(['email' => 'unique:users']);
        } else {
            // Validate the user
            if (\Auth::guest() && !\Hash::check($request->input('password'), $user->password)) {
                return response()->json([
                    'result' => 'error',
                    'message' => 'Invalid password'
                ]);
            }

            // Make sure user is enabled
            if (! $user->isEnabled()) {
                return response()->json([
                    'result' => 'error',
                    'message' => 'Your account is disabled. Please contact us for assistance.'
                ]);
            }

            // Make sure user doesn't have a pending order
            if ($user->hasPendingOrder()) {
                return response()->json([
                    'result' => 'error',
                    'message' => 'You already have a pending order. Please contact us for assistance.'
                ]);
            }

            // Make sure user is not subscribed
            if ($user->isSubscribed()) {
                return response()->json([
                    'result' => 'error',
                    'message' => 'You already have an active subscription. Please contact us for assistance.'
                ]);
            }
        }

        // Check for valid plan
        $plan = \App\Models\SubscriptionPlan::find($request->input('plan'));
        if (! $plan) return response()->json(['result' => 'error', 'message' => 'Invalid Plan']);

        // Validate plan term and price
        $term = $request->input('term');
        if (! in_array($term, \App\Helpers::getOrderTerms())) return response()->json(['result' => 'error', 'message' => 'Invalid Term']);
        $price = $plan->$term;
        if (! $price || $price <= 0) return response()->json(['result' => 'error', 'message' => 'Invalid Price for Term']);

        // Calculate total with this plan, term, and coupon
        $total = \App\Models\Order::calculatePrice($request->input('plan'), $request->input('term'), $request->input('state'), $request->input('coupon'));
        $tax = \App\Models\TaxRate::getTaxRate($request->input('state'));
        if (! $total) {
            \Log::error('SignupController::api() step3 - Price Calculation Error', ['term' => $term, 'plan' => $plan->id]);
            return response()->json(['result' => 'error', 'message' => 'Price Calculation Error']);
        }

        // Create the new user
        if (\Auth::guest() && ! $user) {
            $user = new \App\Models\User();
            $user->email = $request->input('email');
            $user->password = \Hash::make($request->input('password'));
        }
        if (\Auth::check()) {
            $user = \Auth::user();
        }

        // Set user profile fields for new and existing users
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->company = $request->input('company');
        $user->address = $request->input('address');
        $user->address2 = $request->input('address2');
        $user->city = $request->input('city');
        $user->state = $request->input('state');
        $user->zip = $request->input('zip');
        $user->phone = $request->input('phone');
        $user->cardnumber = $request->input('cardnumber');

        // Social media
        $user->social_facebook = $request->input('social_facebook');
        $user->social_twitter = $request->input('social_twitter');
        $user->social_instagram = $request->input('social_instagram');

        /*
         * Create Authorize.net customer attempt
         * */
        $customerProfileParams = new CustomerProfileParams();
        $customerProfileParams->setCardNumber($request->input('cardnumber'));
        $customerProfileParams->setExpirationDate($request->input('expyear') . '-' . $request->input('expmonth'));
        $customerProfileParams->setCVV($request->input('cvv'));
        $customerProfileParams->setUser($user);
        $customerResponse = $paymentService->create($customerProfileParams);
        if(!$customerResponse->isSuccessful()) {
            return response()->json(['result' => 'error', 'message' => 'Declined']);
        }

        $user->authorize_customer_id = $customerResponse->getCustomerProfileId();
        $user->authorize_customer_address_id = $customerResponse->getCustomerAddressId();
        $user->authorize_customer_payment_profile_id = $customerResponse->getCustomerPaymentProfileId();

        // Create the new order
        $user->save();

        $order = $user->newOrder($total['price'], $total['coupon_id'], $plan->id, $term);
        if (! $order) return response()->json(['result' => 'error', 'message' => 'Error creating order. Please contact us for assistance.']);

        /*
         * Charge existing Authorize.net customer attempt
         * */
        $chargeResponse = $paymentService->charge($user, $total['price'], $order, 'Initial charge for first month');
        if(!$chargeResponse->isSuccessful()) {
            return response()->json(['result' => 'error', 'message' => 'Declined']);
        }

        if(!empty($request->input('lat')) && !empty($request->input('lng'))) {
            $defaultLocation = new OperateLocation();
            $defaultLocation->user_id = $user->id;
            $defaultLocation->address = $user->address . ' ' . $user->address2;
            $defaultLocation->name = 'Default Location';
            $defaultLocation->latitude = $request->input('lat');
            $defaultLocation->longitude = $request->input('lng');
            $defaultLocation->save();
        }


        // Load order's coupon
        if ($total['special']) {
            $coupon = \App\Models\Coupon::find($total['coupon_id']);
        }

        /*
         * Create the transaction record from transaction attempt
         * */
        $transaction = $paymentRepository->createTransactionFromCompletedAttempt($chargeResponse->getReference(), $order);

        // Setup subscription plan line item
        $data = ['plan_id' => $plan->id, 'term' => $term];
        $order->addItem('subscription', $plan->name . " | $term", $total['original'], $transaction->id, $data);

        // Setup coupon code line item if exists
        if ($order->hasCoupon()) {
            $data = ['coupon_code' => $coupon->code, 'coupon_id' => $coupon->id, 'coupon_type' => $coupon->type];
            $couponValue = $total['coupon_value'];
            $order->addItem('coupon', "Coupon Code: $coupon->code | " . $order->getCouponDescription(), $couponValue, $transaction->id, $data);
        }

        // Setup tax line item
        $order->addItem('tax', 'Sales Tax @ ' . $tax . '%', $total['tax'], $transaction->id);
        // Publish the order

        $order->publish();
        $order->status = 'active';
        $order->save();

        // Store subscription as active, cron will charge each subscription on 'end_at' data and update the field with
        // new charge date
        $subscription = $paymentRepository->creteInternalSubscription($term, $user, $order, $plan);

        // Check order failure
        if (!$order) {
            return response()->json([
                'result' => 'error',
                'message' => 'Order submission failed, please contact us for assistance'
            ]);
        }

        // Log an event for the new order
        Log::info('New Order Received', ['user' => $user, 'order' => $order, 'plan' => $plan]);

        // Success response
        return response()->json([
            'result' => 'success',
            'orderID' => $order->id
        ]);
    }


    public function checkStep1(Request $request) {
        // Validate request paramters
        $request->validate([
            'term' => 'required',
            'name' => ['required', new CustomFullnameRule()],
            'email' => 'required|email|unique:users',
            'state' => 'required',
            'password' => 'required|string|min:8',
        ]);
        $state = $request->input('state');
        $taxRate = TaxRate::where('state_iso_code', $state)->first();
        if(!$taxRate) {
            return response()->json([
                'status' => 'error',
                'message' => 'zip is not valid'
            ]);
        }

        $term = $request->term;
        $plan = \App\Models\SubscriptionPlan::find(1);
        $total = \App\Models\Order::calculatePrice($plan->id, $term, $state, false);

        $pricing = [
            'special' => $total['special'],
            'tax' => number_format($total['tax'], 2),
            'tax_rate' => number_format($total['tax_rate'], 2),
            'original_price' => number_format($total['original_price']),
            'price' => number_format($total['price'], 2),
            'original' => number_format($total['original'], 2),
            'coupon' => number_format($total['coupon'], 2),
            'coupon_id' => number_format($total['coupon_id'], 2),
            'coupon_value' => number_format($total['coupon_value'], 2),
            'coupon_type' => number_format($total['coupon_type'], 2)
        ];

        return response()->json([
            'state' => $state,
            'price' => $pricing
        ]);
    }

    public function register(Request $request, CustomerProfileService $paymentService, PaymentRepository $paymentRepository)
    {
        // Validate request parameters
        $request->validate([
            'term' => 'required',
            'email' => 'required|email|unique:users',
            'name' => [new CustomFullnameRule()],
            'cardholder' => [new CustomFullnameRule()],
            'zip' => 'required|min:5',
            'cardnumber' => 'required|digits_between:13,19',
            'cvv' => 'required|min:3',
            'expmonth' => 'required',
            'expyear' => 'required',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
            'g_recaptcha_response' => 'required|captcha', // json requests make this token time out, needs some reload ability
        ]);

        $plan = \App\Models\SubscriptionPlan::find(1);
        $term = $request->input('term');
        $coupon = $request->input('coupon');
        $nameArray = explode(' ', $request->input('name'));
        if (! in_array($term, \App\Helpers::getOrderTerms())) return response()->json(['result' => 'error', 'message' => 'Invalid Term']);
        $price = $plan->$term;
        $state = $request->input('state');
        if (! $price || $price <= 0) return response()->json(['result' => 'error', 'message' => 'Invalid Price for Term']);

        // Calculate total with this plan, term, and coupon
        $total = \App\Models\Order::calculatePrice($plan->id, $term, $state, $coupon);
        $tax = \App\Models\TaxRate::getTaxRate($state);
        if (! $total) {
            \Log::error('SignupController::api() step3 - Price Calculation Error', ['term' => $term, 'plan' => $plan->id]);
            return response()->json(['result' => 'error', 'message' => 'Price Calculation Error']);
        }

        $user = new \App\Models\User();
        $user->email = $request->input('email');
        $user->password = \Hash::make($request->input('password'));
//        $user->first_name = $nameArray[0];
//        $user->last_name = isset($nameArray[1]) ? $nameArray[1] : '';
        $user->company = '';
        $user->address = '';
        $user->address2 = '';
        $user->city = '';
        $user->state = $state;
        $user->zip = $request->input('zip');
        $user->phone = '';
        $user->cardnumber = $request->input('cardnumber');

        $cardHolderNameArray = explode(' ', $request->input('cardholder'));
        $user->first_name = $cardHolderNameArray[0];
        $user->last_name = isset($cardHolderNameArray[1]) ? $cardHolderNameArray[1] : '';;

        /*
         * Create Authorize.net customer attempt
         * */
        $customerProfileParams = new CustomerProfileParams();
        $customerProfileParams->setCardNumber($request->input('cardnumber'));
        $customerProfileParams->setExpirationDate($request->input('expyear') . '-' . $request->input('expmonth'));
        $customerProfileParams->setCVV($request->input('cvv'));
        $customerProfileParams->setUser($user);
        $customerResponse = $paymentService->create($customerProfileParams);
        if(!$customerResponse->isSuccessful()) {
            return response()->json(['result' => 'error', 'message' => 'DeclinedProfile']);
        }

        $user->authorize_customer_id = $customerResponse->getCustomerProfileId();
        $user->authorize_customer_address_id = $customerResponse->getCustomerAddressId();
        $user->authorize_customer_payment_profile_id = $customerResponse->getCustomerPaymentProfileId();

        // Create the new order
        $user->first_name = $nameArray[0];
        $user->last_name = isset($nameArray[1]) ? $nameArray[1] : '';
        $user->save();

        $order = $user->newOrder($total['price'], $total['coupon_id'], $plan->id, $term);
        if (! $order) {
            return response()->json(['result' => 'error', 'message' => 'Error creating order. Please contact us for assistance.']);
        }

        /*
         * Charge existing Authorize.net customer attempt
         * */
        $chargeResponse = $paymentService->charge($user, $total['price'], $order, 'Initial charge for first month');
        if(!$chargeResponse->isSuccessful()) {
            $customerId = $customerResponse->getCustomerProfileId();
            $paymentService->deleteProfile($customerId);
            TransactionAttempt::where('user_id', $user->id)->delete();
            $user->delete();
            return response()->json(['result' => 'error', 'message' => 'DeclinedPayment']);
        } else {
            $user->first_payment = true;
            $user->save();
        }

        // Load order's coupon
        if ($total['special']) {
            $coupon = \App\Models\Coupon::find($total['coupon_id']);
        }

        /*
         * Create the transaction record from transaction attempt
         * */
        $transaction = $paymentRepository->createTransactionFromCompletedAttempt($chargeResponse->getReference(), $order);

        // Setup subscription plan line item
        $data = ['plan_id' => $plan->id, 'term' => $term];
        $order->addItem('subscription', $plan->name . " | $term", $total['original'], $transaction->id, $data);

        // Setup coupon code line item if exists
        if ($order->hasCoupon()) {
            $data = ['coupon_code' => $coupon->code, 'coupon_id' => $coupon->id, 'coupon_type' => $coupon->type];
            $couponValue = $total['coupon_value'];
            $order->addItem('coupon', "Coupon Code: $coupon->code | " . $order->getCouponDescription(), $couponValue, $transaction->id, $data);
        }

        // Setup tax line item
        $order->addItem('tax', 'Sales Tax @ ' . $tax . '%', $total['tax'], $transaction->id);
        // Publish the order

        $order->publish();
        $order->status = 'active';
        $order->save();

        // Store subscription as active, cron will charge each subscription on 'end_at' data and update the field with
        // new charge date
        $subscription = $paymentRepository->creteInternalSubscription($term, $user, $order, $plan);

        // Check order failure
        if (!$order) {
            return response()->json([
                'result' => 'error',
                'message' => 'Order submission failed, please contact us for assistance'
            ]);
        }

        // Log an event for the new order
        Log::info('New Order Received', ['user' => $user, 'order' => $order, 'plan' => $plan]);

        // Success response

        Auth::loginUsingId($user->id);
        return response()->json([
            'result' => 'success',
            'orderID' => $order->id
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStates()
    {
        return response()->json(\App\Helpers::getStates());
    }

    /**
     * @return string
     */
    public function refreshToken()
    {
        return csrf_token();
    }
}
