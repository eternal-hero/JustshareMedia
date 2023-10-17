<?php


namespace App\Services\Payment\RequestHandlers;


use App\Contracts\Payment\RequestHandlers\DeleteCustomerProfileRequestHandler;
use App\Services\Payment\PaymentAuth;
use net\authorize\api\controller\DeleteCustomerProfileController;

class DeleteCustomerProfileRequest implements DeleteCustomerProfileRequestHandler
{

    protected $request;
    protected $paymentAuth;

    public function __construct(PaymentAuth $paymentAuth, \net\authorize\api\contract\v1\DeleteCustomerProfileRequest $request)
    {
        $this->request = $request;
        $this->paymentAuth = $paymentAuth;
    }

    public function execute($profileId)
    {
        $this->request->setMerchantAuthentication($this->paymentAuth->getMerchantAuthenticationType());
        $this->request->setCustomerProfileId($profileId);

        $controller = new DeleteCustomerProfileController($this->request);

        return $controller->executeWithApiResponse($this->paymentAuth->getEndPoint());
    }
}
