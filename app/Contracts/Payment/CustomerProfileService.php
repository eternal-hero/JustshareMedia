<?php


namespace App\Contracts\Payment;


use App\Contracts\Payment\GatewayObjects\ARBSubscription;
use App\Contracts\Payment\GatewayObjects\ARBSubscriptionRequest;
use App\Contracts\Payment\GatewayObjects\CreditCard;
use App\Contracts\Payment\GatewayObjects\CustomerAddress;
use App\Contracts\Payment\GatewayObjects\CustomerData;
use App\Contracts\Payment\GatewayObjects\CustomerExProfile;
use App\Contracts\Payment\GatewayObjects\CustomerPaymentProfile;
use App\Contracts\Payment\GatewayObjects\CustomerProfile;
use App\Contracts\Payment\GatewayObjects\CustomerProfileId;
use App\Contracts\Payment\GatewayObjects\CustomerProfilePayment;
use App\Contracts\Payment\GatewayObjects\IntervalA;
use App\Contracts\Payment\GatewayObjects\Order;
use App\Contracts\Payment\GatewayObjects\Payment;
use App\Contracts\Payment\GatewayObjects\PaymentProfile;
use App\Contracts\Payment\GatewayObjects\PaymentSchedule;
use App\Contracts\Payment\GatewayObjects\Setting;
use App\Contracts\Payment\GatewayObjects\TransactionRequest;
use App\Contracts\Payment\RequestAttemptResponses\ARBCancelSubscriptionAttemptResponse;
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
use App\Models\PendingSubscription;
use App\Models\Subscription;
use App\Models\User;
use App\Services\Payment\RequestHandlers\UpdateCustomerAddressRequest;

/**
 * Interface CustomerProfileService
 * @package App\Contracts\Payment
 */
interface CustomerProfileService {
    /**
     * CustomerProfileService constructor.
     * @param CreditCard $creditCard
     * @param Payment $payment
     * @param CustomerAddress $customerAddress
     * @param CustomerPaymentProfile $customerPaymentProfile
     * @param CustomerProfile $customerProfile
     * @param CreateCustomerProfileRequestHandler $createCustomerPaymentProfileRequest
     * @param CustomerProfileCreateAttemptResponse $customerProfileCreateAttemptResponse
     *
     * @param UpdateCustomerProfileRequestHandler $updateCustomerProfileRequestHandler
     * @param CustomerProfileUpdateAttemptResponse $customerProfileUpdateAttemptResponse
     *
     * @param CustomerProfilePayment $customerProfilePayment
     * @param PaymentProfile $paymentProfile
     *
     * @param CustomerExProfile $customerPaymentProfileExType
     *
     * @param TransactionRequest $transactionRequest
     * @param CreateTransactionRequestHandler $createTransactionRequest
     * @param ChargeCustomerProfileAttemptResponse $chargeCustomerProfileAttemptResponse
     * @param IntervalA $intervalAType
     * @param PaymentSchedule $paymentScheduleType
     * @param Order $orderType
     * @param CustomerProfileId $customerProfileIdType
     * @param ARBSubscription $ARBSubscription
     * @param UpdateCustomerAddressRequestHandler $updateCustomerAddressRequestHandler
     * @param DeleteCustomerProfileRequestHandler $deleteCustomerProfileRequestHandler
     * @param ARBCreateSubscriptionRequestHandler $ARBCreateSubscriptionRequest
     * @param SubscribeUserAttemptResponse $subscribeUserAttemptResponse
     * @param ARBCancelSubscriptionRequestHandler $ARBCancelSubscriptionRequestHandler
     * @param ARBCancelSubscriptionAttemptResponse $ARBCancelSubscriptionAttemptResponse
     * @param CustomerData $customerData
     * @param Setting $setting
     */
    public function __construct(
        CreditCard $creditCard,
        Payment $payment,
        CustomerAddress $customerAddress,
        CustomerPaymentProfile $customerPaymentProfile,
        CustomerProfile $customerProfile,
        CreateCustomerProfileRequestHandler $createCustomerPaymentProfileRequest,
        CustomerProfileCreateAttemptResponse $customerProfileCreateAttemptResponse,

        UpdateCustomerProfileRequestHandler $updateCustomerProfileRequestHandler,
        CustomerProfileUpdateAttemptResponse $customerProfileUpdateAttemptResponse,


        CustomerProfilePayment $customerProfilePayment,
        PaymentProfile $paymentProfile,

        CustomerExProfile $customerPaymentProfileExType,


        TransactionRequest $transactionRequest,
        CreateTransactionRequestHandler $createTransactionRequest,
        ChargeCustomerProfileAttemptResponse $chargeCustomerProfileAttemptResponse,
        IntervalA $intervalAType,
        PaymentSchedule $paymentScheduleType,
        Order $orderType,
        CustomerProfileId $customerProfileIdType,
        ARBSubscription $ARBSubscription,

        UpdateCustomerAddressRequestHandler $updateCustomerAddressRequestHandler,
        DeleteCustomerProfileRequestHandler $deleteCustomerProfileRequestHandler,


        ARBCreateSubscriptionRequestHandler $ARBCreateSubscriptionRequest,
        SubscribeUserAttemptResponse $subscribeUserAttemptResponse,
        ARBCancelSubscriptionRequestHandler $ARBCancelSubscriptionRequestHandler,
        ARBCancelSubscriptionAttemptResponse $ARBCancelSubscriptionAttemptResponse,
        CustomerData $customerData,
        Setting $setting,
    );

    /**
     * @param CustomerProfileParams $customerProfileParams
     * @return CustomerProfileCreateAttemptResponse
     */
    public function create(CustomerProfileParams $customerProfileParams) : CustomerProfileCreateAttemptResponse;
    public function charge(User $user, float $amount, \App\Models\Order $order, string $description) : ChargeCustomerProfileAttemptResponse;
    public function subscribe(PendingSubscription $pendingSubscription) : SubscribeUserAttemptResponse;
    public function cancelSubscription(Subscription $subscription) : ARBCancelSubscriptionAttemptResponse;
    public function chargeCard(CustomerProfileParams $customerProfileParams, \App\Models\Order $order, float $amount, string $description) : ChargeCustomerProfileAttemptResponse;
    public function update(\App\Services\Payment\CustomerProfileParams $customerProfileParams, CustomerAddress $customerAddress) : CustomerProfileUpdateAttemptResponse;

}
