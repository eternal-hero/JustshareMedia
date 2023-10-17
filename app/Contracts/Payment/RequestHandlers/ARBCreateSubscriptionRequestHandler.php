<?php


namespace App\Contracts\Payment\RequestHandlers;


use App\Services\Payment\PaymentAuth;
use net\authorize\api\contract\v1\ARBSubscriptionType;

interface ARBCreateSubscriptionRequestHandler
{
    public function __construct(PaymentAuth $paymentAuth, \net\authorize\api\contract\v1\ARBCreateSubscriptionRequest $request);
    public function execute(string $ref, ARBSubscriptionType $ARBSubscriptionType);
}
