<?php


namespace App\Contracts\Payment\GatewayObjects;


use net\authorize\api\contract\v1\CreditCardType;

interface CreditCard
{
    public function __construct(CreditCardType $creditCardType);
    public function setCardNumber(string $cardNumber) : void;
    public function setExpirationDate(string $expDate) : void;
    public function setCardCode(string $cvv) : void;
    public function getCard() : CreditCardType;
}
