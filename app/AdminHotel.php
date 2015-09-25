<?php

namespace HotelBooking;

use Illuminate\Database\Eloquent\Model;

class AdminHotel extends Model
{
    //
    protected $table='admin_hotels';

    protected $fillable = ['hotel_id', 'username', 'password', 'name', 'email', 'phone'];

    protected $hidden = ['password', 'remember_token'];

    public function getHotel()
    {
        return $this->hasOne('HotelBooking\Hotel','id','hotel_id');
    }
}
