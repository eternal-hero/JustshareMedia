<?php


namespace App\Contracts\Payment\RequestHandlers;


use App\Services\Payment\PaymentAuth;
use net\authorize\api\contract\v1\CustomerPaymentProfileExType;
use net\authorize\api\contract\v1\CustomerProfileExType;
use net\authorize\api\contract\v1\UpdateCustomerPaymentProfileRequest;

interface UpdateCustomerAddressRequestHandler
{
    public function __construct(PaymentAuth $paymentAuth, UpdateCustomerPaymentProfileRequest $request, CustomerPaymentProfileExType $customerProfileExType);
    public function execute($user, $address);
}
