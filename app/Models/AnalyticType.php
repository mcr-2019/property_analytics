<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AnalyticType
 *
 * @mixin \Eloquent
 * @property string $name
 * @property string $units
 * @property boolean $is_numeric
 * @property int $num_decimal_places
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class AnalyticType extends Model
{
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'units',
        'is_numeric',
        'num_decimal_places',
        'created_at',
        'updated_at'
    ];

  	/**
     * Get the analytic type for this analytic
     */
    public function property_analytics()
    {
        return $this->hasMany('App\Models\PropertyAnalytics');
    }
}
