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
        'status',
    ];

    /**
     *  Get the user that the booking manage.
     *
     * @return array
     */
    public function user()
    {
        return $this->belongsTo('HotelBooking\User', 'user_id');
    }

    /**
     *  Get the hotel room type that the booking manage.
     *
     * @return array
     */
    public function hotelRoomType()
    {
        return $this->belongsTo('HotelBooking\HotelRoomType', 'hotel_room_type_id');
    }
    /**
     * Get status name for admin hotel manage booking.
     *
     * @return string
     */
    public function getStatusNameAttribute()
    {
        switch ($this->status) {
            case self::WAITING_STATUS:
                return trans('messages.waiting');
                break;
            case self::ACCEPTED_STATUS:
                return trans('messages.accepted');
                break;
            case self::CHECKED_IN_STATUS:
                return trans('messages.checked_in');
                break;
            default:
                return trans('messages.disabled');
                break;
        }
    }
}
