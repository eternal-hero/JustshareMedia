<?php


namespace App\Services\Payment\GatewayObjects;


use net\authorize\api\contract\v1\CustomerAddressType;
use net\authorize\api\contract\v1\CustomerPaymentProfileType;
use net\authorize\api\contract\v1\PaymentType;

/**
 * Class CustomerPaymentProfile
 * @package App\Services\Payment\Gateway
 */
class CustomerPaymentProfile implements \App\Contracts\Payment\GatewayObjects\CustomerPaymentProfile
{

    /**
     * @var CustomerPaymentProfileType
     */
    protected CustomerPaymentProfileType $customerProfileType;

    /**
     * CustomerPaymentProfile constructor.
     * @param CustomerPaymentProfileType $customerProfileType
     */
    public function __construct(CustomerPaymentProfileType $customerProfileType)
    {
        $this->customerProfileType = $customerProfileType;
    }

    /**
     * @param string $type
     */
    public function setCustomerType(string $type = 'individual'): void
    {
        $this->customerProfileType->setCustomerType($type);
    }

    /**
     * @param CustomerAddressType $customerAddress
     */
    public function setBillTo(CustomerAddressType $customerAddress): void
    {
        $this->customerProfileType->setBillTo($customerAddress);
    }

    /**
     * @param PaymentType $payment
     */
    public function setPayment(PaymentType $payment): void
    {
        $this->customerProfileType->setPayment($payment);
    }

    /**
     * @return CustomerPaymentProfileType
     */
    public function getPaymentProfile(): CustomerPaymentProfileType
    {
        return $this->customerProfileType;
    }
}
