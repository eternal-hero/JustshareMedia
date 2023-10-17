<?php

namespace App\Listeners;

use App\Events\CancelSubscriptionFailedEvent;
use Illuminate\Support\Facades\Log;

class CancelSubscriptionFailedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param CancelSubscriptionFailedEvent $event
     * @return void
     */
    public function handle(CancelSubscriptionFailedEvent $event)
    {
        Log::error('Failed subscription cancel request with id: ' . $event->subscription->id, ['subscription' => $event->subscription]);
    }
}
