<?php


namespace App\Services\Payment\GatewayObjects;


use net\authorize\api\contract\v1\CustomerDataType;

class CustomerData implements \App\Contracts\Payment\GatewayObjects\CustomerData
{

    protected CustomerDataType $customerDataType;

    public function __construct(CustomerDataType $customerDataType)
    {
        $this->customerDataType = $customerDataType;
    }

    public function setType(string $type = 'individual'): void
    {
        $this->customerDataType->setType($type);
    }

    public function setId(string $id): void
    {
        $this->customerDataType->setId($id);
    }

    public function setEmail(string $mail): void
    {
        $this->customerDataType->setEmail($mail);
    }

    public function getCustomerData(): CustomerDataType
    {
        return $this->customerDataType;
    }
}
