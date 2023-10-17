<?php


namespace App\Contracts\Payment\RequestHandlers;


use App\Services\Payment\PaymentAuth;

interface DeleteCustomerProfileRequestHandler
{
    public function __construct(PaymentAuth $paymentAuth, \net\authorize\api\contract\v1\DeleteCustomerProfileRequest $request);
    public function execute($profileId);
}
