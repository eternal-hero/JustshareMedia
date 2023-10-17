<?php


namespace App\Services\Payment\GatewayObjects;


use net\authorize\api\contract\v1\CustomerAddressType;

/**
 * Class CustomerAddress
 * @package App\Services\Payment\GatewayObjects
 */
class CustomerAddress implements \App\Contracts\Payment\GatewayObjects\CustomerAddress
{

    /**
     * @var CustomerAddressType
     */
    protected CustomerAddressType $customerAddressType;

    /**
     * CustomerAddress constructor.
     * @param CustomerAddressType $customerAddressType
     */
    public function __construct(CustomerAddressType $customerAddressType)
    {
        $this->customerAddressType = $customerAddressType;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->customerAddressType->setFirstName($firstName);
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->customerAddressType->setLastName($lastName);
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->customerAddressType->setEmail($email);
    }

    /**
     * @param string $company
     */
    public function setCompany(string $company): void
    {
        $this->customerAddressType->setCompany($company);
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->customerAddressType->setAddress($address);
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->customerAddressType->setCity($city);
    }

    /**
     * @param string $state
     */
    public function setState(string $state): void
    {
        $this->customerAddressType->setState($state);
    }

    /**
     * @param string $zip
     */
    public function setZip(string $zip): void
    {
        $this->customerAddressType->setZip($zip);
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country = 'USA'): void
    {
        $this->customerAddressType->setCountry($country);
    }

    /**
     * @param string $phone
     */
    public function setPhoneNumber(string $phone): void
    {
        $this->customerAddressType->setPhoneNumber($phone);
    }

    /**
     * @return CustomerAddressType
     */
    public function getAddress(): CustomerAddressType
    {
        return $this->customerAddressType;
    }



}
