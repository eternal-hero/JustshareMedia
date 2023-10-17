<?php


namespace App\Contracts\Payment\GatewayObjects;


use net\authorize\api\contract\v1\CustomerAddressType;

interface CustomerAddress
{
    public function __construct(CustomerAddressType $customerAddressType);
    public function setFirstName(string $firstName) : void;
    public function setLastName(string $lastName) : void;
    public function setEmail(string $email) : void;
    public function setCompany(string $company) : void;
    public function setAddress(string $address) : void;
    public function setCity(string $city) : void;
    public function setState(string $state) : void;
    public function setZip(string $zip) : void;
    public function setCountry(string $country = 'USA') : void;
    public function setPhoneNumber(string $phone) : void;
    public function getAddress() : CustomerAddressType;
}
