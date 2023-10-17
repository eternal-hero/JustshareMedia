<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionAttempt extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';

    public function user() {
        return $this->belongsTo(User::class);
    }
}
