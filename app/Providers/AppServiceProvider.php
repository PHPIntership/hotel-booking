<?php

namespace HotelBooking\Providers;

use Illuminate\Support\ServiceProvider;
use HotelBooking\AdminUser;
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
            if (!empty($adminUser->password) && Hash::needsRehash($adminUser->password)) {
                $adminUser->password = Hash::make($adminUser->password);
            }
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
