<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Transactions
 *
 * @package App\Models
 * a
 * @property $id integer
 * @property $user_id integer
 * @property $order_id string
 * @property $status string
 * @property $type string
 * @property $amount float
 * @property $completed_at string
 * @property $created_at string
 * @property $updated_at string
 * @property $authorize_transaction_id string
 * @property $authorize_auth_code string
 * @property $authorize_transaction_code string
 * @property $authorize_transaction_description string
 * @property $reference string
 */


class Transaction extends Model
{
    use HasFactory;

    protected $dates = ['completed_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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
}
