<?php


namespace App\Contracts\Payment\GatewayObjects;


use net\authorize\api\contract\v1\ARBSubscriptionType;
use net\authorize\api\contract\v1\CustomerProfileIdType;
use net\authorize\api\contract\v1\OrderType;
use net\authorize\api\contract\v1\PaymentScheduleType;

interface ARBSubscription
{
    public function __construct(ARBSubscriptionType $ARBSubscriptionType);
    public function setName(string $name) : void;
    public function setOrder(OrderType $orderType) : void;
    public function setPaymentSchedule(PaymentScheduleType $scheduleType) : void;
    public function setAmount(float $amount) : void;
    public function setProfile(CustomerProfileIdType $customerProfileIdType) : void;
    public function getSubscription() : ARBSubscriptionType;
}
