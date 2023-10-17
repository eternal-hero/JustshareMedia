<?php


namespace App\Services\Payment\RequestHandlers;


use App\Services\Payment\PaymentAuth;
use net\authorize\api\contract\v1\UpdateCustomerPaymentProfileRequest;
use net\authorize\api\controller\UpdateCustomerPaymentProfileController;

class UpdateCustomerProfileAddressRequest
{
    /**
     * @var UpdateCustomerPaymentProfileRequest
     */
    private UpdateCustomerPaymentProfileRequest $request;
    /**
     * @var PaymentAuth
     */
    private PaymentAuth $paymentAuth;

    public function __construct(PaymentAuth $paymentAuth, UpdateCustomerPaymentProfileRequest $request)
    {
        $this->paymentAuth = $paymentAuth;
        $this->request = $request;
    }

    public function execute(string $profileId, \net\authorize\api\contract\v1\CustomerPaymentProfileExType $customerProfileType): ?\net\authorize\api\contract\v1\AnetApiResponseType
    {
        $this->request->setMerchantAuthentication($this->paymentAuth->getMerchantAuthenticationType());
        $this->request->setCustomerProfileId($profileId);
//        $this->request->setPaymentProfile($customerProfileType);
        $controller = new UpdateCustomerPaymentProfileController($this->request);

        return $controller->executeWithApiResponse($this->paymentAuth->getEndPoint());
    }
}
