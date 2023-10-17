<?php


namespace App\Contracts\Payment\GatewayObjects;


use net\authorize\api\contract\v1\CustomerProfilePaymentType;

interface CustomerProfilePayment
{
    public function __construct(CustomerProfilePaymentType $customerProfilePaymentType);
    public function setCustomerProfileId(int $customerProfileId) : void;
    public function getCustomerProfilePayment() : CustomerProfilePaymentType;
}
