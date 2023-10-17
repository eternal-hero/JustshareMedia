<?php

namespace App\Exceptions;

use Exception;
use Throwable;

/**
 * Class FailedSubscription
 * @package App\Exceptions
 */
class FailedSubscription extends Exception
{
    /**
     * @var string
     */
    protected string $gatewayError;

    /**
     * FailedSubscription constructor.
     * @param string $message
     * @param string $gatewayError
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message, string $gatewayError, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->setGatewayError($gatewayError);
    }

    /**
     * @return string
     */
    public function getGatewayError(): string
    {
        return $this->gatewayError;
    }

    /**
     * @param string $gatewayError
     */
    public function setGatewayError(string $gatewayError): void
    {
        $this->gatewayError = $gatewayError;
    }
}
