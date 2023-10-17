<?php

namespace App\Listeners;

use App\Events\ChargeCustomerRequestSuccessEvent;
use App\Repositories\PaymentRepository;

class ChargeCustomerRequestSuccessListener
{
    public PaymentRepository $paymentRepository;

    /**
     * Create the event listener.
     *
     * @param PaymentRepository $paymentRepository
     */
    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * Handle the event.
     *
     * @param ChargeCustomerRequestSuccessEvent $event
     * @return void
     */
    public function handle(ChargeCustomerRequestSuccessEvent $event)
    {
        $responseObject = $event->response->getResponseObject();
        $data = [
          'authorize_response_obj' => $responseObject,
          'messages' => $responseObject->getMessages(),
          'authorize_transaction_id' => $responseObject->getTransactionResponse()->getTransId(),
          'authorize_auth_code' => $responseObject->getTransactionResponse()->getAuthCode(),
          'authorize_transaction_code' => $responseObject->getMessages()->getMessage()[0]->getCode(),
        ];
        $this->paymentRepository->updateTransactionAttemptToCompleted($responseObject->getRefId(), $data);
    }
}
