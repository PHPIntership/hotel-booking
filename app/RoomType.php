<?php

namespace HotelBooking;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * RoomType model
 */
class RoomType extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'room_types';

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
        'name',
        'quality',
        'image'
    ];
}
