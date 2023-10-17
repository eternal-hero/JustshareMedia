<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AdditionalLicense extends Model
{
    const STATUS_AVAILABLE = 1;
    const STATUS_USED = 2;

    protected $table = 'additional_licences';
}
