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

        /**
         * Set price before updating Order.
         */
        Order::updating(function ($order) {
            $hotelRoomType = HotelRoomType::find($order->hotel_room_type_id, ['id','price']);
            $oldOrder = Order::find($order->id, ['coming_date', 'leave_date']);
            if ($hotelRoomType && $oldOrder && $order->leave_date) {
                $comingDate = new Carbon($oldOrder->coming_date);
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
