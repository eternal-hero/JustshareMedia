<?php


namespace App\Contracts\Payment\GatewayObjects;


use net\authorize\api\contract\v1\CustomerDataType;

interface CustomerData
{
    public function __construct(CustomerDataType $customerDataType);
    public function setType(string $type = 'individual') : void;
    public function setId(string $id) : void;
    public function setEmail(string $mail) : void;
    public function getCustomerData() : CustomerDataType;
}
