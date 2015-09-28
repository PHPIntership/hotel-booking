<?php

namespace HotelBooking;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{

    protected $table = 'hotels';

    protected $fillable = ['city_id','name','quality','address','phone','email','website','image','description'];

}
