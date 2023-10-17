<?php


namespace App\Services\Payment\RequestHandlers;


use App\Services\Payment\PaymentAuth;
use net\authorize\api\controller\ARBCancelSubscriptionController;
use net\authorize\api\controller\ARBCreateSubscriptionController;

class ARBCancelSubscriptionRequest implements \App\Contracts\Payment\RequestHandlers\ARBCancelSubscriptionRequestHandler
{

    private PaymentAuth $paymentAuth;
    private \net\authorize\api\contract\v1\ARBCancelSubscriptionRequest $request;

    public function __construct(PaymentAuth $paymentAuth, \net\authorize\api\contract\v1\ARBCancelSubscriptionRequest $request)
    {
        $this->paymentAuth = $paymentAuth;
        $this->request = $request;
    }

    public function execute(string $ref, string $subscriptionID)
    {
        $this->request->setMerchantAuthentication($this->paymentAuth->getMerchantAuthenticationType());
        $this->request->setRefId($ref);
        $this->request->setSubscriptionId($subscriptionID);
        $controller = new ARBCancelSubscriptionController($this->request);

        return $controller->executeWithApiResponse($this->paymentAuth->getEndPoint());
    }
}
