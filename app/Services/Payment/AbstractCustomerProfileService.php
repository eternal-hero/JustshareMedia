<?php


namespace App\Services\Payment;


use App\Contracts\Payment\CustomerProfileParams;
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
use App\Models\User;
use App\Services\Payment\RequestHandlers\UpdateCustomerAddressRequest;
use net\authorize\api\contract\v1\ARBSubscriptionType;
use net\authorize\api\contract\v1\CreditCardType;
use net\authorize\api\contract\v1\CustomerAddressType;
use net\authorize\api\contract\v1\CustomerDataType;
use net\authorize\api\contract\v1\CustomerPaymentProfileExType;
use net\authorize\api\contract\v1\CustomerPaymentProfileType;
use net\authorize\api\contract\v1\CustomerProfileIdType;
use net\authorize\api\contract\v1\CustomerProfilePaymentType;
use net\authorize\api\contract\v1\CustomerProfileType;
use net\authorize\api\contract\v1\OrderType;
use net\authorize\api\contract\v1\PaymentProfileType;
use net\authorize\api\contract\v1\PaymentScheduleType;
use net\authorize\api\contract\v1\PaymentScheduleType\IntervalAType as IntervalType;
use net\authorize\api\contract\v1\PaymentType;
use net\authorize\api\contract\v1\SettingType;
use net\authorize\api\contract\v1\TransactionRequestType;

class AbstractCustomerProfileService
{
    /**
     * @var CreditCard
     */
    protected CreditCard $creditCard;
    /**
     * @var Payment
     */
    protected Payment $payment;
    /**
     * @var CustomerAddress
     */
    protected CustomerAddress $customerAddress;
    /**
     * @var CustomerPaymentProfile
     */
    protected CustomerPaymentProfile $customerPaymentProfile;
    /**
     * @var CustomerProfile
     */
    protected CustomerProfile $customerProfile;
    /**
     * @var CustomerExProfile
     */
    protected CustomerExProfile $customerPaymentProfileExType;
    /**
     * @var CreateCustomerProfileRequestHandler
     */
    protected CreateCustomerProfileRequestHandler $customerPaymentProfileRequestHandler;
    /**
     * @var CustomerProfileCreateAttemptResponse
     */
    protected CustomerProfileCreateAttemptResponse $customerProfileCreateAttemptResponse;



    // REQUEST HANDLERS

    protected UpdateCustomerAddressRequestHandler $updateCustomerAddressRequestHandler;

    protected DeleteCustomerProfileRequestHandler $deleteCustomerProfileRequestHandler;
        /**
     * @var UpdateCustomerProfileRequestHandler
     */
    protected UpdateCustomerProfileRequestHandler $updateCustomerProfileRequestHandler;
    /**
     * @var CustomerProfileUpdateAttemptResponse
     */
    protected CustomerProfileUpdateAttemptResponse $customerProfileUpdateAttemptResponse;


    /**
     * @var CustomerProfilePayment
     */
    protected CustomerProfilePayment $customerProfilePayment;
    /**
     * @var PaymentProfile
     */
    protected PaymentProfile $paymentProfile;

    /**
     * @var \App\Contracts\Payment\GatewayObjects\TransactionRequest
     */
    protected \App\Contracts\Payment\GatewayObjects\TransactionRequest $transactionRequest;
    /**
     * @var CreateTransactionRequestHandler
     */
    protected CreateTransactionRequestHandler $createTransactionRequestHandler;

