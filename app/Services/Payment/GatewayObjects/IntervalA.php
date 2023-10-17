<?php


namespace App\Services\Payment\GatewayObjects;


use net\authorize\api\contract\v1\PaymentScheduleType\IntervalAType;

/**
 * Class IntervalA
 * @package App\Services\Payment\GatewayObjects
 */
class IntervalA implements \App\Contracts\Payment\GatewayObjects\IntervalA
{

    /**
     * @var IntervalAType
     */
    protected IntervalAType $intervalAType;

    /**
     * IntervalA constructor.
     * @param IntervalAType $intervalAType
     */
    public function __construct(IntervalAType $intervalAType)
    {
        $this->intervalAType = $intervalAType;
    }

    /**
     * @param int $length
     */
    public function setLength(int $length): void
    {
        $this->intervalAType->setLength($length);
    }

    /**
     * @param string $unit
     */
    public function setUnit(string $unit): void
    {
        $this->intervalAType->setUnit($unit);
    }

    /**
     * @return IntervalAType
     */
    public function getInterval(): IntervalAType
    {
        return $this->intervalAType;
    }
}
