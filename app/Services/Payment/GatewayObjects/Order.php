<?php


namespace App\Services\Payment\GatewayObjects;


use net\authorize\api\contract\v1\OrderType;

/**
 * Class Order
 * @package App\Services\Payment\GatewayObjects
 */
class Order implements \App\Contracts\Payment\GatewayObjects\Order
{

    /**
     * @var OrderType
     */
    protected OrderType $orderType;

    /**
     * Order constructor.
     * @param OrderType $orderType
     */
    public function __construct(OrderType $orderType)
    {
        $this->orderType = $orderType;
    }

    /**
     * @param string $invoiceNumber
     */
    public function setInvoiceNumber(string $invoiceNumber): void
    {
        $this->orderType->setInvoiceNumber($invoiceNumber);
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->orderType->setDescription($description);
    }

    /**
     * @return OrderType
     */
    public function getOrder(): OrderType
    {
        return $this->orderType;
    }
}
