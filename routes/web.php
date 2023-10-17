<?php

use App\Jobs\ReactivationEmailJob;
use App\Mail\LicenseRenewalMail;
use App\Models\Order;
use App\Models\Subscription;
use App\Repositories\PaymentRepository;
use App\Services\Payment\CustomerProfileService;
use Carbon\Carbon;
use App\Jobs\SendLicenseRenewalMailJob;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
// Controllers
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SignupController;
// Admin Controllers
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\LogsController;
use App\Http\Controllers\Admin\OrderController;
use \App\Http\Controllers\Admin\SubscriptionController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test-reminder-emails', function() {
    $users = User::all();
    $now = Carbon::now();
    foreach ($users as $user) {
        if($user->isSubscribed()) {
            $subscription = Subscription::where('user_id', $user->id)->where('status', 'active')->first();
            $createdAt = new \DateTime($subscription->created_at);
            $monthsAfterFirstSubscription = $now->diffInMonths($createdAt->format('Y-m-d'));
            $availableLicenseDate = $subscription->created_at->copy()->addMonths($monthsAfterFirstSubscription);
            if($now->isSameDay($availableLicenseDate)) {
                SendLicenseRenewalMailJob::dispatch($user);
            }
        }
    }
});

// Home page
Route::get('/', function () {
    return view('home')->with('items', \App\Models\GalleryItem::where('public', 1)->orderBy('updated_at', 'desc')->limit(3)->get());
});

Route::get('/signup', [SignupController::class, 'index2'])->name('signup')->middleware('guest');
//Route::get('/signup2', [SignupController::class, 'index2'])->name('signup2')->middleware('guest');
Route::post('/signupapi', [SignupController::class, 'api'])->name('signup.api');

Route::post('/step1', [SignupController::class, 'step1'])->name('step1');
Route::post('/step2', [SignupController::class, 'step2'])->name('step2');
Route::post('/step3', [SignupController::class, 'step3'])->name('step3');
Route::post('/register', [SignupController::class, 'register'])->name('register');
Route::post('/check-step1', [SignupController::class, 'checkStep1'])->name('check-step1');
Route::get('/refresh-token', [SignupController::class, 'refreshToken'])->name('refresh.token');

Route::post('/check-email', [SignupController::class, 'checkEmail'])->name('check.email');
Route::post('/validate-coupon', [SignupController::class, 'validateCoupon'])->name('validate.coupon');
Route::post('/validate-coupon/additional', [SignupController::class, 'validateCouponAdditional'])->name('validate.coupon.additional');
Route::post('/get-profile', [SignupController::class, 'getProfile'])->name('get.profile');
Route::post('/get-profile-loggedin', [SignupController::class, 'getProfileLoggedIn'])->name('get.profile.logged');
Route::get('/get-states', [SignupController::class, 'getStates'])->name('get.states');
Route::post('/get-state-tax-rate', [\App\Http\Controllers\Admin\TaxRatesController::class, 'getStateTaxRate'])->name('get.state.tax.rate');

Route::get('/gallery', [\App\Http\Controllers\PublicController::class, 'gallery'])->name('public.gallery');
Route::post('/gallery-guest-ajax', [\App\Http\Controllers\PublicController::class, 'galleryGuestAjax'])->name('gallery.guest.ajax');

route::post('/', function(Request $request) {
    $request->validate([
        'firstName' => 'required|max:50',
        'lastName' => 'required|max:50',
        'companyName' => 'required|max:50',
        'phone' => 'required|max:50',
        'email' => 'required|email',
        'g-recaptcha-response' => 'required|captcha',
    ]);

    // Build mail data
    $data = [
        'firstName' => $request->input('firstName'),
        'lastName' => $request->input('lastName'),
        'companyName' => $request->input('companyName'),
        'phone' => $request->input('phone'),
        'email' => $request->input('email'),
    ];

    // Send the message
    //Mail::to('team@justsharemedia.com')->send(new \App\Mail\ScheduleFormMail($data));

    $emails = [
        'team@justsharemedia.com',
        //'a.lashin@wstlnk.com',
        //'roddy@wstlnk.com',
        //'igor@wstlnk.com'
    ];

    Mail::send('emails.scheduleform', ['data' => $data], function($message) use ($data, $emails) {
        $message->to($emails)
            ->replyTo($data['email'], $data['firstName'] . ' ' . $data['lastName'])
            ->from(config('mail.from.address'))
            ->subject('Schedule Form Submission');
    });

    //Mail::to('a.lashin@wstlnk.com')->send(new \App\Mail\ScheduleFormMail($data));
    //Mail::to('roddy@wstlnk.com')->send(new \App\Mail\ScheduleFormMail($data));
    //Mail::to('igor@wstlnk.com')->send(new \App\Mail\ScheduleFormMail($data));
    //Mail::to('ryan@justsharemedia.com')->send(new \App\Mail\ScheduleFormMail($data));

    // Success
    return view('home')->with('contactSuccess', true);
});

