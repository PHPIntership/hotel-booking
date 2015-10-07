<?php

namespace HotelBooking\Providers;

use Illuminate\Support\ServiceProvider;
use HotelBooking\AdminUser;
use HotelBooking\AdminHotel;
use Hash;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // AdminUser::updating(function ($adminUser) {
        //     //dd(password_needs_rehash($adminUser->password, PASSWORD_BCRYPT));
        //     dd(Hash::needsRehash($adminUser->remember_token));
        //     if (!empty($adminUser->password)) {
        //         $adminUser->password = Hash::make($adminUser->password);
        //     }
        // });
        AdminHotel::creating(function ($adminHotel) {
            $adminHotel->password = Hash::make($adminHotel->password);
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
