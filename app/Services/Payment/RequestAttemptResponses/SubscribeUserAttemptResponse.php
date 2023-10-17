<?php


namespace App\Services\Payment\RequestAttemptResponses;


use net\authorize\api\contract\v1\ARBCreateSubscriptionResponse;

/**
 * Class SubscribeUserAttemptResponse
 * @package App\Services\Payment\RequestAttemptResponses
 */
class SubscribeUserAttemptResponse
    extends AbstractRequestAttemptResponse
    implements \App\Contracts\Payment\RequestAttemptResponses\SubscribeUserAttemptResponse
{

    /**
     * @var ARBCreateSubscriptionResponse
     */
    protected ARBCreateSubscriptionResponse $response;

    /**
     * @param ARBCreateSubscriptionResponse $response
     */
    public function setResponse(ARBCreateSubscriptionResponse $response)
    {
        $this->handleResponse($response);
    }

    /**
     * @return string
     */
    public function getSubscriptionId(): string
    {
        return $this->response->getSubscriptionId();
    }
}
