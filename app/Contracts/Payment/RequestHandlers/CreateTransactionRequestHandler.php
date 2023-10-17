<?php


namespace App\Contracts\Payment\RequestHandlers;


use App\Services\Payment\PaymentAuth;
use net\authorize\api\contract\v1\TransactionRequestType;

interface CreateTransactionRequestHandler
{
    public function __construct(PaymentAuth $paymentAuth, \net\authorize\api\contract\v1\CreateTransactionRequest $request);
    public function execute(string $ref, TransactionRequestType $transactionRequestType);
}
