<?php


namespace App\Contracts\Payment\GatewayObjects;


use net\authorize\api\contract\v1\PaymentScheduleType;

interface PaymentSchedule
{
    public function __construct(PaymentScheduleType $scheduleType);
    public function setInterval(PaymentScheduleType\IntervalAType $intervalAType) : void;
    public function setStartDate(\DateTime $dateTime) : void;
    public function setTotalOccurrences(int $totalOccurrences) : void;
    public function getSchedule() : PaymentScheduleType;
}
