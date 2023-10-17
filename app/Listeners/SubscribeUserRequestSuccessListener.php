<?php

namespace App\Listeners;

use App\Events\SubscribeUserRequestSuccessEvent;
use App\Repositories\PaymentRepository;

class SubscribeUserRequestSuccessListener
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
     * @param SubscribeUserRequestSuccessEvent $event
     * @return void
     */
    public function handle(SubscribeUserRequestSuccessEvent $event)
    {
        // Create new subscription
        $this->paymentRepository->createSubscriptionFromPending($event->pendingSubscription, $event->response->getSubscriptionId());
        // Update state of the pending subscription
        $this->paymentRepository->updatePendingSubscriptionToSuccess($event->pendingSubscription);
        // Log the response
        $this->paymentRepository->createPendingSubscriptionResponse($event->pendingSubscription, true, $event->response->getMessage(), $event->response->getCode());
    }
}
