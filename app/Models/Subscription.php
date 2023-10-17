<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * Class Subscription
 *
 * @package App\Models
 * a
 * @property $id integer
 * @property $user_id integer
 * @property $order_id integer
 * @property $plan_id integer
 * @property $term string
 * @property $status string
 * @property $start_at string
 * @property $end_at string
 * @property $created_at string
 * @property $updated_at string
 * @property $authorize_subscription_id string
 */

class Subscription extends Model
{

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($subscription) {
            if($subscription->isDirty('status') && $subscription->id) {
                $newSubscriptionState = new SubscriptionStatusStates();
                $newSubscriptionState->subscription_id = $subscription->id;
                $newSubscriptionState->previous_state = $subscription->getOriginal()['status'];
                $newSubscriptionState->new_state = $subscription->status;
                $newSubscriptionState->save();
            }
        });
    }

    use HasFactory;

    const STATUS_ACTIVE = 'active';
    const STATUS_CANCELED = 'canceled';
    const STATUS_UNPAID = 'unpaid';
    const TYPE_INTERNAL = 'internal';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'user_id',
       'order_id',
       'plan_id',
       'term',
       'status',
       'start_at',
       'end_at',
       'created_at',
       'updated_at',
       'authorize_subscription_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    protected $dates = [
        'should_cancel_at',
        'end_at'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    /**
     * Check if this subscription is active
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->status == 'active' ? true : false;
    }

    public function salesReps() {
        return $this->belongsToMany(SalesRep::class)->withPivot(['commission', 'is_percentage'])->withTimestamps();
    }

    public function partnerCompanies() {
        return $this->belongsToMany(PartnerCompany::class)->withPivot(['commission', 'is_percentage'])->withTimestamps();
    }

    public function previousStates() {
        return $this->hasMany(SubscriptionStatusStates::class);
    }

    public function lastStatusChange() {
        return $this->hasOne(SubscriptionStatusStates::class)->latest();
    }

    public function lead() {
        return $this->belongsTo(Leads::class, 'lead_id', 'id');
    }

    public function cancelReason() {
        return $this->belongsTo(CancelReason::class, 'reason_id', 'id');
    }
}
