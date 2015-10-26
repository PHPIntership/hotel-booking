<?php

namespace HotelBooking;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class CheckIn extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'checkins';

    /**
     * Define attributes deleted_at of the data.
     *
     * @var string
     */
    protected $dates = [
        'deleted_at',
        'coming_date',
        'leave_date',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'room_id',
        'order_id',
        'hotel_admin_id',
        'coming_date',
        'leave_date',
        'price',
    ];

    public function getComingDateFormatAttribute()
    {
        if (!empty($this->coming_date)) {
            return $this->coming_date->format('Y/m/d');
        }

        return '';
    }

    public function getLeaveDateFormatAttribute()
    {
        if (!empty($this->leave_date)) {
            return $this->leave_date->format('Y/m/d');
        } else {
            return date('Y/m/d');
        }
    }

    public function room()
    {
        return $this->belongsTo('\HotelBooking\Room');
    }

    public function getPayPriceAttribute()
    {
        if (!empty($this->price)) {
            return $this->price;
            //return number_format($this->price, 2, ',', '.');
        } else {
            if (empty($this->leave_date) || empty($this->room_id)) {
                return '';
            }
            $comingDate = new Carbon($this->coming_date);
            $leaveDate = new Carbon($this->leave_date);
            $days = $comingDate->diff($leaveDate)->days;

            return $this->room->hotelRoomType->price * $days;
            //return number_format($this->room->hotelRoomType->price * $days, 2, '.', ',');
        }

        return '';
    }

    public static function validate($request, $order = null)
    {
        //$checkInRules = 'required|date_format:Y/m/d|date|after:'.$order->coming_date.'|before:'.$order->leave_date;
        $leaveDate = new Carbon($order->leave_date);
        $rules = [
            'room_id' => 'required|exists:rooms,id',
            'coming_date' => 'date_format:Y/m/d|date|after:'.$order->coming_date.'|before:'.$leaveDate->addday() ,
            'leave_date' => 'date_format:Y/m/d|date|after:'.$order->coming_date.'|before:'.$leaveDate->addday(),
            'price' => 'numeric',
        ];
        //dd($rules);
        return \Validator::make($request, $rules);
    }
}
