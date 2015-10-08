<?php

namespace HotelBooking;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *Hotel model.
 */
class Hotel extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'hotels';

    /**
     * Define attributes deleted_at of the data.
     *
     * @var string
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'city_id',
        'name',
        'quality',
        'address',
        'phone',
        'email',
        'website',
        'image',
        'description',
    ];

    /**
     * Get the city that locate the hotel.
     */
    public function city()
    {
        return $this->belongsTo('HotelBooking\City', 'city_id');
    }
}
