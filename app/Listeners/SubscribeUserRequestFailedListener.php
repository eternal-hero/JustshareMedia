<?php

namespace App\Listeners;

use App\Events\SubscribeUserRequestFailedEvent;
use App\Repositories\PaymentRepository;

class SubscribeUserRequestFailedListener
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
     * @param SubscribeUserRequestFailedEvent $event
     * @return void
     */
    public function handle(SubscribeUserRequestFailedEvent $event)
    {
        $this->paymentRepository->createPendingSubscriptionResponse($event->pendingSubscription, false, $event->response->getMessage(), $event->response->getCode());
        $this->paymentRepository->updatePendingSubscriptionToFailed($event->pendingSubscription);
    }
}
