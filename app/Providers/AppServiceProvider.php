<?php

namespace App\Providers;


use App\Contracts\Payment\GatewayObjects\ARBSubscription;
use App\Contracts\Payment\GatewayObjects\CustomerData;
use App\Contracts\Payment\GatewayObjects\CustomerExProfile;
use App\Contracts\Payment\GatewayObjects\CustomerProfileId;
use App\Contracts\Payment\GatewayObjects\CustomerProfilePayment;
use App\Contracts\Payment\GatewayObjects\IntervalA;
use App\Contracts\Payment\GatewayObjects\Order;
use App\Contracts\Payment\GatewayObjects\PaymentProfile;
use App\Contracts\Payment\GatewayObjects\PaymentSchedule;
use App\Contracts\Payment\GatewayObjects\Setting;
use App\Contracts\Payment\GatewayObjects\TransactionRequest;
use App\Contracts\Payment\RequestAttemptResponses\ChargeCustomerProfileAttemptResponse;
use App\Contracts\Payment\RequestAttemptResponses\CustomerProfileCreateAttemptResponse;
use App\Contracts\Payment\RequestAttemptResponses\CustomerProfileUpdateAttemptResponse;
use App\Contracts\Payment\RequestAttemptResponses\SubscribeUserAttemptResponse;
use App\Contracts\Payment\RequestHandlers\ARBCancelSubscriptionRequestHandler;
use App\Contracts\Payment\RequestHandlers\ARBCreateSubscriptionRequestHandler;
use App\Contracts\Payment\RequestHandlers\CreateCustomerProfileRequestHandler;
use App\Contracts\Payment\RequestHandlers\CreateTransactionRequestHandler;
use App\Contracts\Payment\RequestHandlers\DeleteCustomerProfileRequestHandler;
use App\Contracts\Payment\RequestHandlers\UpdateCustomerAddressRequestHandler;
use App\Contracts\Payment\RequestHandlers\UpdateCustomerProfileRequestHandler;
use App\Services\Payment\GatewayObjects\CreditCard;
use App\Services\Payment\GatewayObjects\CustomerAddress;
use App\Services\Payment\GatewayObjects\CustomerPaymentProfile;
use App\Services\Payment\GatewayObjects\CustomerProfile;
use App\Services\Payment\GatewayObjects\Payment;
use App\Services\Payment\PaymentAuth;
use App\Services\Payment\RequestAttemptResponses\ARBCancelSubscriptionAttemptResponse;
use App\Services\Payment\RequestHandlers\ARBSubscriptionRequest;
use App\Services\Payment\RequestHandlers\CreateTransactionRequest;
use App\Services\Payment\RequestHandlers\CustomerPaymentProfileRequest;
use App\Services\Payment\RequestHandlers\CustomerProfileUpdateRequest;
use App\Services\Payment\RequestHandlers\UpdateCustomerAddressRequest;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use net\authorize\api\contract\v1\ARBCancelSubscriptionRequest;
use net\authorize\api\contract\v1\ARBCreateSubscriptionRequest;
use net\authorize\api\contract\v1\ARBSubscriptionType;
use net\authorize\api\contract\v1\CreateCustomerProfileRequest;
use net\authorize\api\contract\v1\CreditCardType;
use net\authorize\api\contract\v1\CustomerAddressType;
use net\authorize\api\contract\v1\CustomerDataType;
use net\authorize\api\contract\v1\CustomerPaymentProfileExType;
use net\authorize\api\contract\v1\CustomerPaymentProfileType;
use net\authorize\api\contract\v1\CustomerProfileExType;
use net\authorize\api\contract\v1\CustomerProfileIdType;
use net\authorize\api\contract\v1\CustomerProfilePaymentType;
use net\authorize\api\contract\v1\CustomerProfileType;
use net\authorize\api\contract\v1\DeleteCustomerProfileRequest;
use net\authorize\api\contract\v1\MerchantAuthenticationType;
use net\authorize\api\contract\v1\OrderType;
use net\authorize\api\contract\v1\PaymentProfileType;
use net\authorize\api\contract\v1\PaymentScheduleType;
use net\authorize\api\contract\v1\PaymentScheduleType\IntervalAType;
use net\authorize\api\contract\v1\PaymentType;
use net\authorize\api\contract\v1\SettingType;
use net\authorize\api\contract\v1\TransactionRequestType;
use net\authorize\api\contract\v1\UpdateCustomerPaymentProfileRequest;
use net\authorize\api\contract\v1\UpdateCustomerProfileRequest;
use net\authorize\api\controller\DeleteCustomerProfileController;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Mapping Payment types
        $this->app->bind(\App\Contracts\Payment\GatewayObjects\CreditCard::class, function ($app) {
            $type = new CreditCardType();
            return new CreditCard($type);
        });
        $this->app->bind(\App\Contracts\Payment\GatewayObjects\Payment::class, function ($app) {
            $type = new PaymentType();
            return new Payment($type);
        });
        $this->app->bind(\App\Contracts\Payment\GatewayObjects\CustomerAddress::class, function ($app) {
            $type = new CustomerAddressType();
            return new CustomerAddress($type);
        });
        $this->app->bind(\App\Contracts\Payment\GatewayObjects\CustomerPaymentProfile::class, function ($app) {
            $type = new CustomerPaymentProfileType();
            return new CustomerPaymentProfile($type);
        });
        $this->app->bind(\App\Contracts\Payment\GatewayObjects\CustomerProfile::class, function ($app) {
            $type = new CustomerProfileType();
            return new CustomerProfile($type);
        });
        $this->app->bind(CustomerProfilePayment::class, function ($app) {
            $type = new CustomerProfilePaymentType();
            return new \App\Services\Payment\GatewayObjects\CustomerProfilePayment($type);
        });
        $this->app->bind(CustomerExProfile::class, function ($app) {
            $type = new CustomerPaymentProfileExType();
            return new \App\Services\Payment\GatewayObjects\CustomerExProfile($type);
        });
        $this->app->bind(PaymentProfile::class, function ($app) {
            $type = new PaymentProfileType();
            return new \App\Services\Payment\GatewayObjects\PaymentProfile($type);
        });
        $this->app->bind(TransactionRequest::class, function ($app) {
            $type = new TransactionRequestType();
            return new \App\Services\Payment\GatewayObjects\TransactionRequest($type);
        });
        $this->app->bind(IntervalA::class, function ($app) {
            $type = new IntervalAType();
            return new \App\Services\Payment\GatewayObjects\IntervalA($type);
        });
        $this->app->bind(PaymentSchedule::class, function ($app) {
            $type = new PaymentScheduleType();
            return new \App\Services\Payment\GatewayObjects\PaymentSchedule($type);
        });
        $this->app->bind(Order::class, function ($app) {
            $type = new OrderType();
            return new \App\Services\Payment\GatewayObjects\Order($type);
        });
        $this->app->bind(CustomerProfileId::class, function ($app) {
            $type = new CustomerProfileIdType();
            return new \App\Services\Payment\GatewayObjects\CustomerProfileId($type);
        });
        $this->app->bind(ARBSubscription::class, function ($app) {
            $type = new ARBSubscriptionType();
            return new \App\Services\Payment\GatewayObjects\ARBSubscription($type);
        });
        $this->app->bind(CustomerData::class, function ($app) {
            $type = new CustomerDataType();
            return new \App\Services\Payment\GatewayObjects\CustomerData($type);
        });
        $this->app->bind(Setting::class, function ($app) {
            $type = new SettingType();
            return new \App\Services\Payment\GatewayObjects\Setting($type);
        });

        // Prepare request handlers with merchant type and auth

        $this->app->bind(UpdateCustomerAddressRequestHandler::class, function () {
            $merchantAuthenticationType = new MerchantAuthenticationType();
            $paymentAuth = new PaymentAuth($merchantAuthenticationType);
            $request = new UpdateCustomerPaymentProfileRequest();
            $exType = new CustomerPaymentProfileExType();
            return new UpdateCustomerAddressRequest($paymentAuth, $request, $exType);
        });

        $this->app->bind(DeleteCustomerProfileRequestHandler::class, function ($app) {
            $merchantAuthenticationType = new MerchantAuthenticationType();
            $paymentAuth = new PaymentAuth($merchantAuthenticationType);
            $request = new DeleteCustomerProfileRequest();
            return new \App\Services\Payment\RequestHandlers\DeleteCustomerProfileRequest($paymentAuth, $request);
        });

        $this->app->bind(CreateTransactionRequestHandler::class, function ($app) {
            $merchantAuthenticationType = new MerchantAuthenticationType();
            $paymentAuth = new PaymentAuth($merchantAuthenticationType);
            $request = new \net\authorize\api\contract\v1\CreateTransactionRequest();
            return new CreateTransactionRequest($paymentAuth, $request);
        });
        $this->app->bind(UpdateCustomerProfileRequestHandler::class, function ($app) {
            $merchantAuthenticationType = new MerchantAuthenticationType();
            $paymentAuth = new PaymentAuth($merchantAuthenticationType);
            $request = new \net\authorize\api\contract\v1\UpdateCustomerPaymentProfileRequest();
            return new CustomerProfileUpdateRequest($paymentAuth, $request);
        });
        $this->app->bind(CreateCustomerProfileRequestHandler::class, function ($app) {
            $merchantAuthenticationType = new MerchantAuthenticationType();
            $paymentAuth = new PaymentAuth($merchantAuthenticationType);
            $request = new CreateCustomerProfileRequest();
            return new CustomerPaymentProfileRequest($paymentAuth, $request);
        });
        $this->app->bind(ARBCreateSubscriptionRequestHandler::class, function ($app) {
            $merchantAuthenticationType = new MerchantAuthenticationType();
            $paymentAuth = new PaymentAuth($merchantAuthenticationType);
            $request = new ARBCreateSubscriptionRequest();
            return new ARBSubscriptionRequest($paymentAuth, $request);
        });
        $this->app->bind(ARBCancelSubscriptionRequestHandler::class, function ($app) {
            $merchantAuthenticationType = new MerchantAuthenticationType();
            $paymentAuth = new PaymentAuth($merchantAuthenticationType);
            $request = new ARBCancelSubscriptionRequest();
            return new \App\Services\Payment\RequestHandlers\ARBCancelSubscriptionRequest($paymentAuth, $request);
        });

        // Map Attempt Responses
        $this->app->bind(ChargeCustomerProfileAttemptResponse::class, function ($app) {
            return new \App\Services\Payment\RequestAttemptResponses\ChargeCustomerProfileAttemptResponse();
        });
        $this->app->bind(CustomerProfileUpdateAttemptResponse::class, function ($app) {
            return new \App\Services\Payment\RequestAttemptResponses\CustomerProfileUpdateAttemptResponse();
        });

        $this->app->bind(CustomerProfileCreateAttemptResponse::class, function ($app) {
            return new \App\Services\Payment\RequestAttemptResponses\CustomerProfileCreateAttemptResponse();
        });
        $this->app->bind(SubscribeUserAttemptResponse::class, function ($app) {
            return new \App\Services\Payment\RequestAttemptResponses\SubscribeUserAttemptResponse();
        });
        $this->app->bind(\App\Contracts\Payment\RequestAttemptResponses\ARBCancelSubscriptionAttemptResponse::class, function ($app) {
            return new \App\Services\Payment\RequestAttemptResponses\ARBCancelSubscriptionAttemptResponse();
        });


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191); // Required for mariadb

        /**
         * Force HTTPS in routes
        */
       /* if (config('app.env') != 'production') {
            URL::forceScheme('https');
        }*/
    }
}
