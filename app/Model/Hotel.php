<?php

namespace HotelBooking\Model;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{

    protected $table = 'hotels';

    protected $fillable = ['name','quality','address','phone','website','image','description'];

}
