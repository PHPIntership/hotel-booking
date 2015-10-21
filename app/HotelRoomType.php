<?php

namespace HotelBooking;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotelRoomType extends Model
{
    use SoftDeletes;

    /**
     * Key congig uploads.
     */
    const UPLOAD_KEY = 'hotel_room_type';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'hotel_room_types';

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
        'room_type_id',
        'hotel_id',
        'name',
        'quality',
        'quantity',
        'price',
        'image',
        'description',
    ];

    /**
     * Get base link of hotel room type.
     */
    public function getImageLinkAttribute()
    {
        if (!empty($this->image)) {
            return asset(config('uploads.'.self::UPLOAD_KEY).$this->image);
        }

        return '';
    }

    /**
     * Get the room type that the hotel manage.
     */
    public function roomType()
    {
        return $this->belongsTo('HotelBooking\RoomType', 'room_type_id');
    }
    /**
     * Get the room type that the hotel manage.
     */
    public function hotel()
    {
        return $this->belongsTo('HotelBooking\Hotel', 'hotel_id');
    }
}
