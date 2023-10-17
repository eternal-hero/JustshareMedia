<?php


namespace App\Contracts\Payment\RequestHandlers;


use App\Services\Payment\PaymentAuth;
use net\authorize\api\contract\v1\ARBCancelSubscriptionRequest;

interface ARBCancelSubscriptionRequestHandler
{
    public function __construct(PaymentAuth $paymentAuth, ARBCancelSubscriptionRequest $request);
    public function execute(string $ref, string $subscriptionID);
}
