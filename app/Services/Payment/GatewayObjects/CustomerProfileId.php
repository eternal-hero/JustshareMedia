<?php


namespace App\Services\Payment\GatewayObjects;


use App\Models\User;
use net\authorize\api\contract\v1\CustomerProfileIdType;

/**
 * Class CustomerProfileId
 * @package App\Services\Payment\GatewayObjects
 */
class CustomerProfileId implements \App\Contracts\Payment\GatewayObjects\CustomerProfileId
{

    /**
     * @var CustomerProfileIdType
     */
    protected CustomerProfileIdType $customerProfileIdType;

    /**
     * CustomerProfileId constructor.
     * @param CustomerProfileIdType $customerProfileIdType
     */
    public function __construct(CustomerProfileIdType $customerProfileIdType)
    {
        $this->customerProfileIdType = $customerProfileIdType;
    }

    /**
     * @param User $user
     */
    public function setCustomerProfileId(User $user): void
    {
        $this->customerProfileIdType->setCustomerProfileId($user->authorize_customer_id);
    }

    /**
     * @param User $user
     */
    public function setCustomerPaymentProfileId(User $user): void
    {
        $this->customerProfileIdType->setCustomerPaymentProfileId($user->authorize_customer_payment_profile_id);
    }

    /**
     * @param User $user
     */
    public function setCustomerAddressId(User $user): void
    {
        $this->customerProfileIdType->setCustomerAddressId($user->authorize_customer_address_id);
    }

    /**
     * @return CustomerProfileIdType
     */
    public function getCustomerProfileId(): CustomerProfileIdType
    {
        return $this->customerProfileIdType;
    }
}
