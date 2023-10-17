<?php


namespace App\Repositories;


use App\Models\AdditionalLicense;
use App\Models\GalleryItem;
use App\Models\Order;
use App\Models\PendingSubscription;
use App\Models\PendingSubscriptionResponses;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\Transaction;
use App\Models\TransactionAttempt;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

/**
 * Class PaymentRepository
 * @package App\Repositories
 */
class PaymentRepository
{

    /**
     * @param array $data
     * @return TransactionAttempt
     */
    public function createTransactionAttempt(array $data) : TransactionAttempt {
        $transactionAttempt = new TransactionAttempt();
        $transactionAttempt->reference = $data['reference'];
        $transactionAttempt->user_id = $data['user_id'];
        $transactionAttempt->authorize_customer_id = $data['authorize_customer_id'];
        $transactionAttempt->authorize_customer_address_id = $data['authorize_customer_address_id'];
        $transactionAttempt->authorize_customer_payment_profile_id = $data['authorize_customer_payment_profile_id'];
        $transactionAttempt->amount = $data['amount'];
        $transactionAttempt->type = $data['type'];
        $transactionAttempt->status = TransactionAttempt::STATUS_PENDING;
        $transactionAttempt->authorize_request_obj = json_encode($data['authorize_request_obj']);
        $transactionAttempt->save();

        return $transactionAttempt;
    }

    /**
     * @param string $reference
     * @param array $data
     * @return TransactionAttempt
     */
    public function updateTransactionAttemptToCompleted(string $reference, array $data) : TransactionAttempt {
        $transactionAttempt = TransactionAttempt::where('reference', $reference)->first();
        $transactionAttempt->status = TransactionAttempt::STATUS_COMPLETED;
        $transactionAttempt->authorize_response_obj = json_encode($data['authorize_response_obj']);
        $transactionAttempt->message = json_encode($data['messages']);
        $transactionAttempt->authorize_transaction_id = $data['authorize_transaction_id'];
        $transactionAttempt->authorize_auth_code = $data['authorize_auth_code'];
        $transactionAttempt->authorize_transaction_code = $data['authorize_transaction_code'];
        $transactionAttempt->save();

        return $transactionAttempt;
    }

    /**
     * @param string $reference
     * @param array $data
     * @return TransactionAttempt
     */
    public function updateTransactionAttemptToFailed(string $reference, array $data) : TransactionAttempt {
        $transactionAttempt = TransactionAttempt::where('reference', $reference)->first();
        $transactionAttempt->status = TransactionAttempt::STATUS_FAILED;
        $transactionAttempt->authorize_response_obj = json_encode($data['authorize_response_obj']);
        if($data['errors']) {
            $transactionAttempt->authorize_response_errors = json_encode($data['errors']);
        }
        $transactionAttempt->message = json_encode($data['messages']);
        $transactionAttempt->save();

        return $transactionAttempt;
    }

    /**
     * @param string $attemptReference
     * @param Order $order
     * @return Transaction
     */
    public function createTransactionFromCompletedAttempt(string $attemptReference, Order $order): Transaction
    {
        $completedTransactionAttempt = TransactionAttempt::where('reference', $attemptReference)
            ->where('status', TransactionAttempt::STATUS_COMPLETED)->first();
        $transaction = new Transaction();
        $transaction->user_id = $completedTransactionAttempt->user_id;
        $transaction->order_id = $order->id;
        $transaction->type = 'payment';
        $transaction->status = 'completed';
        $transaction->authorize_transaction_id = $completedTransactionAttempt->authorize_transaction_id;
        $transaction->authorize_auth_code = $completedTransactionAttempt->authorize_auth_code;
        $transaction->authorize_transaction_code = $completedTransactionAttempt->authorize_transaction_code;
        $transaction->authorize_transaction_description = $completedTransactionAttempt->authorize_transaction_description;
        $transaction->amount = $completedTransactionAttempt->amount;
        $transaction->reference = $completedTransactionAttempt->reference;
        $transaction->save();

        return $transaction;
    }

    public function creteInternalSubscription(string $term, User $user, Order $order, SubscriptionPlan $plan): Subscription
    {
        $now = Carbon::now();
        if($term == 'yearly') {
            $endsAt = $now->copy()->addYear(1);
        } else {
            $endsAt = $now->copy()->addMonth(1);
        }
        $pendingSubscription = new Subscription();
        $pendingSubscription->user_id = $user->id;
        $pendingSubscription->order_id = $order->id;
        $pendingSubscription->plan_id = $plan->id;
        $pendingSubscription->term = $term;
        $pendingSubscription->status = Subscription::STATUS_ACTIVE;
        $pendingSubscription->start_at = $now;
        $pendingSubscription->end_at = $endsAt;
        $pendingSubscription->authorize_subscription_id = Subscription::TYPE_INTERNAL;
        $pendingSubscription->save();

        return $pendingSubscription;
    }

