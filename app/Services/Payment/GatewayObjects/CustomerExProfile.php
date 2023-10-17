<?php


namespace App\Services\Payment\GatewayObjects;


use net\authorize\api\contract\v1\CustomerAddressType;
use net\authorize\api\contract\v1\CustomerPaymentProfileExType;
use net\authorize\api\contract\v1\CustomerPaymentProfileType;
use net\authorize\api\contract\v1\CustomerProfileExType;
use net\authorize\api\contract\v1\CustomerProfileType;
use net\authorize\api\contract\v1\PaymentType;

class CustomerExProfile implements \App\Contracts\Payment\GatewayObjects\CustomerExProfile
{

    /**
     * @var CustomerProfileType
     */
    protected CustomerPaymentProfileExType $customerPaymentExProfileType;

    /**
     * CustomerProfile constructor.
     * @param CustomerPaymentProfileExType $customerPaymentExProfileType
     */
    public function __construct(CustomerPaymentProfileExType $customerPaymentExProfileType)
    {
        $this->customerPaymentExProfileType = $customerPaymentExProfileType;
    }

//    /**
//     * @param string $description
//     */
//    public function setDescription(string $description): void
//    {
//        $this->customerProfileType->setDescription($description);
//    }
//
//    /**
//     * @param string $id
//     */
//    public function setMerchantCustomerId(string $id): void
//    {
//        $this->customerProfileType->setMerchantCustomerId($id);
//    }
//
//    /**
//     * @param string $email
//     */
//    public function setEmail(string $email): void
//    {
//        $this->customerProfileType->setEmail($email);
//    }
//
//    /**
//     * @param CustomerPaymentProfileType $customerPaymentProfile
//     */
//    public function setPaymentProfiles(CustomerPaymentProfileType $customerPaymentProfile): void
//    {
//        $this->customerProfileType->setPaymentProfiles([$customerPaymentProfile]);
//    }
//
//    /**
//     * @param CustomerAddressType $customerAddresses
//     */
//    public function setShipToList(CustomerAddressType $customerAddresses): void
//    {
//        $this->customerProfileType->setShipToList([$customerAddresses]);
//    }

    /**
     * @param \App\Contracts\Payment\GatewayObjects\CustomerAddress $customerAddress
     */
    public function setBillTo(\App\Contracts\Payment\GatewayObjects\CustomerAddress $customerAddress): void
    {
        $this->customerPaymentExProfileType->setBillTo($customerAddress->getAddress());
    }

    /**
     * @param string $id
     */
    public function setCustomerPaymentProfileId(string $id): void
    {
        $this->customerPaymentExProfileType->setCustomerPaymentProfileId($id);
    }

    /**
     * @param PaymentType $paymentType
     */
    public function setPayment(PaymentType $paymentType): void
    {
        $this->customerPaymentExProfileType->setPayment($paymentType);
    }

    /**
     * @return CustomerPaymentProfileExType
     */
    public function getCustomerPaymentExType(): CustomerPaymentProfileExType
    {
        return $this->customerPaymentExProfileType;
    }

}
