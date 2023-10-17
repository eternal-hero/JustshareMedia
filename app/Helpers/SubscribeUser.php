<?php


namespace App\Helpers;


use App\Exceptions\FailedSubscription;
use App\Models\PendingSubscription;
use App\Models\PendingSubscriptionResponses;
use App\Models\Subscription;
use App\Services\Payment\CustomerProfileService;


/**
 * Class SubscribeUser
 * @package App\Helpers
 */
class SubscribeUser
{

    /**
     * Will try to fetch all pending subscriptions and update their status
     * Either request to payment gateway fails or successes it will write log into pending_subscription_statuses table
     * After processing pending subscription status will be updated
     * If request to payment gateway successes new entry in subscriptions table will be inserted
     * @param CustomerProfileService $customerProfileService
     */
    public function __invoke(CustomerProfileService $customerProfileService) {
        // Get all pending subscriptions
        $pendingSubscriptions = PendingSubscription::where('status', PendingSubscription::STATUS_PENDING)
            ->where('attempts', '<', PendingSubscription::MAX_ATTEMPTS)->get();
            // With max attempts we cover the case if cron is run in period of authorize.net server sync
            // In that case subscription will fail so we need to run it again
        foreach ($pendingSubscriptions as $pendingSubscription) {
            $subscriptionResponse = $customerProfileService->subscribe($pendingSubscription);
        }
    }
}
