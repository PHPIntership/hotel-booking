<?php

namespace HotelBooking;

use Illuminate\Database\Eloquent\Model;

/**
 * AdminHotel model
 */
class AdminHotel extends Model
{
    //
    protected $table = 'admin_hotels';

    protected $fillable = [
        'hotel_id',
        'username',
        'password',
        'name',
        'email',
        'phone'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];
}
