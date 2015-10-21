<?php

use HotelBooking\Room;
use HotelBooking\HotelRoomType;
use HotelBooking\CheckIn;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;

class CheckInServiceProviderTest extends TestCase
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
     * Create a temporary Room
     *
     * @param HotelRoomType $hotelRoomType
     *
     * @return HotelRoomType
     */
    private function seedRoom($hotelRoomType)
    {
        $data = [
            'hotel_room_type_id' => $hotelRoomType->id,
            'name' => 'A105',
        ];
        return Room::create($data);
    }

    /**
     * Create a temporary CheckIn
     *
     * @param Room $room
     *
     * @return CheckIn
     */
    private function seedCheckIn($room)
    {
        $data = [
            'room_id' => $room->id,
            'order_id' => 1,
            'hotel_admin_id' => 1,
            'coming_date' => Carbon::now()->toDateString(),
            'leave_date' => Carbon::now()->addDay(1)->toDateString(),
            'price' => 0,
        ];
        return CheckIn::create($data);
    }

    /**
     * Test that the Room status change into Used after creating CheckIn
     *
     * @return void
     */
    public function testCreatedCheckIn()
    {
        $hotelRoomType = $this->seedHotelRoomType();
        $room = $this->seedRoom($hotelRoomType);
        $checkIn = $this->seedCheckIn($room);
        $roomStatus = Room::find($room->id, ['status'])->status;
        $this->assertEquals($roomStatus, Room::USED_STATUS);
    }

    /**
     * Test that the CheckIn price set before updating CheckIn
     *
     * @return void
     */
    public function testUpdatingCheckIn()
    {
        $hotelRoomType = $this->seedHotelRoomType();
        $room = $this->seedRoom($hotelRoomType);
        $checkIn = $this->seedCheckIn($room);
        $checkIn->update(['leave_date' => Carbon::now()->addDay(3)->toDateString()]);
        $this->assertEquals($checkIn->price, 30);
    }

    /**
     * Test that the Room status change into Free after updating CheckIn
     *
     * @return void
     */
    public function testUpdatedCheckIn()
    {
        $hotelRoomType = $this->seedHotelRoomType();
        $room = $this->seedRoom($hotelRoomType);
        $checkIn = $this->seedCheckIn($room);
        $checkIn->update(['leave_date' => Carbon::now()->addDay(3)->toDateString()]);
        $room = Room::find($checkIn->room_id, ['status']);
        $this->assertEquals($room->status, Room::FREE_STATUS);
    }
}
