<?php


namespace App\Services\Payment\GatewayObjects;


use net\authorize\api\contract\v1\PaymentScheduleType;

/**
 * Class PaymentSchedule
 * @package App\Services\Payment\GatewayObjects
 */
class PaymentSchedule implements \App\Contracts\Payment\GatewayObjects\PaymentSchedule
{

    /**
     * @var PaymentScheduleType
     */
    protected PaymentScheduleType $scheduleType;

    /**
     * PaymentSchedule constructor.
     * @param PaymentScheduleType $scheduleType
     */
    public function __construct(PaymentScheduleType $scheduleType)
    {
        $this->scheduleType = $scheduleType;
    }

    /**
     * @param PaymentScheduleType\IntervalAType $intervalAType
     */
    public function setInterval(PaymentScheduleType\IntervalAType $intervalAType): void
    {
        $this->scheduleType->setInterval($intervalAType);
    }

    /**
     * @param \DateTime $dateTime
     */
    public function setStartDate(\DateTime $dateTime): void
    {
        $this->scheduleType->setStartDate($dateTime);
    }

    /**
     * @param int $totalOccurrences
     */
    public function setTotalOccurrences(int $totalOccurrences): void
    {
        $this->scheduleType->setTotalOccurrences($totalOccurrences);
    }

    /**
     * @return PaymentScheduleType
     */
    public function getSchedule(): PaymentScheduleType
    {
        return $this->scheduleType;
    }
}
