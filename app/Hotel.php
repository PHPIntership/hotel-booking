<?php

namespace HotelBooking;

use Illuminate\Database\Eloquent\Model;

/**
 *Hotel model
 */
class Hotel extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'hotels';

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
        'description'
    ];

    /**
     * Get the city that locate the hotel.
     */
    public function city()
    {
        return $this->belongsTo('App\City', 'city_id');
    }
}
