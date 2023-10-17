<?php

namespace App\Listeners;

use App\Events\CancelSubscriptionSuccessEvent;
use App\Repositories\PaymentRepository;

class CancelSubscriptionSuccessListener
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
     * @param CancelSubscriptionSuccessEvent $event
     * @return void
     */
    public function handle(CancelSubscriptionSuccessEvent $event)
    {
        $this->paymentRepository->cancelSubscription($event->subscription);
    }
}
