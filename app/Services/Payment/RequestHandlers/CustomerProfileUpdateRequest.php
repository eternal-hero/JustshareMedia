<?php


namespace App\Services\Payment\RequestHandlers;


use App\Contracts\Payment\RequestHandlers\UpdateCustomerProfileRequestHandler;
use App\Services\Payment\PaymentAuth;
use net\authorize\api\contract\v1\UpdateCustomerPaymentProfileRequest;
use net\authorize\api\contract\v1\UpdateCustomerProfileRequest;
use net\authorize\api\controller\UpdateCustomerPaymentProfileController;

class CustomerProfileUpdateRequest implements UpdateCustomerProfileRequestHandler
{
    protected PaymentAuth $paymentAuth;
    protected UpdateCustomerPaymentProfileRequest $request;

    public function __construct(PaymentAuth $paymentAuth, UpdateCustomerPaymentProfileRequest $request)
    {
        $this->paymentAuth = $paymentAuth;
        $this->request = $request;
    }

    public function execute(string $profileId, \net\authorize\api\contract\v1\CustomerPaymentProfileExType $customerProfileType): ?\net\authorize\api\contract\v1\AnetApiResponseType
    {
        $this->request->setMerchantAuthentication($this->paymentAuth->getMerchantAuthenticationType());
        $this->request->setCustomerProfileId($profileId);
        $this->request->setPaymentProfile($customerProfileType);
        $controller = new UpdateCustomerPaymentProfileController($this->request);

        return $controller->executeWithApiResponse($this->paymentAuth->getEndPoint());
    }
}
