<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Keeps Subscribe state before sending it to payment gateway
 * Class PendingSubscription
 * @package App\Models
 * @property $user_id integer
 * @property $order_id integer
 * @property $plan_id integer
 * @property $amount float
 * @property $status integer
 * @property $attempts integer
 * @property $term string
 * @property $start_at string
 * @property $end_at string.
 * @property $created_at string
 * @property $updated_at string
 * @property $user
 * @property $order
 * @property $plan
 */
class PendingSubscription extends Model
{
    /**
     * Initial state
     */
    const STATUS_PENDING = 0;
    /**
     * If request to payment gateway successes
     */
    const STATUS_SUCCESSFUL = 1;

    /**
     * Max number of tries to subscribe user
     */
    const MAX_ATTEMPTS = 3;

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    /**
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return HasMany
     */
    public function responses(): HasMany
    {
        return $this->hasMany(PendingSubscriptionResponses::class);
    }
}
