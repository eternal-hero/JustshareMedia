<?php


namespace App\Services\Payment\GatewayObjects;


use net\authorize\api\contract\v1\CustomerProfilePaymentType;

/**
 * Class CustomerProfilePayment
 * @package App\Services\Payment\GatewayObjects
 */
class CustomerProfilePayment implements \App\Contracts\Payment\GatewayObjects\CustomerProfilePayment
{

    /**
     * @var CustomerProfilePaymentType
     */
    private CustomerProfilePaymentType $customerProfilePaymentType;

    /**
     * CustomerProfilePayment constructor.
     * @param CustomerProfilePaymentType $customerProfilePaymentType
     */
    public function __construct(CustomerProfilePaymentType $customerProfilePaymentType)
    {
        $this->customerProfilePaymentType = $customerProfilePaymentType;
    }

    /**
     * @param int $customerProfileId
     */
    public function setCustomerProfileId(int $customerProfileId): void
    {
        $this->customerProfilePaymentType->setCustomerProfileId($customerProfileId);
    }

    /**
     * @return CustomerProfilePaymentType
     */
    public function getCustomerProfilePayment(): CustomerProfilePaymentType
    {
        return $this->customerProfilePaymentType;
    }
}
