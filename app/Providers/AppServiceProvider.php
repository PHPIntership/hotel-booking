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
