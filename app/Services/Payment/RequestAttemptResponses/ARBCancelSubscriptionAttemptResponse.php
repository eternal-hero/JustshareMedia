<?php


namespace App\Services\Payment\RequestAttemptResponses;


use net\authorize\api\contract\v1\ARBCancelSubscriptionResponse;

/**
 * Class ARBCancelSubscriptionAttemptResponse
 * @package App\Services\Payment\RequestAttemptResponses
 */
class ARBCancelSubscriptionAttemptResponse
    extends AbstractRequestAttemptResponse
    implements \App\Contracts\Payment\RequestAttemptResponses\ARBCancelSubscriptionAttemptResponse
{

    /**
     * @var ARBCancelSubscriptionResponse
     */
    protected ARBCancelSubscriptionResponse $response;
    /**
     * @var string
     */
    protected string $reference;

    /**
     * @param ARBCancelSubscriptionResponse $response
     */
    public function setResponse(ARBCancelSubscriptionResponse $response) {
        $this->handleResponse($response);
    }

    /**
     * @return ARBCancelSubscriptionResponse
     */
    public function getResponseObject(): ARBCancelSubscriptionResponse
    {
        return $this->response;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->response->getRefId();
    }
}
