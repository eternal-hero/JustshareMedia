<?php


namespace App\Services\Payment\GatewayObjects;


use net\authorize\api\contract\v1\CreditCardType;
use net\authorize\api\contract\v1\PaymentType;

/**
 * Class Payment
 * @package App\Services\Payment\GatewayObjects
 */
class Payment implements \App\Contracts\Payment\GatewayObjects\Payment
{

    /**
     * @var PaymentType
     */
    protected PaymentType $paymentType;

    /**
     * Payment constructor.
     * @param PaymentType $paymentType
     */
    public function __construct(PaymentType $paymentType)
    {
        $this->paymentType = $paymentType;
    }

    /**
     * @param CreditCardType $creditCard
     */
    public function setCreditCard(CreditCardType $creditCard): void
    {
        $this->paymentType->setCreditCard($creditCard);
    }

    /**
     * @return PaymentType
     */
    public function getPayment(): PaymentType
    {
        return $this->paymentType;
    }
}
