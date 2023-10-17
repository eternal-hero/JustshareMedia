<?php


namespace App\Services\Payment\RequestHandlers;


use App\Services\Payment\PaymentAuth;
use net\authorize\api\contract\v1\ARBSubscriptionType;
use net\authorize\api\controller\ARBCreateSubscriptionController;

class ARBSubscriptionRequest implements \App\Contracts\Payment\RequestHandlers\ARBCreateSubscriptionRequestHandler
{

    protected PaymentAuth $paymentAuth;
    protected \net\authorize\api\contract\v1\ARBCreateSubscriptionRequest $request;

    public function __construct(PaymentAuth $paymentAuth, \net\authorize\api\contract\v1\ARBCreateSubscriptionRequest $request)
    {
        $this->paymentAuth = $paymentAuth;
        $this->request = $request;
    }

    public function execute(string $ref, ARBSubscriptionType $ARBSubscriptionType)
    {
        $this->request->setMerchantAuthentication($this->paymentAuth->getMerchantAuthenticationType());
        $this->request->setRefId($ref);
        $this->request->setSubscription($ARBSubscriptionType);
        $controller = new ARBCreateSubscriptionController($this->request);

        return $controller->executeWithApiResponse($this->paymentAuth->getEndPoint());
    }
}
