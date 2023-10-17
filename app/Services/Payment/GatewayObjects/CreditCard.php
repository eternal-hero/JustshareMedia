<?php


namespace App\Services\Payment\GatewayObjects;


use net\authorize\api\contract\v1\CreditCardType;

/**
 * Class CreditCard
 * @package App\Services\Payment\Gateway
 */
class CreditCard implements \App\Contracts\Payment\GatewayObjects\CreditCard
{

    /**
     * @var CreditCardType
     */
    protected CreditCardType $creditCardType;

    /**
     * CreditCard constructor.
     * @param CreditCardType $creditCardType
     */
    public function __construct(CreditCardType $creditCardType)
    {
        $this->creditCardType = $creditCardType;
    }

    /**
     * @param string $cardNumber
     */
    public function setCardNumber(string $cardNumber): void
    {
        $this->creditCardType->setCardNumber($cardNumber);
    }

    /**
     * @param string $expDate
     */
    public function setExpirationDate(string $expDate): void
    {
        $this->creditCardType->setExpirationDate($expDate);
    }

    /**
     * @param int $cvv
     */
    public function setCardCode(string $cvv): void
    {
        $this->creditCardType->setCardCode($cvv);
    }

    /**
     * @return CreditCardType
     */
    public function getCard(): CreditCardType
    {
        return $this->creditCardType;
    }
}
