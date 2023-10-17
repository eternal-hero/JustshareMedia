<?php


namespace App\Services\Payment\GatewayObjects;


use net\authorize\api\contract\v1\ARBSubscriptionType;
use net\authorize\api\contract\v1\CustomerProfileIdType;
use net\authorize\api\contract\v1\OrderType;
use net\authorize\api\contract\v1\PaymentScheduleType;

/**
 * Class ARBSubscription
 * @package App\Services\Payment\GatewayObjects
 */
class ARBSubscription implements \App\Contracts\Payment\GatewayObjects\ARBSubscription
{

    /**
     * @var ARBSubscriptionType
     */
    protected ARBSubscriptionType $ARBSubscriptionType;

    /**
     * ARBSubscription constructor.
     * @param ARBSubscriptionType $ARBSubscriptionType
     */
    public function __construct(ARBSubscriptionType $ARBSubscriptionType)
    {
        $this->ARBSubscriptionType = $ARBSubscriptionType;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->ARBSubscriptionType->setName($name);
    }

    /**
     * @param OrderType $orderType
     */
    public function setOrder(OrderType $orderType): void
    {
        $this->ARBSubscriptionType->setOrder($orderType);
    }

    /**
     * @param PaymentScheduleType $scheduleType
     */
    public function setPaymentSchedule(PaymentScheduleType $scheduleType): void
    {
        $this->ARBSubscriptionType->setPaymentSchedule($scheduleType);
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->ARBSubscriptionType->setAmount($amount);
    }

    /**
     * @param CustomerProfileIdType $customerProfileIdType
     */
    public function setProfile(CustomerProfileIdType $customerProfileIdType): void
    {
        $this->ARBSubscriptionType->setProfile($customerProfileIdType);
    }

    /**
     * @return ARBSubscriptionType
     */
    public function getSubscription(): ARBSubscriptionType
    {
        return $this->ARBSubscriptionType;
    }
}
