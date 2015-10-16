<?php

namespace HotelBooking\Providers;

use Illuminate\Support\ServiceProvider;
use HotelBooking\Room;
use HotelBooking\HotelRoomType;

class RoomServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any Room Model services.
     */
    public function boot()
    {
        /**
         * Update HotelRoomType quantity after creating Room.
         */
        Room::created(function ($room) {
            $hotelRoomType = HotelRoomType::find($room->hotel_room_type_id, ['id','quantity']);
            if ($room->status <2 && $hotelRoomType) {
                $hotelRoomType->quantity += 1;
                $hotelRoomType->save();
            }
        });

        /**
         * Update HotelRoomType quantity before updating Room.
         */
        Room::updating(function ($room) {
            $oldRoom = Room::find($room->id, ['id', 'status']);
            $hotelRoomType = HotelRoomType::find($room->hotel_room_type_id, ['id','quantity']);
            if ($oldRoom && $room->status != null && $hotelRoomType) {
                if ($room->status < 2 && $oldRoom->status >= 2) {
                    $hotelRoomType->quantity += 1;
                } else if ($room->status >= 2 && $oldRoom->status < 2) {
                    $hotelRoomType->quantity -= 1;
                }
                $hotelRoomType->save();
            }
        });

        /**
         * Update HotelRoomType quantity before deleting Room.
         */
        Room::deleting(function ($room) {
            $currentRoom = Room::find($room->id,['status']);
            $hotelRoomType = HotelRoomType::find($room->hotel_room_type_id, ['id','quantity']);
            if ($currentRoom && $currentRoom->status <2 && $hotelRoomType) {
                $hotelRoomType->quantity -= 1;
                $hotelRoomType->save();
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
