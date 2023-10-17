<?php


namespace App\Contracts\Payment\GatewayObjects;


use App\Models\User;
use net\authorize\api\contract\v1\CustomerProfileIdType;

interface CustomerProfileId
{
    public function __construct(CustomerProfileIdType $customerProfileIdType);
    public function setCustomerProfileId(User $user) : void;
    public function setCustomerPaymentProfileId(User $user) : void;
    public function setCustomerAddressId(User $user) : void;
    public function getCustomerProfileId() : CustomerProfileIdType;
}
