<?php


namespace App\Contracts\Payment\RequestHandlers;


use App\Services\Payment\PaymentAuth;
use net\authorize\api\contract\v1\CustomerPaymentProfileExType;
use net\authorize\api\contract\v1\UpdateCustomerPaymentProfileRequest;

interface UpdateCustomerProfileRequestHandler
{
    public function __construct(PaymentAuth $paymentAuth, UpdateCustomerPaymentProfileRequest $request);
    public function execute(string $profileId, CustomerPaymentProfileExType $customerProfileType);
}
