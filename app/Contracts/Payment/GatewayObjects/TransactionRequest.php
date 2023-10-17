<?php


namespace App\Contracts\Payment\GatewayObjects;


use net\authorize\api\contract\v1\CustomerAddressType;
use net\authorize\api\contract\v1\CustomerDataType;
use net\authorize\api\contract\v1\CustomerProfilePaymentType;
use net\authorize\api\contract\v1\OrderType;
use net\authorize\api\contract\v1\PaymentType;
use net\authorize\api\contract\v1\SettingType;
use net\authorize\api\contract\v1\TransactionRequestType;

interface TransactionRequest
{
    public function __construct(TransactionRequestType $transactionRequestType);
    public function setAmount(float $amount) : void;
    public function setProfile(CustomerProfilePaymentType $customerProfilePaymentType) : void;
    public function setTransactionType(string $type = 'authCaptureTransaction') : void;
    public function setOrder(OrderType $orderType) : void;
    public function setPayment(PaymentType $paymentType): void;
    public function setBillTo(CustomerAddressType $customerAddressType): void;
    public function setCustomer(CustomerDataType $customerDataType): void;
    public function addToTransactionSettings(SettingType $settingType): void;
    public function getTransactionRequest() : TransactionRequestType;

}
