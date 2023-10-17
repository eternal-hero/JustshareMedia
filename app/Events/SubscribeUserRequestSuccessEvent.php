<?php

namespace App\Events;

use App\Contracts\Payment\RequestAttemptResponses\SubscribeUserAttemptResponse;
use App\Models\PendingSubscription;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubscribeUserRequestSuccessEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public PendingSubscription $pendingSubscription;
    public SubscribeUserAttemptResponse $response;

    /**
     * Create a new event instance.
     *
     * @param PendingSubscription $pendingSubscription
     * @param SubscribeUserAttemptResponse $response
     */
    public function __construct(PendingSubscription $pendingSubscription, SubscribeUserAttemptResponse $response)
    {
        $this->pendingSubscription = $pendingSubscription;
        $this->response = $response;
    }
}
