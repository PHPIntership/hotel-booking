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
     * room.
     *
     * @return Room
     */
    public function room()
    {
        return $this->belongsToMany('\HotelBooking\Room', 'checkins');
    }

    /**
     *  Get the user that the booking manage.
     */
    public function user()
    {
        return $this->belongsTo('HotelBooking\User', 'user_id');
    }

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
    public function syncRoom($data)
    {
        if (is_array($data)) {
            $this->room()->sync($data);
        }
    }

    public function getComingDateFormatAttribute()
    {
        if (!empty($this->coming_date)) {
            return date('Y/m/d', strtotime($this->coming_date));
        }

        return '';
    }

    public function getLeaveDateFormatAttribute()
    {
        if (!empty($this->leave_date)) {
            return date('Y/m/d', strtotime($this->leave_date));
        }

        return '';
    }
}
