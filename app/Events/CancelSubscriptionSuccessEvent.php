<?php

namespace App\Events;

use App\Contracts\Payment\RequestAttemptResponses\ARBCancelSubscriptionAttemptResponse;
use App\Models\Subscription;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CancelSubscriptionSuccessEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Subscription $subscription;

    /**
     * Create a new event instance.
     *
     * @param Subscription $subscription
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }
}
