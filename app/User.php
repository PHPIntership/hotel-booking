<?php

namespace HotelBooking;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * User model
 */
class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{

    /**
     * Determine the class is using authentication
     */
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * Determine the class is using soft delete
     */
    use SoftDeletes;
    /**
    * Key config uploads.
    */
    const UPLOAD_KEY = 'user';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
        'name',
        'address',
        'email',
        'phone',
        'image',
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
    * Get base image link of user
    * @return string
    */
    public function getImageLinkAttribute()
    {
        if (!empty($this->image)) {
            return asset(config('uploads.'.self::UPLOAD_KEY).$this->image);
        }
        return '';
    }
}
