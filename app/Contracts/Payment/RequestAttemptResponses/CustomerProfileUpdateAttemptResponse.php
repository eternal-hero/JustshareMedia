<?php


namespace App\Contracts\Payment\RequestAttemptResponses;


use net\authorize\api\contract\v1\UpdateCustomerPaymentProfileResponse;

interface CustomerProfileUpdateAttemptResponse
{
    public function __construct();
    public function setResponse(UpdateCustomerPaymentProfileResponse $response);
    public function isSuccessful() : bool;
    public function getReference() : string;
    public function getMessage() : string;
    public function getCode() : string;
    public function getCustomerProfileId() : string;
    public function getCustomerAddressId() : string;
    public function getCustomerPaymentProfileId() : string;
}
