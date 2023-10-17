<?php

namespace App\Events;


use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use net\authorize\api\contract\v1\CustomerProfileType;

class CustomerPaymentProfileRequestEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public CustomerProfileType $customerProfileType;

    /**
     * Create a new event instance.
     *
     * @param CustomerProfileType $customerProfileType
     */
    public function __construct(CustomerProfileType $customerProfileType)
    {
        $this->customerProfileType = $customerProfileType;
    }

}
