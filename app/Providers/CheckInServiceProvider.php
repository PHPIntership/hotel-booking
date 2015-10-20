<?php

namespace HotelBooking\Providers;

use Illuminate\Support\ServiceProvider;
use HotelBooking\CheckIn;
use HotelBooking\Room;
use HotelBooking\HotelRoomType;
use Carbon\Carbon;

class CheckInServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any CheckIn Model services.
     */
    public function boot()
    {
        /**
         * Update Room status after creating CheckIn.
         */
        CheckIn::created(function ($checkIn) {
            $room = Room::find($checkIn->room_id, ['id','status']);
            if ($room) {
                $room->status = 1;
                $room->save();
            }
        });

        /**
         * Set price before updating CheckIn.
         */
        CheckIn::updating(function ($checkIn) {
            if ($checkIn->leave_date) {
                $oldCheckIn = CheckIn::find($checkIn->id, ['coming_date']);
                $room = Room::find($checkIn->room_id, ['id', 'hotel_room_type_id']);
                $hotelRoomType = HotelRoomType::find($room->hotel_room_type_id, ['id','price']);
                if ($room && $hotelRoomType && $oldCheckIn) {
                    $comingDate = new Carbon($oldCheckIn->coming_date);
                    $leaveDate = new Carbon($checkIn->leave_date);
                    $days= $comingDate->diff($leaveDate)->days;
                    $checkIn->price = $hotelRoomType->price * $days;
                }
            }
        });

        /**
         * Update Room status after updating CheckIn.
         */
        CheckIn::updated(function ($checkIn) {
            if ($checkIn->leave_date) {
                $room = Room::find($checkIn->room_id, ['id']);
                if($room) {
                    $room->status = 0;
                    $room->save();
                }
            }
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
