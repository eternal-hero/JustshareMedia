<?php


namespace App\Contracts\Payment\GatewayObjects;


use net\authorize\api\contract\v1\PaymentProfileType;

interface PaymentProfile
{
    public function __construct(PaymentProfileType $paymentProfileType);
    public function setPaymentProfileId(int $paymentProfileId) : void;
    public function getPaymentProfile() : PaymentProfileType;
}
