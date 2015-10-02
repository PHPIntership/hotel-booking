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
     *
     * @return void
     */
    public function boot()
    {
        AdminUser::updating(function ($adminUser) {
            if (!empty($adminUser->password) && !Hash::needsRehash($adminUser->password)) {
                $adminUser->password = Hash::make($adminUser->password);
            }
        });
        AdminHotel::creating(function ($adminHotel) {
            $adminHotel->password = Hash::make($adminHotel->password);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
