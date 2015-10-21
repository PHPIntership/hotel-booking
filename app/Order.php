<?php

namespace HotelBooking;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

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
        'user_id',
        'hotel_room_type_id',
        'coming_date',
        'leave_date',
        'quantity',
        'price',
        'comment',
        'quantity',
        'status'
    ];
    /**
     * Get the room type that the hotel manage.
     */
    public function hotelRoomType()
    {
        return $this->belongsTo('HotelBooking\HotelRoomType', 'hotel_room_type_id');
    }
}
