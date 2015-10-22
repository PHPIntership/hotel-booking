<?php

namespace HotelBooking;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *Room model.
 */
class Room extends Model
{
    use SoftDeletes;

    /**
     * Constants of Room status.
     *
     * @var int
     */
    const FREE_STATUS = 0;
    const USED_STATUS = 1;
    const OTHER_STATUS = 2;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rooms';

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
        'hotel_room_type_id',
        'name',
        'status',
    ];

    /**
     * Get the hotelRoomType of the Room.
     */
    public function hotelRoomType()
    {
        return $this->belongsTo('HotelBooking\HotelRoomType', 'hotel_room_type_id');
    }
}