    /**
     * @var ChargeCustomerProfileAttemptResponse
     */
    protected ChargeCustomerProfileAttemptResponse $chargeCustomerProfileAttemptResponse;
    /**
     * @var IntervalA
     */
    protected IntervalA $intervalAType;
    /**
     * @var PaymentSchedule
     */
    protected PaymentSchedule $paymentSchedule;
    /**
     * @var Order
     */
    protected Order $order;
    /**
     * @var CustomerProfileId
     */
    protected CustomerProfileId $customerProfileId;
    /**
     * @var ARBSubscription
     */
    protected ARBSubscription $ARBSubscription;
    /**
     * @var ARBSubscriptionRequest
     */
    protected ARBSubscriptionRequest $ARBSubscriptionRequest;
    /**
     * @var ARBCreateSubscriptionRequestHandler
     */
    protected ARBCreateSubscriptionRequestHandler $ARBCreateSubscriptionRequestHandler;
    /**
     * @var SubscribeUserAttemptResponse
     */
    protected SubscribeUserAttemptResponse $subscribeUserAttemptResponse;
    /**
     * @var ARBCancelSubscriptionAttemptResponse
     */
    protected ARBCancelSubscriptionAttemptResponse $ARBCancelSubscriptionAttemptResponse;
    /**
     * @var ARBCancelSubscriptionRequestHandler
     */
    protected ARBCancelSubscriptionRequestHandler $ARBCancelSubscriptionRequestHandler;
    /**
     * @var CustomerData
     */
    private CustomerData $customerData;
    /**
     * @var Setting
     */
    private Setting $setting;

    public function __construct(
        CreditCard $creditCard,
        Payment $payment,
        CustomerAddress $customerAddress,
        CustomerPaymentProfile $customerPaymentProfile,
        CustomerProfile $customerProfile,
        CreateCustomerProfileRequestHandler $customerPaymentProfileRequestHandler,
        CustomerProfileCreateAttemptResponse $customerProfileCreateAttemptResponse,

        UpdateCustomerProfileRequestHandler $updateCustomerProfileRequestHandler,
        CustomerProfileUpdateAttemptResponse $customerProfileUpdateAttemptResponse,

        CustomerProfilePayment $customerProfilePayment,

        PaymentProfile $paymentProfile,
        CustomerExProfile $customerPaymentProfileExType,


        \App\Contracts\Payment\GatewayObjects\TransactionRequest $transactionRequest,
        CreateTransactionRequestHandler $createTransactionRequestHandler,
        ChargeCustomerProfileAttemptResponse $chargeCustomerProfileAttemptResponse,
        IntervalA $intervalAType,
        PaymentSchedule $paymentSchedule,
        Order $order,
        CustomerProfileId $customerProfileId,
        ARBSubscription $ARBSubscription,

        UpdateCustomerAddressRequestHandler $updateCustomerAddressRequestHandler,

        DeleteCustomerProfileRequestHandler $deleteCustomerProfileRequestHandler,
        ARBCreateSubscriptionRequestHandler $ARBCreateSubscriptionRequestHandler,
        SubscribeUserAttemptResponse $subscribeUserAttemptResponse,
        ARBCancelSubscriptionRequestHandler $ARBCancelSubscriptionRequestHandler,
        ARBCancelSubscriptionAttemptResponse $ARBCancelSubscriptionAttemptResponse,
        CustomerData $customerData,
        Setting $setting
    ) {
        $this->creditCard = $creditCard;
        $this->payment = $payment;
        $this->customerAddress = $customerAddress;
        $this->customerPaymentProfile = $customerPaymentProfile;
        $this->customerProfile = $customerProfile;
        $this->customerPaymentProfileRequestHandler = $customerPaymentProfileRequestHandler;
        $this->customerProfileCreateAttemptResponse = $customerProfileCreateAttemptResponse;


        $this->updateCustomerProfileRequestHandler = $updateCustomerProfileRequestHandler;
        $this->customerProfileUpdateAttemptResponse = $customerProfileUpdateAttemptResponse;


        $this->customerProfilePayment = $customerProfilePayment;
        $this->customerPaymentProfileExType = $customerPaymentProfileExType;
        $this->paymentProfile = $paymentProfile;
        $this->transactionRequest = $transactionRequest;
        $this->createTransactionRequestHandler = $createTransactionRequestHandler;
        $this->chargeCustomerProfileAttemptResponse = $chargeCustomerProfileAttemptResponse;
        $this->intervalAType = $intervalAType;
        $this->paymentSchedule = $paymentSchedule;
        $this->order = $order;
        $this->customerProfileId = $customerProfileId;
        $this->ARBSubscription = $ARBSubscription;

        $this->deleteCustomerProfileRequestHandler = $deleteCustomerProfileRequestHandler;
        $this->updateCustomerAddressRequestHandler = $updateCustomerAddressRequestHandler;


        $this->ARBCreateSubscriptionRequestHandler = $ARBCreateSubscriptionRequestHandler;
        $this->subscribeUserAttemptResponse = $subscribeUserAttemptResponse;
        $this->ARBCancelSubscriptionRequestHandler = $ARBCancelSubscriptionRequestHandler;
        $this->ARBCancelSubscriptionAttemptResponse = $ARBCancelSubscriptionAttemptResponse;
        $this->customerData = $customerData;
        $this->setting = $setting;
    }

