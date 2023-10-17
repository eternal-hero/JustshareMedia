<?php


namespace App\Services\Payment\GatewayObjects;


use net\authorize\api\contract\v1\PaymentProfileType;

/**
 * Class PaymentProfile
 * @package App\Services\Payment\GatewayObjects
 */
class PaymentProfile implements \App\Contracts\Payment\GatewayObjects\PaymentProfile
{

    /**
     * @var PaymentProfileType
     */
    private PaymentProfileType $paymentProfileType;

    /**
     * PaymentProfile constructor.
     * @param PaymentProfileType $paymentProfileType
     */
    public function __construct(PaymentProfileType $paymentProfileType)
    {
        $this->paymentProfileType = $paymentProfileType;
    }

    /**
     * @param int $paymentProfileId
     */
    public function setPaymentProfileId(int $paymentProfileId): void
    {
        $this->paymentProfileType->setPaymentProfileId($paymentProfileId);
    }

    /**
     * @return PaymentProfileType
     */
    public function getPaymentProfile(): PaymentProfileType
    {
        return $this->paymentProfileType;
    }
}
