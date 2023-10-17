<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TaxRates
 *
 * @package App\Models
 * @property $id integer
 * @property $state_name string
 * @property $state_iso_code string
 * @property $tax_rate float
 * @property $created_at string
 * @property $updated_at string
 */

class TaxRate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'state_name',
        'state_iso_code',
        'tax_rate',
        'created_at',
        'updated_at'
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

    public static function getTaxRate($state_code)
    {
        if(!$state_code) {
            return 0;
        }
        $tax = (TaxRate::where(['state_iso_code' => $state_code])->first())->tax_rate;
        return $tax != null ? $tax : 0;
    }

}
