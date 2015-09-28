<?php

namespace HotelBooking;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class AdminUser extends Model implements AuthenticatableContract, AuthorizableContract
{

    use Authenticatable, Authorizable;
    protected $table = 'admin_users';
    protected $fillable = ['id', 'username', 'password'];
    //protected $hidden = ['password', 'remember_token'];
}
