<?php


namespace App\Contracts\Payment\RequestAttemptResponses;


use net\authorize\api\contract\v1\ARBCancelSubscriptionResponse;

interface ARBCancelSubscriptionAttemptResponse
{
    public function __construct();
    public function setResponse(ARBCancelSubscriptionResponse $response);
    public function isSuccessful() : bool;
    public function getResponseObject() : ARBCancelSubscriptionResponse;
    public function getReference() : string;
    public function getMessage() : string;
    public function getCode() : string;
}
