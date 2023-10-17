<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerCompany extends Model
{
    use HasFactory;

    public function subscriptions() {
        return $this->belongsToMany(Subscription::class)->withPivot(['commission', 'is_percentage'])->withTimestamps();
    }
}
