<?php


namespace App\Services\Payment\GatewayObjects;


use net\authorize\api\contract\v1\CustomerAddressType;
use net\authorize\api\contract\v1\CustomerDataType;
use net\authorize\api\contract\v1\CustomerProfilePaymentType;
use net\authorize\api\contract\v1\OrderType;
use net\authorize\api\contract\v1\PaymentType;
use net\authorize\api\contract\v1\SettingType;
use net\authorize\api\contract\v1\TransactionRequestType;

/**
 * Class TransactionRequest
 * @package App\Services\Payment\GatewayObjects
 */
class TransactionRequest implements \App\Contracts\Payment\GatewayObjects\TransactionRequest
{

    /**
     * @var TransactionRequestType
     */
    private TransactionRequestType $transactionRequestType;

    /**
     * TransactionRequest constructor.
     * @param TransactionRequestType $transactionRequestType
     */
    public function __construct(TransactionRequestType $transactionRequestType)
    {
        $this->transactionRequestType = $transactionRequestType;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->transactionRequestType->setAmount($amount);
    }

    /**
     * @param CustomerProfilePaymentType $customerProfilePaymentType
     */
    public function setProfile(CustomerProfilePaymentType $customerProfilePaymentType): void
    {
        $this->transactionRequestType->setProfile($customerProfilePaymentType);
    }

    /**
     * @param string $type
     */
    public function setTransactionType($type = 'authCaptureTransaction') : void
    {
        $this->transactionRequestType->setTransactionType($type);
    }

    /**
     * @param OrderType $orderType
     */
    public function setOrder(OrderType $orderType): void
    {
        $this->transactionRequestType->setOrder($orderType);
    }

    /**
     * @param PaymentType $paymentType
     */
    public function setPayment(PaymentType $paymentType): void
    {
        $this->transactionRequestType->setPayment($paymentType);
    }

    /**
     * @param CustomerAddressType $customerAddressType
     */
    public function setBillTo(CustomerAddressType $customerAddressType): void
    {
        $this->transactionRequestType->setBillTo($customerAddressType);
    }

    /**
     * @param CustomerDataType $customerDataType
     */
    public function setCustomer(CustomerDataType $customerDataType): void
    {
        $this->transactionRequestType->setCustomer($customerDataType);
    }

    /**
     * @param SettingType $settingType
     */
    public function addToTransactionSettings(SettingType $settingType): void
    {
        $this->transactionRequestType->addToTransactionSettings($settingType);
    }

    /**
     * @return TransactionRequestType
     */
    public function getTransactionRequest(): TransactionRequestType
    {
        return $this->transactionRequestType;
    }
}