// Contact Form
Route::get('/contact', function() {
    return view('contact');
});
route::post('/contact', function(Request $request) {
    $request->validate([
        'name' => 'required|max:50',
        'email' => 'required|email',
        'message' => 'required|min:5',
        'g-recaptcha-response' => 'required|captcha',
    ]);

    // Build mail data
    $data = [
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'message' => $request->input('message')
    ];

    // Send the message
    Mail::to('team@justsharemedia.com')->send(new \App\Mail\ContactFormMail($data));

    // Success
    return view('contact')->with('success', true);
});

Route::get('/about', function() {
    return view('about');
});

Route::get('/products-services', function() {
    return view('products-services');
});

Route::get('/errortest', function() {
    return view ('doesntexist');
});

Auth::routes(['verify' => true, 'register' => false]);

// Login System
//Route::post('/login', [LoginController::class, 'authenticate']);

// Dashboard / Account Section
Route::middleware('auth')->group(function () {


    Route::get('/dashboard/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
    Route::post('/dashboard/profile{user}', [DashboardController::class, 'profileUpdate'])->name('dashboard.profile.update');

    Route::middleware('App\Http\Middleware\FullProfile')->group(function() {


//    Route::get('reset-licensing', function() {
//        $user = \App\Models\User::where('email', 'text_editor@account.com')->first();
//        \App\Models\LicensedVideo::where('user_id', $user->id)->delete();
//        echo 'Done';
//        exit;
//    });

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/admin', [DashboardController::class, 'index'])->name('admin-dashboard');

        Route::get('/dashboard/orders', [DashboardController::class, 'orders'])->name('dashboard.orders');
        Route::get('/dashboard/orders/{id}', [DashboardController::class, 'order'])->name('dashboard.order.update');
        Route::get('/dashboard/password', [DashboardController::class, 'password'])->name('dashboard.password');
        Route::post('/dashboard/password', [DashboardController::class, 'passwordUpdate'])->name('dashboard.password.update');


        Route::get('/dashboard/brand-colors', [DashboardController::class, 'brandColors'])->name('dashboard.brand-colors');
        Route::post('/dashboard/brand-colors{user}', [DashboardController::class, 'updateBrandColors'])->name('dashboard.brand-colors.update');

        Route::resource('/dashboard/operate-locations', \App\Http\Controllers\OperateLocations::class);

        Route::get('/dashboard/my-subscriptions/', [\App\Http\Controllers\SubscriptionsController::class, 'index'])->name('my-subscriptions.index');
        Route::get('/dashboard/subscriptions/reactivate', [\App\Http\Controllers\SubscriptionsController::class, 'reactivate'])->name('subscriptions.reactivate');
        Route::post('/dashboard/subscriptions/reactivate', [\App\Http\Controllers\SubscriptionsController::class, 'reactivateAttempt'])->name('subscriptions.reactivate.post');
        Route::post('subscription/validate', [\App\Http\Controllers\SubscriptionsController::class, 'validateCoupon'])->name('subscription.validateCoupon');
        Route::post('/dashboard/subscriptions/cancel-reason', [\App\Http\Controllers\SubscriptionsController::class, 'submitCancelReason'])->name('subscriptions.reactivate.cancel-reason');

        Route::get('/dashboard/licensed-videos/', [\App\Http\Controllers\SubscriptionsController::class, 'licensedVideos'])->name('licensed.videos');
        Route::get('/dashboard/view-licensed-video/{id}', [\App\Http\Controllers\SubscriptionsController::class, 'viewLicensedVideo'])->name('view.licensed.videos');

        Route::get('/dashboard/billing', [DashboardController::class, 'billing'])->name('dashboard.billing');
        Route::post('/dashboard/billing', [DashboardController::class, 'billingUpdate'])->name('dashboard.billing.update');

        Route::get('/download-license/{video_id}/{location_id}', [\App\Http\Controllers\SubscriptionsController::class, 'downloadLicenseFile'])->name('download.license.file');

        Route::post('/dashboard/cancel-subscription/{id}', [\App\Http\Controllers\SubscriptionsController::class, 'cancelSubscription'])->name('cancel.subscription');
        Route::get('/dashboard/invoice/download/{id}', [\App\Http\Controllers\SubscriptionsController::class, 'invoice'])->name('download.invoice');


        Route::post('/gallery-ajax', [\App\Http\Controllers\PublicController::class, 'galleryAjax'])->name('gallery.ajax');

        Route::post('/video-edit/{video_id}', [\App\Http\Controllers\PublicController::class, 'previewVideo'])->name('preview.video');

        Route::get('/attach-video-to-location/{video_id}', [\App\Http\Controllers\PublicController::class, 'attachVideo'])->name('attach.video');
        Route::post('/attach-video-to-location/{video_id}', [\App\Http\Controllers\PublicController::class, 'saveAttachedVideo'])->name('save.attached.video');

        Route::get('/video-customize/{id}/{type}', [\App\Http\Controllers\VideoCustomiserController::class, 'videoCustomize'])->name('video.customize');
        Route::post('/process-logo/{video_id}', [\App\Http\Controllers\VideoCustomiserController::class, 'processLogo'])->name('process.logo');
        Route::post('/submit-template', [\App\Http\Controllers\VideoCustomiserController::class, 'submitTemplate'])->name('submit.template');
        Route::delete('/delete-template', [\App\Http\Controllers\VideoCustomiserController::class, 'deleteTemplate'])->name('delete.template');
        Route::get('/attach-locations/{licenseType}/{video_id?}', [\App\Http\Controllers\VideoCustomiserController::class, 'attachLocations'])->name('attach.locations');
        Route::post('/redraw-locations-checkboxes', [\App\Http\Controllers\VideoCustomiserController::class, 'redrawLocationsCheckboxes'])->name('redraw.locations.checkboxes');
        Route::post('/add-more-locations/{video_id?}', [\App\Http\Controllers\VideoCustomiserController::class, 'addLocationsPost'])->name('add.locations');
        Route::post('/video-render', [\App\Http\Controllers\VideoCustomiserController::class, 'renderVideo'])->name('render.video');
        Route::get('/video-ready', [\App\Http\Controllers\VideoCustomiserController::class, 'videoReady'])->name('video.ready');
        Route::get('/download-video/{video_id}/{location_id}/{size}', [\App\Http\Controllers\VideoCustomiserController::class, 'downloadLicensedVideo'])->name('download.licensed.videos');

        // Additional Emails
        Route::post('/additional-emails', [\App\Http\Controllers\AdditionalEmailsController::class, 'add'])->name('additional-emails.add');
        Route::delete('/additional-emails', [\App\Http\Controllers\AdditionalEmailsController::class, 'deleteEmail'])->name('additional-emails.delete');

        // Manual Payment
        Route::get('manual-pay', [DashboardController::class, 'manualPay'])->name('manual-pay');

        Route::get('/additional-license/video/{video}', [\App\Http\Controllers\AdditionalLicensesController::class, 'chargeExistingPaymentMethod']);
        Route::get('/additional-license/payment/video/{video}', [\App\Http\Controllers\AdditionalLicensesController::class, 'newPaymentMethod']);
        Route::post('/additional-license/pay/video/{video}', [\App\Http\Controllers\AdditionalLicensesController::class, 'chargeForAdditionalVideo'])->name('chargeForAdditionalVideo');
        Route::get('/additional-license/pay/video/{video}', function () {
            return redirect()->route('public.gallery');
        });

    });
});

// Admin Pages
Route::middleware('App\Http\Middleware\AdminAccess')->group(function() {
    // Account Management
    Route::get('/admin/accounts', [AccountController::class, 'index'])->name('admin.accounts');
    Route::get('/admin/accounts/add', [AccountController::class, 'add'])->name('admin.accounts.add');
    Route::post('/admin/accounts/add', [AccountController::class, 'post'])->name('admin.accounts.post');
    Route::get('/admin/accounts/{id}', [AccountController::class, 'account'])->name('admin.accounts.view');
    Route::patch('/admin/accounts/{id}', [AccountController::class, 'patch'])->name('admin.accounts.patch');

    // Order Management
    Route::get('/admin/subscriptions', [OrderController::class, 'index'])->name('admin.orders');
    Route::get('/admin/orders/{id}', [OrderController::class, 'order'])->name('admin.orders.view');

    // Video Orders
    Route::get('/admin/video-orders', [\App\Http\Controllers\Admin\LicensedVideosController::class, 'videoOrders'])->name('admin.video-orders');
    Route::get('admin/video-orders-export', [\App\Http\Controllers\Admin\LicensedVideosController::class, 'videoOrdersExport'])->name('admin.video-orders.export');

    // Coupon Management
    Route::get('/admin/coupons', [CouponController::class, 'index'])->name('admin.coupons');
    Route::get('/admin/coupons/add', [CouponController::class, 'add'])->name('admin.coupons.add');
    Route::get('/admin/coupons/{id}', [CouponController::class, 'coupon'])->name('admin.coupons.view');
    Route::post('/admin/coupons/add', [CouponController::class, 'post'])->name('admin.coupons.post');
    Route::patch('/admin/coupons/{id}', [CouponController::class, 'patch'])->name('admin.coupons.patch');

    // Additional Coupon Management
    Route::get('/admin/additional-coupons/', [\App\Http\Controllers\Admin\AdditionalCouponCodeController::class, 'index'])->name('admin.coupons.additional');
    Route::get('/admin/additional-coupons/add/', [\App\Http\Controllers\Admin\AdditionalCouponCodeController::class, 'add'])->name('admin.coupons.add.additional');
    Route::get('/admin/additional-coupons/{id}/', [\App\Http\Controllers\Admin\AdditionalCouponCodeController::class, 'coupon'])->name('admin.coupons.view.additional');
    Route::post('/admin/additional-coupons/add/', [\App\Http\Controllers\Admin\AdditionalCouponCodeController::class, 'post'])->name('admin.coupons.post.additional');
    Route::patch('/admin/additional-coupons/{id}/', [\App\Http\Controllers\Admin\AdditionalCouponCodeController::class, 'patch'])->name('admin.coupons.patch.additional');


    // Gallery Management
    Route::get('/admin/gallery', [GalleryController::class, 'index'])->name('admin.gallery');
    Route::get('/admin/gallery/add', [GalleryController::class, 'add'])->name('admin.gallery.add');
    Route::post('/admin/gallery/add', [GalleryController::class, 'post'])->name('admin.gallery.post');
    Route::get('/admin/gallery/{item}', [GalleryController::class, 'edit'])->name('admin.gallery.edit');
    Route::get('/admin/gallery/{item}/delete', [GalleryController::class, 'deleteForm'])->name('admin.gallery.deleteform');
    Route::delete('/admin/gallery/{item}/delete', [GalleryController::class, 'delete'])->name('admin.gallery.delete');
    Route::patch('/admin/gallery/{item}', [GalleryController::class, 'patch'])->name('admin.gallery.patch');

    // Logs Management
    Route::get('/admin/logs', [LogsController::class, 'index'])->name('admin.logs');
    Route::get('/admin/logs/{id}', [LogsController::class, 'get'])->name('admin.logs.{id}');

    Route::resource('/admin/tax-rate', \App\Http\Controllers\Admin\TaxRatesController::class);
    Route::resource('/admin/support-pages', \App\Http\Controllers\Admin\SupportPagesController::class);

    Route::get('/export', [OrderController::class, 'export'])->name('export');
    Route::get('/admin/subscribe/{user}/{order}/{date}', [SubscriptionController::class, 'subscribeUser']);
    Route::get('/admin/charge/{user}/{order}', [SubscriptionController::class, 'chargeUser']);
    Route::get('/admin/update-payment/{user}/{cc}/{m}/{y}/{cvv}', [SubscriptionController::class, 'updateUser']);

    // Templates Management
    Route::get('/admin/templates', [\App\Http\Controllers\Admin\TemplatesController::class, 'index'])->name('admin.templates');
    Route::get('/admin/templates/add', [\App\Http\Controllers\Admin\TemplatesController::class, 'add'])->name('admin.templates.add');
    Route::post('/admin/templates/add', [\App\Http\Controllers\Admin\TemplatesController::class, 'post'])->name('admin.templates.post');
    Route::get('/admin/templates/{mainTemplate}', [\App\Http\Controllers\Admin\TemplatesController::class, 'edit'])->name('admin.templates.edit');
    Route::get('/admin/templates/{mainTemplate}/delete', [\App\Http\Controllers\Admin\TemplatesController::class, 'deleteForm'])->name('admin.templates.deleteform');
    Route::delete('/admin/templates/{mainTemplate}/delete', [\App\Http\Controllers\Admin\TemplatesController::class, 'delete'])->name('admin.templates.delete');
    Route::patch('/admin/templates/{mainTemplate}', [\App\Http\Controllers\Admin\TemplatesController::class, 'patch'])->name('admin.templates.patch');
    Route::get('/admin/templates/getUserList/{mainTemplate}', [\App\Http\Controllers\Admin\TemplatesController::class, 'getUserList'])->name('admin.templates.getUserList');

    Route::get('/admin/upcoming-transactions', [\App\Http\Controllers\Admin\UpcomingTransactionsController::class, 'index'])->name('upcoming-transactions');
    Route::get('/admin/upcoming-transactions/change-price/{subscription}', [\App\Http\Controllers\Admin\UpcomingTransactionsController::class, 'changePrice'])->name('upcoming-transactions.change-price');
    Route::post('/admin/upcoming-transactions/do-change-price', [\App\Http\Controllers\Admin\UpcomingTransactionsController::class, 'doChangePrice'])->name('upcoming-transactions.do-change-price');
    Route::get('/admin/failed-transactions', [\App\Http\Controllers\Admin\FailedTransactionsController::class, 'index'])->name('failed-transactions');

    Route::get('admin/subscription/{subscription}/updateto/{type}/', [SubscriptionController::class, 'updateSubscriptionType'])->name('update.subscription.type');

    Route::get('admin/sales-rep', [\App\Http\Controllers\Admin\SalesRep::class, 'index'])->name('admin.sales-rep.index');
    Route::get('admin/sales-rep-add', [\App\Http\Controllers\Admin\SalesRep::class, 'add'])->name('admin.sales-rep.add');
    Route::post('admin/sales-rep-store', [\App\Http\Controllers\Admin\SalesRep::class, 'store'])->name('admin.sales-rep-store');
    Route::delete('admin/sales-rep', [\App\Http\Controllers\Admin\SalesRep::class, 'destroy'])->name('admin.sales-rep.delete');
    Route::get('admin/sales-rep/manage/{subscription}', [\App\Http\Controllers\Admin\SalesRep::class, 'manage'])->name('admin.sales-rep-manage');
    Route::post('admin/sales-rep/assign/{subscription}', [\App\Http\Controllers\Admin\SalesRep::class, 'assign'])->name('admin.sales-rep-assign');
    Route::get('admin/sales-rep/export', [\App\Http\Controllers\Admin\SalesRep::class, 'export'])->name('admin.sales-rep.export');

    Route::get('admin/partner-company', [\App\Http\Controllers\Admin\PartnerCompanyController::class, 'index'])->name('admin.partner-company.index');
    Route::get('admin/partner-company-add', [\App\Http\Controllers\Admin\PartnerCompanyController::class, 'add'])->name('admin.partner-company.add');
    Route::post('admin/partner-company-store', [\App\Http\Controllers\Admin\PartnerCompanyController::class, 'store'])->name('admin.partner-company-store');
    Route::delete('admin/partner-company', [\App\Http\Controllers\Admin\PartnerCompanyController::class, 'destroy'])->name('admin.partner-company.delete');
    Route::get('admin/partner-company/manage/{subscription}', [\App\Http\Controllers\Admin\PartnerCompanyController::class, 'manage'])->name('admin.partner-company-manage');
    Route::post('admin/partner-company/assign/{subscription}', [\App\Http\Controllers\Admin\PartnerCompanyController::class, 'assign'])->name('admin.partner-company-assign');
    Route::get('admin/partner-company/export', [\App\Http\Controllers\Admin\PartnerCompanyController::class, 'export'])->name('admin.partner-company.export');

    Route::post('admin/subscriptions/lead', [SubscriptionController::class, 'leads'])->name('subscriptions.leads');
    Route::get('admin/subscriptions/{subscription}/status-states', [SubscriptionController::class, 'statusStates'])->name('subscriptions.status-states');
    Route::get('admin/subscriptions/{subscription}/cancel', [SubscriptionController::class, 'adminCancel'])->name('admin-cancel-subscription');
    Route::get('admin/subscriptions/canceled', [SubscriptionController::class, 'canceled'])->name('admin-canceled-subscription');

    Route::get('admin/leads', [\App\Http\Controllers\Admin\LeadsController::class, 'index'])->name('admin.leads.index');
    Route::get('admin/leads/add', [\App\Http\Controllers\Admin\LeadsController::class, 'add'])->name('admin.leads.add');
    Route::post('admin/leads/store', [\App\Http\Controllers\Admin\LeadsController::class, 'store'])->name('admin.leads.store');
});

// Legal (ToS & Privacy Policy)
Route::get('/terms-conditions', function() {
    return view('terms-conditions');
})->name('terms-conditions');

Route::get('/privacy-policy', function() {
    return view('privacy-policy');
})->name('privacy-policy');

/**
 * Routes for Support pages from the database
 */
if(\Illuminate\Support\Facades\Schema::hasTable('support_pages')) {
    $supportPages = \App\Models\SupportPage::all();
    if ($supportPages) {
        foreach ($supportPages as $page) {
            Route::view($page->url, 'support', ['page' => $page]);
        }
    }
}

Route::get('support-form', function () {
    return view('support-form');
})->name('support.form');

Route::post('/webhook/authorize', [\App\Http\Controllers\WebhooksController::class, 'authorizeWebHook'])->name('authorize.webhook');


Route::get('normalize-subs', function () {
    return;
    $allSubs = Subscription::all();
    $now = Carbon::now();
    foreach ($allSubs as $subscription) {
        if($subscription->term == 'yearly') {
            $yearsAfterFirstSubscription = $now->diffInYears($subscription->created_at->format('Y-m-d'));
            $endsAt = $subscription->created_at->copy()->addYear($yearsAfterFirstSubscription + 1);
        } else {
            $monthsAfterFirstSubscription = $now->diffInMonths($subscription->created_at->format('Y-m-d'));
            $endsAt = $subscription->created_at->copy()->addMonth($monthsAfterFirstSubscription + 1);
        }
        $subscription->end_at = $endsAt;
        $subscription->save();
    }
});

Route::get('test-internal-subs', function (\App\Helpers\ChargeSubscriptions $chargeSubscriptions, CustomerProfileService $customerProfileService, PaymentRepository $paymentRepository) {
//    return;
    $now = Carbon::now();
    $subscriptions = Subscription::whereDate('end_at', $now)
        ->where('should_cancel_at', '=', null)
        ->where('status', '!=', Subscription::STATUS_CANCELED)->get();
//    dd($subscriptions);
    foreach ($subscriptions as $subscription) {
        if($subscription->switch_to) {
            $subscription->term = $subscription->switch_to;
            $subscription->switch_to = null;
            $subscription->save();
            $order = Order::find($subscription->order_id);
            $order->term = $subscription->term;
            $order->save();
        }
        if(!$subscription->order) {
            continue;
        }
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
        if(!$subscription->user->authorize_customer_id || !$subscription->user->authorize_customer_address_id || !$subscription->user->authorize_customer_payment_profile_id) {
            continue;
        }
        $chargeResponse = $customerProfileService->charge($subscription->user, $price, $subscription->order, 'Subscription charge');
        if($chargeResponse->isSuccessful()) {
            $transaction = $paymentRepository->createTransactionFromCompletedAttempt($chargeResponse->getReference(), $subscription->order);
            if($subscription->term == 'yearly') {
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
});

Route::get('reactivate-email-cancel/{code}', function($code) {
    $subscription = Subscription::where('reactivate_email_cancel_code', $code)->first();
    if(!$subscription) {
        return redirect()->to('/');
    } else {
        $subscription->reactivation_email_count = 99;
        $subscription->save();

        return view('reactivation_unsubscribe');
    }
})->name('reactivate-email-cancel');

Route::get('test-payment-response/{amount}', function(CustomerProfileService $customerProfileService, PaymentRepository $paymentRepository, $amount) {
   $user = Auth::user();
//   $user = User::find(8);
   $subscription = Subscription::where('user_id', $user->id)->where('status', Subscription::STATUS_ACTIVE)->first();
   $order = $subscription->order;
   $response = $customerProfileService->charge($user, $amount, $order, 'Response test');
   dd($response);

});


//Route::get('test-distance', function () {
//    var_dump(config('app.distance'));
//    $point1 = new stdClass();
//    $point1->latitude = '46.755562';
//    $point1->longitude = '-116.968211';
//
//    $point2 = new stdClass();
//    $point2->latitude = '37.781797';
//    $point2->longitude = '-122.424231';
//
//   $distance = \App\Models\OperateLocation::calculateDistance($point1, $point2);
//   dd($distance);
//});

//Route::get('change-status', function() {
//   $user = Auth::user();
//   $subscription = Subscription::where('user_id', $user->id)->first();
//   $subscription->status = 'unpaid';
//   $subscription->save();
//});
