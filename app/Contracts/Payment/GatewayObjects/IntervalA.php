<?php


namespace App\Contracts\Payment\GatewayObjects;


use net\authorize\api\contract\v1\PaymentScheduleType\IntervalAType;

interface IntervalA
{
    public function __construct(IntervalAType $intervalAType);
    public function setLength(int $length) : void;
    public function setUnit(string $unit) : void;
    public function getInterval() : IntervalAType;
}
