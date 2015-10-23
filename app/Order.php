<?php

namespace HotelBooking;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    const WAITING_STATUS = 0;
    const ACCEPTED_STATUS = 1;
    const CHECKED_STATUS = 2;
    const DISABLED_STATUS = 3;

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

    public function room() {
		return $this->belongsToMany('\HotelBooking\Room', 'checkins');
	}

    public function syncRoom($data)
    {
        if(is_array($data)) {
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
