<?php


namespace App\Contracts\Payment\GatewayObjects;


use net\authorize\api\contract\v1\CustomerAddressType;
use net\authorize\api\contract\v1\CustomerPaymentProfileType;
use net\authorize\api\contract\v1\PaymentType;

interface CustomerPaymentProfile
{
    public function __construct(CustomerPaymentProfileType $customerProfileType);
    public function setCustomerType(string $type = 'individual') : void;
    public function setBillTo(CustomerAddressType $customerAddress) : void;
    public function setPayment(PaymentType $payment) : void;
    public function getPaymentProfile() : CustomerPaymentProfileType;
}
