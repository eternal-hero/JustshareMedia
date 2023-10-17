<?php


namespace App\Services\Payment\RequestHandlers;


use App\Contracts\Payment\RequestHandlers\CreateTransactionRequestHandler;
use App\Events\ChargeCustomerRequestEvent;
use App\Services\Payment\PaymentAuth;
use net\authorize\api\contract\v1\TransactionRequestType;
use net\authorize\api\controller\CreateTransactionController;

class CreateTransactionRequest implements CreateTransactionRequestHandler
{

    protected PaymentAuth $paymentAuth;
    protected \net\authorize\api\contract\v1\CreateTransactionRequest $request;

    public function __construct(PaymentAuth $paymentAuth, \net\authorize\api\contract\v1\CreateTransactionRequest $request)
    {
        $this->paymentAuth = $paymentAuth;
        $this->request = $request;
    }

    public function execute(string $ref, TransactionRequestType $transactionRequestType)
    {
        $this->request->setMerchantAuthentication($this->paymentAuth->getMerchantAuthenticationType());
        $this->request->setRefId($ref);
        $this->request->setTransactionRequest($transactionRequestType);
        $controller = new CreateTransactionController($this->request);

        return $controller->executeWithApiResponse($this->paymentAuth->getEndPoint());
    }
}