    /**
     * @param int $length
     * @param string $units
     * @return IntervalType
     */
    protected function createInterval(int $length, $units = 'months') : IntervalType {
        $this->intervalAType->setLength($length);
        $this->intervalAType->setUnit($units);

        return $this->intervalAType->getInterval();
    }

    /**
     * @param IntervalType $intervalAType
     * @param \DateTime $startDate
     * @param int $totalOccurrences
     * @return PaymentScheduleType
     */
    protected function createPaymentSchedule(IntervalType $intervalAType, \DateTime $startDate, int $totalOccurrences) : PaymentScheduleType {
        $this->paymentSchedule->setInterval($intervalAType);
        $this->paymentSchedule->setStartDate($startDate);
        $this->paymentSchedule->setTotalOccurrences($totalOccurrences);

        return $this->paymentSchedule->getSchedule();
    }

    /**
     * @param string $invoiceNumber
     * @param string $description
     * @return OrderType
     */
    protected function createOrder(string $invoiceNumber, string $description) : OrderType {
        $this->order->setInvoiceNumber($invoiceNumber);
        $this->order->setDescription($description);

        return $this->order->getOrder();
    }

    /**
     * @param User $user
     * @return CustomerProfileIdType
     */
    protected function createCustomerProfileId(User $user) : CustomerProfileIdType {
        $this->customerProfileId->setCustomerProfileId($user);
        $this->customerProfileId->setCustomerPaymentProfileId($user);
        $this->customerProfileId->setCustomerAddressId($user);

        return $this->customerProfileId->getCustomerProfileId();
    }

    /**
     * @param string $name
     * @param OrderType $orderType
     * @param PaymentScheduleType $paymentScheduleType
     * @param float $amount
     * @param CustomerProfileIdType $customerProfileIdType
     * @return ARBSubscriptionType
     */
    protected function createSubscription(
        string $name,
        OrderType $orderType,
        PaymentScheduleType $paymentScheduleType,
        float $amount,
        CustomerProfileIdType $customerProfileIdType
    ) : ARBSubscriptionType {
        $this->ARBSubscription->setName($name);
        $this->ARBSubscription->setOrder($orderType);
        $this->ARBSubscription->setPaymentSchedule($paymentScheduleType);
        $this->ARBSubscription->setAmount($amount);
        $this->ARBSubscription->setProfile($customerProfileIdType);

        return $this->ARBSubscription->getSubscription();
    }

    /**
     * @param User $user
     * @return CustomerProfilePaymentType
     */
    protected function createCustomerProfilePayment(User $user) : CustomerProfilePaymentType {
        $this->customerProfilePayment->setCustomerProfileId($user->authorize_customer_id);

        return $this->customerProfilePayment->getCustomerProfilePayment();
    }

    /**
     * @param User $user
     * @return PaymentProfileType
     */
    protected function createPaymentProfile(User $user) : PaymentProfileType {
        $this->paymentProfile->setPaymentProfileId($user->authorize_customer_payment_profile_id);

        return $this->paymentProfile->getPaymentProfile();
    }

    /**
     * @param CustomerProfilePaymentType $customerProfilePaymentType
     * @param float $amount
     * @param OrderType $orderType
     * @return TransactionRequestType
     */
    protected function createTransactionRequest(CustomerProfilePaymentType $customerProfilePaymentType, float $amount, OrderType $orderType) : TransactionRequestType {
        $this->transactionRequest->setProfile($customerProfilePaymentType);
        $this->transactionRequest->setAmount($amount);
        $this->transactionRequest->setTransactionType();
        $this->transactionRequest->setOrder($orderType);

        return $this->transactionRequest->getTransactionRequest();
    }

