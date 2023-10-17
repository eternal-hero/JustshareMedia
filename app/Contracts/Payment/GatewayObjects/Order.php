<?php


namespace App\Contracts\Payment\GatewayObjects;


use net\authorize\api\contract\v1\OrderType;

interface Order
{
    public function __construct(OrderType $orderType);
    public function setInvoiceNumber(string $invoiceNumber) : void;
    public function setDescription(string $description) : void;
    public function getOrder() : OrderType;
}
