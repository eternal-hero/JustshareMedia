<?php


namespace App\Contracts\Payment\GatewayObjects;


use net\authorize\api\contract\v1\CustomerPaymentProfileExType;
use net\authorize\api\contract\v1\PaymentType;

interface CustomerExProfile
{
    public function __construct(CustomerPaymentProfileExType $customerProfileType);
    public function setCustomerPaymentProfileId(string $id) : void;
    public function setPayment(PaymentType $paymentType) : void;
    public function setBillTo(CustomerAddress $customerAddress) : void;
    public function getCustomerPaymentExType() : CustomerPaymentProfileExType;
}
