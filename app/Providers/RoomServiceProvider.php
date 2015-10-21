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
         * Set Room status before creating Room.
         */
        Room::creating(function ($room) {
            $room->status = 0;
        });

        /**
         * Update HotelRoomType quantity after creating Room.
         */
        Room::created(function ($room) {
            $hotelRoomType = HotelRoomType::find($room->hotel_room_type_id, ['id','quantity']);
            if ($hotelRoomType) {
                $hotelRoomType->quantity += 1;
                $hotelRoomType->save();
            }
        });

        /**
         * Update HotelRoomType quantity after updating Room.
         */
        Room::updated(function ($room) {
            $hotelRoomType = HotelRoomType::find($room->hotel_room_type_id, ['id','quantity']);
            if ($hotelRoomType) {
                $quantity = Room::where('hotel_room_type_id', $room->hotel_room_type_id)
                    ->whereIn('status', [0, 1])
                    ->count('id');
                $hotelRoomType->update(['quantity' => $quantity]);
            }
        });

        /**
         * Update HotelRoomType quantity after deleting Room.
         */
        Room::deleted(function ($room) {
            $hotelRoomType = HotelRoomType::find($room->hotel_room_type_id, ['id','quantity']);
            if ($hotelRoomType) {
                $quantity = Room::where('hotel_room_type_id', $room->hotel_room_type_id)
                    ->whereIn('status', [0, 1])
                    ->count('id');
                $hotelRoomType->update(['quantity' => $quantity]);
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
