<?php

namespace HotelBooking;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

/**
 * AdminHotel model.
 */
class AdminHotel extends Model implements AuthenticatableContract, AuthorizableContract
{
    /**
     * Determine the class is authenticate
     */
    use Authenticatable, Authorizable;
    /**
     * Determine the class is using soft delete.
     */
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'admin_hotels';

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
        'hotel_id',
        'username',
        'password',
        'name',
        'email',
        'phone',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     *  Get the hotel that the admin hotel manage.
     *
     * @return array
     */
    public function hotel()
    {
        return $this->belongsTo('HotelBooking\Hotel', 'hotel_id');
    }
}
