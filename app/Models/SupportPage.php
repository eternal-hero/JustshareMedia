<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TaxRates
 *
 * @package App\Models
 * @property $id integer
 * @property $title string
 * @property $url string
 * @property $content text
 * @property $created_at string
 * @property $updated_at string
 */
class SupportPage extends Model
{
    use HasFactory;

    public $table = 'support_pages';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'url',
        'content',
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

}
