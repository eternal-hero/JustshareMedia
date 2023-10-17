<?php


namespace App\Services\Payment;


use App\Models\User;

/**
 * Class CustomerProfileParams
 * @package App\Services\Payment
 */
class CustomerProfileParams implements \App\Contracts\Payment\CustomerProfileParams
{

    /**
     * @var User
     */
    protected User $user;
    /**
     * @var int
     */
    protected int $cardNumber;
    /**
     * @var string
     */
    protected string $expirationDate;
    /**
     * @var string
     */
    protected string $cvv;

    /**
     * CustomerProfileParams constructor.
     */
    public function __construct() {

    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @param int $cardNumber
     */
    public function setCardNumber(string $cardNumber): void
    {
        $this->cardNumber = $cardNumber;
    }

    /**
     * @param string $expirationDate
     */
    public function setExpirationDate(string $expirationDate): void
    {
        $this->expirationDate = $expirationDate;
    }

    /**
     * @param int $cvv
     */
    public function setCVV(string $cvv): void
    {
        $this->cvv = $cvv;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return int
     */
    public function getCardNumber(): string
    {
        return $this->cardNumber;
    }

    /**
     * @return string
     */
    public function getExpirationDate(): string
    {
        return $this->expirationDate;
    }

    /**
     * @return int
     */
    public function getCVV(): string
    {
        return $this->cvv;
    }
}
