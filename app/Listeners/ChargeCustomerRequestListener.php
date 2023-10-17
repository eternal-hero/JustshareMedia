<?php

namespace App\Listeners;

use App\Events\ChargeCustomerRequestEvent;
use App\Repositories\PaymentRepository;

class ChargeCustomerRequestListener
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
     * @param ChargeCustomerRequestEvent $event
     * @return void
     */
    public function handle(ChargeCustomerRequestEvent $event)
    {
        $data = [
            'reference' => $event->reference,
            'user_id' => $event->user->id,
            'authorize_customer_id' => $event->user->authorize_customer_id,
            'authorize_customer_address_id' => $event->user->authorize_customer_address_id,
            'authorize_customer_payment_profile_id' => $event->user->authorize_customer_payment_profile_id,
            'amount' => $event->amount,
            'type' => $event->transactionRequestType->getTransactionType(),
            'authorize_request_obj' => $event->transactionRequestType,
        ];
        $this->paymentRepository->createTransactionAttempt($data);
    }
}
