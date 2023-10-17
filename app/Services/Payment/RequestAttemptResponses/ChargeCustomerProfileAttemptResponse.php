<?php


namespace App\Services\Payment\RequestAttemptResponses;


use net\authorize\api\contract\v1\CreateTransactionResponse;

/**
 * Class ChargeCustomerProfileAttemptResponse
 * @package App\Services\Payment\RequestAttemptResponses
 */
class ChargeCustomerProfileAttemptResponse
    extends AbstractRequestAttemptResponse
    implements \App\Contracts\Payment\RequestAttemptResponses\ChargeCustomerProfileAttemptResponse
{
    /**
     * @var CreateTransactionResponse
     */
    protected CreateTransactionResponse $response;
    /**
     * @var string
     */
    protected string $reference;

    /**
     * @param CreateTransactionResponse $response
     */
    public function setResponse(CreateTransactionResponse $response) {
        $this->handleResponse($response);
    }

    /**
     * @return CreateTransactionResponse
     */
    public function getResponseObject(): CreateTransactionResponse
    {
        return $this->response;
    }

    /**
     * @return string
     */
    public function getAuthorizeTransactionId() : string {
        return $this->response->getTransactionResponse()->getTransId();
    }

    /**
     * @return string
     */
    public function getAuthorizeAuthCode() : string {
        return '';
        return $this->response->getTransactionResponse()->getAuthCode();
    }

    /**
     * @return string
     */
    public function getAuthorizeTransactionCode() : string {
        return $this->response->getMessages()->getMessage()[0]->getCode();
    }

    /**
     * @return string
     */
    public function getAuthorizeTransactionDescription() : string {
        return $this->response->getMessages()->getMessage()[0]->getText();
    }

    /**
     * @return string
     */
    public function getReference() : string {
        return $this->response->getRefId();
    }
}
