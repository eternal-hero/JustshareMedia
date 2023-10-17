<?php


namespace App\Services\Payment\GatewayObjects;


use net\authorize\api\contract\v1\CustomerAddressType;
use net\authorize\api\contract\v1\CustomerPaymentProfileType;
use net\authorize\api\contract\v1\CustomerProfileType;

/**
 * Class CustomerProfile
 * @package App\Services\Payment\Gateway
 */
class CustomerProfile implements \App\Contracts\Payment\GatewayObjects\CustomerProfile
{

    /**
     * @var CustomerProfileType
     */
    protected CustomerProfileType $customerProfileType;

    /**
     * CustomerProfile constructor.
     * @param CustomerProfileType $customerProfileType
     */
    public function __construct(CustomerProfileType $customerProfileType)
    {
        $this->customerProfileType = $customerProfileType;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->customerProfileType->setDescription($description);
    }

    /**
     * @param string $id
     */
    public function setMerchantCustomerId(string $id): void
    {
        $this->customerProfileType->setMerchantCustomerId($id);
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->customerProfileType->setEmail($email);
    }

    /**
     * @param CustomerPaymentProfileType $customerPaymentProfile
     */
    public function setPaymentProfiles(CustomerPaymentProfileType $customerPaymentProfile): void
    {
        $this->customerProfileType->setPaymentProfiles([$customerPaymentProfile]);
    }

    /**
     * @param CustomerAddressType $customerAddresses
     */
    public function setShipToList(CustomerAddressType $customerAddresses): void
    {
        $this->customerProfileType->setShipToList([$customerAddresses]);
    }

    /**
     * @return CustomerProfileType
     */
    public function getCustomerProfile(): CustomerProfileType
    {
        return $this->customerProfileType;
    }
}
