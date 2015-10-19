<?php

namespace HotelBooking\Providers;

use Illuminate\Support\ServiceProvider;
use HotelBooking\Order;
use HotelBooking\HotelRoomType;
use Carbon\Carbon;

class OrderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any Order Model services.
     */
    public function boot()
    {
        /**
         * Set status and price before creating Order.
         */
        Order::creating(function ($order) {
            $order->status = 0;
            $hotelRoomType = HotelRoomType::find($order->hotel_room_type_id, ['id','price']);
            if ($hotelRoomType) {
                $comingDate = new Carbon($order->coming_date);
                $leaveDate = new Carbon($order->leave_date);
                $days= $comingDate->diff($leaveDate)->days;
                $order->price = $hotelRoomType->price * $order->quantity * $days;
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
