<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * Class OrderItem
 *
 * @package App\Models
 * @property $id integer
 * @property $order_id integer
 * @property $type string
 * @property $name string
 * @property $data string
 * @property $amount float
 * @property $created_at string
 * @property $updated_at string
 */
class OrderItem extends Model
{
    use HasFactory;

    /**
     * Order relationship
     *
     * @return \App\Models\Order $order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
