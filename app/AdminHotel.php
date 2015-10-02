<?php

namespace HotelBooking;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * AdminHotel model
 */
class AdminHotel extends Model
{
    use SoftDeletes;
    protected $table = 'admin_hotels';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'hotel_id',
        'username',
        'password',
        'name',
        'email',
        'phone',
        'deleted_at'
    ];
    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function hotel()
    {
        return $this->belongsTo('HotelBooking\Hotel', 'hotel_id');
    }
}
