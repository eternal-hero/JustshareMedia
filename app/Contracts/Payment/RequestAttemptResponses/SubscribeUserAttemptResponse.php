<?php


namespace App\Contracts\Payment\RequestAttemptResponses;



use net\authorize\api\contract\v1\ARBCreateSubscriptionResponse;

interface SubscribeUserAttemptResponse
{
    public function __construct();
    public function setResponse(ARBCreateSubscriptionResponse $response);
    public function isSuccessful() : bool;
    public function getMessage() : string;
    public function getCode() : string;
    public function getSubscriptionId() : string;
}
