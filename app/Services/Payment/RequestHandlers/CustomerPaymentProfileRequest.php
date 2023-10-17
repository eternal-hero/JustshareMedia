<?php


namespace App\Services\Payment\RequestHandlers;


use App\Contracts\Payment\RequestHandlers\CreateCustomerProfileRequestHandler;
use App\Services\Payment\PaymentAuth;
use net\authorize\api\contract\v1\CreateCustomerProfileRequest;
use net\authorize\api\contract\v1\CustomerProfileType;
use net\authorize\api\controller\CreateCustomerProfileController;

class CustomerPaymentProfileRequest implements CreateCustomerProfileRequestHandler
{

    protected PaymentAuth $paymentAuth;
    protected CreateCustomerProfileRequest $request;

    public function __construct(PaymentAuth $paymentAuth, CreateCustomerProfileRequest $request)
    {
        $this->paymentAuth = $paymentAuth;
        $this->request = $request;
    }

    public function execute(string $ref, CustomerProfileType $customerProfileType): ?\net\authorize\api\contract\v1\AnetApiResponseType
    {
        $this->request->setMerchantAuthentication($this->paymentAuth->getMerchantAuthenticationType());
        $this->request->setRefId($ref);
        $this->request->setProfile($customerProfileType);
        $controller = new CreateCustomerProfileController($this->request);

        return $controller->executeWithApiResponse($this->paymentAuth->getEndPoint());
    }
}

