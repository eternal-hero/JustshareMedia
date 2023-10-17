<?php


namespace App\Contracts\Payment\GatewayObjects;


use net\authorize\api\contract\v1\ARBCreateSubscriptionRequest;
use net\authorize\api\contract\v1\ARBSubscriptionType;

interface ARBSubscriptionRequest
{
    public function __construct(ARBCreateSubscriptionRequest $ARBCreateSubscriptionRequest);
    public function setSubscription(ARBSubscriptionType $subscriptionType) : void;
    public function setRefId(string $ref) : void;
    public function getRequest() : ARBCreateSubscriptionRequest;
}
