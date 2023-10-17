<?php


namespace App\Contracts\Payment\RequestAttemptResponses;


use net\authorize\api\contract\v1\CreateTransactionResponse;
use net\authorize\api\contract\v1\CustomerProfilePaymentType;

interface ChargeCustomerProfileAttemptResponse
{
    public function __construct();
    public function setResponse(CreateTransactionResponse $response);
    public function isSuccessful() : bool;
    public function getResponseObject() : CreateTransactionResponse;
    public function getAuthorizeTransactionId() : string;
    public function getAuthorizeAuthCode() : string;
    public function getAuthorizeTransactionCode() : string;
    public function getAuthorizeTransactionDescription() : string;
    public function getReference() : string;
    public function getMessage() : string;
    public function getCode() : string;
}
