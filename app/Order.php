<?php

namespace HotelBooking;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    /**
     * Constants of Order status.
     *
     * @var int
     */
    const WAITING_STATUS = 0;
    const ACCEPTED_STATUS = 1;
    const CHECKED_IN_STATUS = 2;
    const DISABLED_STATUS = 3;

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
     * Get the hotel room type that the order's.
     */
    public function hotelRoomType()
    {
        return $this->belongsTo('HotelBooking\HotelRoomType', 'hotel_room_type_id');
    }

    /**
     * Get free rooms quantity of current order.
     */
    public function getAvailableRoomQuantityAttribute()
    {
        return $this->hotelRoomType->getAvailableRoomQuantityAttribute(
            $this->coming_date,
            $this->leave_date
        );
    }
}
