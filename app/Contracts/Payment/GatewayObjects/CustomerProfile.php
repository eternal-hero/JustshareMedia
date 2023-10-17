<?php


namespace App\Contracts\Payment\GatewayObjects;


use net\authorize\api\contract\v1\CustomerAddressType;
use net\authorize\api\contract\v1\CustomerPaymentProfileType;
use net\authorize\api\contract\v1\CustomerProfileType;

interface CustomerProfile
{
    public function __construct(CustomerProfileType $customerProfileType);
    public function setDescription(string $description) : void;
    public function setMerchantCustomerId(string $id) : void;
    public function setEmail(string $email) : void;
    public function setPaymentProfiles(CustomerPaymentProfileType $customerPaymentProfile) : void;
    public function setShipToList(CustomerAddressType $customerAddresses) : void;
    public function getCustomerProfile() : CustomerProfileType;
}
