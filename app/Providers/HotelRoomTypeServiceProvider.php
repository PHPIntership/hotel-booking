<?php

namespace HotelBooking\Providers;

use Illuminate\Support\ServiceProvider;
use HotelBooking\HotelRoomType;

class HotelRoomTypeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any HotelRoomType Model services.
     */
    public function boot()
    {
        /**
         * Set quantity before creating HotelRoomType.
         */
        HotelRoomType::creating(function ($hotelRoomType) {
            $hotelRoomType->quantity = 0;
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
