<?php


namespace App\Contracts\Payment;


use App\Models\User;

interface CustomerProfileParams
{
    public function setUser(User $user) : void;
    public function setCardNumber(string $cardNumber) : void;
    public function setExpirationDate(string $expirationDate) : void;
    public function setCVV(string $cvv) : void;
    public function getUser() : User;
    public function getCardNumber() : string;
    public function getExpirationDate() : string;
    public function getCVV() : string;
}
