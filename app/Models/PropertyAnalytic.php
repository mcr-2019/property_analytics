<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PropertyAnalytic
 *
 * @mixin \Eloquent
 * @property int $property_id
 * @property int $analytic_type_id
 * @property string $value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class PropertyAnalytic extends Model
{
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value',
        'created_at',
        'updated_at'
    ];

  	/**
     * Get the property for this analytic
     */
    public function property()
    {
        return $this->belongsTo('App\Models\Property');
    }

  	/**
     * Get the analytic type for this analytic
     */
    public function analytic_type()
    {
        return $this->belongsTo('App\Models\AnalyticType');
    }
}