    /**
     * @param string $term
     * @param User $user
     * @param Order $order
     * @param SubscriptionPlan $plan
     * @param float $amount
     * @return PendingSubscription
     * @throws \Exception
     */
    public function createPendingSubscription(string $term, User $user, Order $order, SubscriptionPlan $plan, float $amount) : PendingSubscription {
        $subscriptionStartsAt = $term == 'yearly' ? date('Y-m-d', strtotime('+ 1 year')) : date('Y-m-d', strtotime( ' + 1 month'));
        $dateinterval = $term == 'yearly' ? 'P1Y' : 'P1M';
        $subscriptionEndsAt = new \DateTime($subscriptionStartsAt);
        $subscriptionEndsAt->add(new \DateInterval($dateinterval));
        $pendingSubscription = new PendingSubscription();
        $pendingSubscription->user_id = $user->id;
        $pendingSubscription->order_id = $order->id;
        $pendingSubscription->plan_id = $plan->id;
        $pendingSubscription->amount = $amount;
        $pendingSubscription->status = PendingSubscription::STATUS_PENDING;
        $pendingSubscription->term = $term;
        $pendingSubscription->start_at = $subscriptionStartsAt;
        $pendingSubscription->end_at = $subscriptionEndsAt;
        $pendingSubscription->save();

        return $pendingSubscription;
    }

    /**
     * @param PendingSubscription $pendingSubscription
     * @param string $subscriptionId
     * @return Subscription
     */
    public function createSubscriptionFromPending(PendingSubscription $pendingSubscription, string $subscriptionId) : Subscription {
        $user = $pendingSubscription->user;
        $order = $pendingSubscription->order;
        $plan = $pendingSubscription->plan;
        $subscription = new Subscription();
        $subscription->user_id = $user->id;
        $subscription->order_id = $order->id;
        $subscription->plan_id = $plan->id;
        $subscription->term = $pendingSubscription->term;
        $subscription->status = 'active';
        $subscription->start_at = $pendingSubscription->start_at;
        $subscription->end_at = $pendingSubscription->end_at;
        $subscription->authorize_subscription_id = $subscriptionId;
        $subscription->save();
        $order->status = 'active';
        $order->save();

        return $subscription;
    }

    /**
     * @param PendingSubscription $pendingSubscription
     * @return PendingSubscription
     */
    public function updatePendingSubscriptionToSuccess(PendingSubscription $pendingSubscription) : PendingSubscription {
        $pendingSubscription->status = PendingSubscription::STATUS_SUCCESSFUL;
        $newAttempt = $pendingSubscription->attempts + 1;
        $pendingSubscription->attempts = $newAttempt;
        $pendingSubscription->save();

        return $pendingSubscription;
    }

    /**
     * @param PendingSubscription $pendingSubscription
     * @return PendingSubscription
     */
    public function updatePendingSubscriptionToFailed(PendingSubscription $pendingSubscription) : PendingSubscription {
        $pendingSubscription->status = PendingSubscription::STATUS_PENDING;
        $newAttempt = $pendingSubscription->attempts + 1;
        $pendingSubscription->attempts = $newAttempt;
        $pendingSubscription->save();

        return $pendingSubscription;
    }

    /**
     * @param PendingSubscription $pendingSubscription
     * @param bool $isSuccess
     * @param string $message
     * @param string $error
     * @return PendingSubscriptionResponses
     */
    public function createPendingSubscriptionResponse(
        PendingSubscription $pendingSubscription,
        bool $isSuccess,
        string $message = '',
        string $error = ''
    ) : PendingSubscriptionResponses {
        $pendingSubscriptionResponse = new PendingSubscriptionResponses();
        $pendingSubscriptionResponse->pending_subscription_id = $pendingSubscription->id;
        $pendingSubscriptionResponse->is_successful = $isSuccess;
        $pendingSubscriptionResponse->message = $message;
        if(!$isSuccess) {
            $pendingSubscriptionResponse->error_code = $error;
        }
        $pendingSubscriptionResponse->save();

        return $pendingSubscriptionResponse;
    }

    public function cancelSubscription(Subscription $subscription) : Subscription {

        $now = Carbon::now();
        if($subscription->term == 'yearly') {
            $created_at = new \DateTime($subscription->created_at);
            $yearsAfterFirstSubscription = $now->diffInYears($created_at->format('Y-m-d'));
            $shouldCancelAt = $subscription->created_at->copy()->addYears($yearsAfterFirstSubscription + 1);
        } else {
            $created_at = new \DateTime($subscription->created_at);
            $monthsAfterFirstSubscription = $now->diffInMonths($created_at->format('Y-m-d'));
            $shouldCancelAt = $subscription->created_at->copy()->addMonths($monthsAfterFirstSubscription + 1);
        }

        $subscription->should_cancel_at = $shouldCancelAt;
        $subscription->reactivation_email_count = 0; // will increase by 2 each time email is sent
        $subscription->reactivate_email_cancel_code = Str::random();
        $subscription->save();

        return $subscription;
    }

    public function createAdditionalLicence(GalleryItem $video, User $user, Transaction $transaction) {
        $additionalLicence = new AdditionalLicense();
        $additionalLicence->user_id = $user->id;
        $additionalLicence->video_id = $video->id;
        $additionalLicence->status = AdditionalLicense::STATUS_AVAILABLE;
        $additionalLicence->transaction_id = $transaction->id;
        $additionalLicence->save();

        return $additionalLicence;
    }
}
