<?php


namespace App\Services\Payment\RequestAttemptResponses;


use net\authorize\api\contract\v1\UpdateCustomerPaymentProfileResponse;


class CustomerProfileUpdateAttemptResponse
    extends AbstractRequestAttemptResponse
    implements \App\Contracts\Payment\RequestAttemptResponses\CustomerProfileUpdateAttemptResponse
{

    /**
     * @var UpdateCustomerPaymentProfileResponse
     */
    protected UpdateCustomerPaymentProfileResponse $response;

    /**
     * @param UpdateCustomerPaymentProfileResponse $response
     */
    public function setResponse(UpdateCustomerPaymentProfileResponse $response)
    {
        $this->handleResponse($response);
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->response->getRefId();
    }

    /**
     * @return string
     */
    public function getCustomerProfileId(): string
    {
        return $this->response->getCustomerProfileId();
    }

    /**
     * @return string
     */
    public function getCustomerAddressId(): string
    {
        return $this->response->getCustomerShippingAddressIdList()[0];
    }

    /**
     * @return string
     */
    public function getCustomerPaymentProfileId(): string
    {
        return $this->response->getCustomerPaymentProfileIdList()[0];
    }
}
