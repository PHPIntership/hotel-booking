<?php

namespace HotelBooking;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotel extends Model
{
    use SoftDeletes;
    protected $table = 'hotels';
    protected $dates = ['deleted_at'];
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
}
