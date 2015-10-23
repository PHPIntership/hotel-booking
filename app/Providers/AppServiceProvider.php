<?php

namespace HotelBooking\Providers;

use Illuminate\Support\ServiceProvider;
use HotelBooking\AdminUser;
use HotelBooking\AdminHotel;
use HotelBooking\User;
use Hash;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        /**
         * Hashing password before creating an Hotel admin user.
         */
        AdminHotel::creating(function ($adminHotel) {
            $adminHotel->password = Hash::make($adminHotel->password);
        });

        /**
         * Hashing password before creating an user.
         */
        User::creating(function ($user) {
            $user->password = Hash::make($user->password);
        });
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }
}
