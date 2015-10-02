<?php

namespace HotelBooking;

use Illuminate\Database\Eloquent\Model;

/**
 *City model
 */
class City extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
}
