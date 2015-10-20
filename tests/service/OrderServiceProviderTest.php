<?php

use HotelBooking\Order;
use HotelBooking\HotelRoomType;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;

class OrderServiceProviderTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Create a temporary HotelRoomType
     *
     * @return HotelRoomType
     */
    private function seedHotelRoomType()
    {
        $data = [
            'room_type_id' => 1,
            'hotel_id' => 1,
            'name' => 'hotel_room_type_1',
            'quality' => 'normal',
            'quantity' => 0,
            'price' => 10,
            'description' => '',
        ];
        return HotelRoomType::create($data);
    }

    /**
     * Create a temporary Order
     *
     * @param HotelRoomType $hotelRoomType
     *
     * @return Order
     */
    private function seedOrder($hotelRoomType)
    {
        $data = [
            'user_id' => 1,
            'hotel_room_type_id' => $hotelRoomType->id,
            'coming_date' => Carbon::now()->toDateString(),
            'leave_date' => Carbon::now()->addDay(3)->toDateString(),
            'quantity' => 2,
            'price' => 0,
            'comment' => '',
            'status' => 1,
        ];
        return Order::create($data);
    }

    /**
     * Test that the Order status and price set before creating Order
     *
     * @return void
     */
    public function testCreatingOrder()
    {
        $hotelRoomType = $this->seedHotelRoomType();
        $order = $this->seedOrder($hotelRoomType);
        $this->assertEquals($order->status, 0);
        $this->assertEquals($order->price, 60);
    }

    /**
     * Test that the Order price set before updating Order
     *
     * @return void
     */
    public function testUpdatingOrder()
    {
        $hotelRoomType = $this->seedHotelRoomType();
        $order = $this->seedOrder($hotelRoomType);
        $order->update(['leave_date' => Carbon::now()->addDay(4)->toDateString()]);
        $this->assertEquals($order->price, 80);
    }
}
