<?php

namespace HotelBooking\Providers;

use Illuminate\Support\ServiceProvider;
use HotelBooking\AdminUser;
use HotelBooking\AdminHotel;
use HotelBooking\User;
use HotelBooking\CheckIn;
use Carbon\Carbon;
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

        CheckIn::updating(function ($checkIn) {
            if((empty($checkIn->price) || $checkIn->price<1) && !empty($checkIn->coming_date) && !empty($checkIn->leave_date))
            {
                $comingDate = new Carbon($checkIn->coming_date);
                $leaveDate = new Carbon($checkIn->leave_date);
                $day= $comingDate->diff($leaveDate)->days+1;
                $checkIn->price = (isset($checkIn->room->hotelRoomType->price)
                ? $checkIn->room->hotelRoomType->price : 0) * $day;
            }
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
