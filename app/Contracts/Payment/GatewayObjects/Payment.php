<?php


namespace App\Contracts\Payment\GatewayObjects;


use net\authorize\api\contract\v1\CreditCardType;
use net\authorize\api\contract\v1\PaymentType;

interface Payment
{
    public function __construct(PaymentType $paymentType);
    public function setCreditCard(CreditCardType $creditCard) : void;
    public function getPayment() : PaymentType;
}
