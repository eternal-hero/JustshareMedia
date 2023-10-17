<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TaxRates
 *
 * @package App\Models
 * @property $id integer
 * @property $user_id integer
 * @property $name string
 * @property $latitude string
 * @property $longitude string
 * @property $address string
 * @property $created_at string
 * @property $updated_at string
 */
class OperateLocation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'name',
        'latitude',
        'longitude',
        'address',
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

    /**
     * @param $point1
     * @param $point2
     * @return float|int
     */
    public static function calculateDistance($point1, $point2)
    {
        //https://cloud.google.com/blog/products/maps-platform/how-calculate-distances-map-maps-javascript-api
        $r = 3958.8; // Radius of the Earth in miles
        //To use kilometers, set $r = 6371.0710
        $rlat1 = $point1->latitude * (pi() / 180); // Convert degrees to radians
        $rlat2 = $point2->latitude * (pi() / 180); // Convert degrees to radians
        $difflat = $rlat2 - $rlat1; // Radian difference (latitudes)
        $difflon = ($point2->longitude - $point1->longitude) * (pi() / 180); // Radian difference (longitudes)
        $distance = 2 * $r * asin(sqrt(sin($difflat / 2) * sin($difflat / 2) + cos($rlat1) * cos($rlat2) * sin($difflon / 2) * sin($difflon / 2)));

        return $distance;
    }
}