    protected function createCCTransactionRequest(
        float $amount,
        OrderType $orderType,
        PaymentType $paymentType,
        CustomerAddressType $customerAddressType,
        CustomerDataType $customerDataType,
        SettingType $settingType
    ) : TransactionRequestType {
        $this->transactionRequest->setTransactionType();
        $this->transactionRequest->setAmount($amount);
        $this->transactionRequest->setOrder($orderType);
        $this->transactionRequest->setPayment($paymentType);
        $this->transactionRequest->setBillTo($customerAddressType);
        $this->transactionRequest->setCustomer($customerDataType);
        $this->transactionRequest->addToTransactionSettings($settingType);

        return $this->transactionRequest->getTransactionRequest();
    }

    /**
     * @param CustomerProfileParams $customerProfileParams
     * @return CreditCardType
     */
    protected function createCreditCard(CustomerProfileParams $customerProfileParams): CreditCardType {
        $this->creditCard->setCardNumber($customerProfileParams->getCardNumber());
        $this->creditCard->setExpirationDate($customerProfileParams->getExpirationDate());
        $this->creditCard->setCardCode($customerProfileParams->getCVV());

        return $this->creditCard->getCard();
    }

    /**
     * @param CreditCardType $creditCardType
     * @return PaymentType
     */
    protected function createPayment(CreditCardType $creditCardType) : PaymentType {
        $this->payment->setCreditCard($creditCardType);

        return $this->payment->getPayment();
    }

    /**
     * @param User $user
     * @return CustomerAddressType
     */
    protected function createCustomerAddress(User $user) : CustomerAddressType {
        $this->customerAddress->setFirstName($user->first_name);
        $this->customerAddress->setLastName($user->last_name);
        $this->customerAddress->setEmail($user->email);
        $this->customerAddress->setCompany($user->company);
        $this->customerAddress->setAddress($user->address);
        $this->customerAddress->setCity($user->city);
        $this->customerAddress->setState($user->state);
        $this->customerAddress->setZip($user->zip);
        $this->customerAddress->setCountry("USA");
        $this->customerAddress->setPhoneNumber($user->phone);

        return $this->customerAddress->getAddress();
    }

    /**
     * @param CustomerAddressType $customerAddressType
     * @param PaymentType $paymentType
     * @return CustomerPaymentProfileType
     */
    protected function createCustomerPaymentProfile(CustomerAddressType $customerAddressType, PaymentType $paymentType): CustomerPaymentProfileType
    {
        $this->customerPaymentProfile->setBillTo($customerAddressType);
        $this->customerPaymentProfile->setCustomerType();
        $this->customerPaymentProfile->setPayment($paymentType);

        return $this->customerPaymentProfile->getPaymentProfile();
    }

    /**
     * @param string $description
     * @param string $merchantId
     * @param string $email
     * @param CustomerPaymentProfileType $customerPaymentProfileType
     * @param CustomerAddressType $customerAddressType
     * @return CustomerProfileType
     */
    protected function createCustomerProfile(
        string $description,
        string $merchantId,
        string $email,
        CustomerPaymentProfileType $customerPaymentProfileType,
        CustomerAddressType $customerAddressType
    ): CustomerProfileType
    {
        $this->customerProfile->setDescription($description);
        $this->customerProfile->setMerchantCustomerId($merchantId);
        $this->customerProfile->setEmail($email);
        $this->customerProfile->setPaymentProfiles($customerPaymentProfileType);
        $this->customerProfile->setShipToList($customerAddressType);

        return $this->customerProfile->getCustomerProfile();
    }

    protected function createCustomerExProfile($customerDescription, $merchantId, $id, $paymentType, $customerAddress): CustomerPaymentProfileExType
    {
        $this->customerPaymentProfileExType->setBillTo($customerAddress);
        $this->customerPaymentProfileExType->setCustomerPaymentProfileId($id);
        $this->customerPaymentProfileExType->setPayment($paymentType);

        return $this->customerPaymentProfileExType->getCustomerPaymentExType();
    }

    protected function createCustomerData(User $user) : CustomerDataType {
        $this->customerData->setId($user->authorize_customer_id);
        $this->customerData->setEmail($user->email);
        $this->customerData->setType();

        return $this->customerData->getCustomerData();
    }

    public function createSetting() : SettingType {
        $this->setting->setSettingValue();
        $this->setting->setSettingName();

        return $this->setting->getSetting();
    }
}
