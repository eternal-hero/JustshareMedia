<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Stores responses of the payment gateway subscribe request
 * Class PendingSubscriptionResponses
 * @package App\Models
 * @property $id integer
 * @property $pending_subscription_id integer
 * @property $is_successful boolean
 * @property $message string
 * @property $error_code string
 * @property $created_at string
 * @property $updated_at string
 */
class PendingSubscriptionResponses extends Model
{
    use HasFactory;
}
