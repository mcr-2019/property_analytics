<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Property
 *
 * @mixin \Eloquent
 * @property string $guid
 * @property string $suburb
 * @property string $state
 * @property string $country
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Property extends Model
{
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'guid',
        'suburb',
        'state',
        'country',
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
