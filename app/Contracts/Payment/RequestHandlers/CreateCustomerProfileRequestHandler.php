<?php


namespace App\Contracts\Payment\RequestHandlers;


use App\Services\Payment\PaymentAuth;
use net\authorize\api\contract\v1\CreateCustomerProfileRequest;
use net\authorize\api\contract\v1\CustomerProfileType;

interface CreateCustomerProfileRequestHandler
{
    public function __construct(PaymentAuth $paymentAuth, CreateCustomerProfileRequest $request);
    public function execute(string $ref, CustomerProfileType $customerProfileType);
}
