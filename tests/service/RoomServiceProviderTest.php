<?php

use HotelBooking\Room;
use HotelBooking\HotelRoomType;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoomServiceProviderTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test that the Room status = 0 on creating
     *
     * @return void
     */
    public function testCreatingRoom()
    {
        $data = [
            'hotel_room_type_id' => 1,
            'name' => 'A105',
            'status' => 1,
        ];
        $room = Room::create($data);
        $this->assertEquals($room->status, 0);
    }

    /**
     * Test that the Room status = 0 on creating without status
     *
     * @return void
     */
    public function testCreatingRoomWithoutStatus()
    {
        $data = [
            'hotel_room_type_id' => 1,
            'name' => 'A105',
        ];
        $room = Room::create($data);
        $this->assertEquals($room->status, 0);
    }

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
            'price' => 0,
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
            'status' => 0,
        ];
        return Room::create($data);
    }

    /**
     * Test that the HotelRoomType quantity increased 1 after creating Room
     *
     * @return void
     */
    public function testCreatedRoom()
    {
        $hotelRoomType = $this->seedHotelRoomType();
        $room = $this->seedRoom($hotelRoomType);
        $quantity = HotelRoomType::find($hotelRoomType->id, ['quantity'])->quantity;
        $this->assertEquals($quantity, 1);
    }

    /**
     * Test that the HotelRoomType quantity decreased 1
     * after updating Room status from Free(0) to Other(2)
     *
     * @return void
     */
    public function testUpdatedRoom0To2()
    {
        $hotelRoomType = $this->seedHotelRoomType();
        $room = $this->seedRoom($hotelRoomType);
        $room->update(['status' => 2]);
        $quantity = HotelRoomType::find($hotelRoomType->id, ['quantity'])->quantity;
        $this->assertEquals($quantity, 0);
    }

    /**
     * Test that the HotelRoomType quantity increased 1
     * after updating Room status from Other(2) to Free(0)
     *
     * @return void
     */
    public function testUpdatedRoom2To0()
    {
        $hotelRoomType = $this->seedHotelRoomType();
        $room = $this->seedRoom($hotelRoomType);
        $room->update(['status' => 2]);
        $room->update(['status' => 0]);
        $quantity = HotelRoomType::find($hotelRoomType->id, ['quantity'])->quantity;
        $this->assertEquals($quantity, 1);
    }

    /**
     * Test that the HotelRoomType quantity nochange
     * after updating Room status from Free(0) to Used(1)
     *
     * @return void
     */
    public function testUpdatedRoom0To1()
    {
        $hotelRoomType = $this->seedHotelRoomType();
        $room = $this->seedRoom($hotelRoomType);
        $room->update(['status' => 1]);
        $quantity = HotelRoomType::find($hotelRoomType->id, ['quantity'])->quantity;
        $this->assertEquals($quantity, 1);
    }

    /**
     * Test that the HotelRoomType quantity nochange
     * after updating Room status from Used(1) to Free(0)
     *
     * @return void
     */
    public function testUpdatedRoom1To0()
    {
        $hotelRoomType = $this->seedHotelRoomType();
        $room = $this->seedRoom($hotelRoomType);
        $room->update(['status' => 1]);
        $room->update(['status' => 0]);
        $quantity = HotelRoomType::find($hotelRoomType->id, ['quantity'])->quantity;
        $this->assertEquals($quantity, 1);
    }

    /**
     * Test that the HotelRoomType quantity decreased 1
     * after updating Room status from Used(1) to Other(2)
     *
     * @return void
     */
    public function testUpdatedRoom1To2()
    {
        $hotelRoomType = $this->seedHotelRoomType();
        $room = $this->seedRoom($hotelRoomType);
        $room->update(['status' => 1]);
        $room->update(['status' => 2]);
        $quantity = HotelRoomType::find($hotelRoomType->id, ['quantity'])->quantity;
        $this->assertEquals($quantity, 0);
    }

    /**
     * Test that the HotelRoomType quantity increased 1
     * after updating Room status from Other(2) to Used(1)
     *
     * @return void
     */
    public function testUpdatedRoom2To1()
    {
        $hotelRoomType = $this->seedHotelRoomType();
        $room = $this->seedRoom($hotelRoomType);
        $room->update(['status' => 2]);
        $room->update(['status' => 1]);
        $quantity = HotelRoomType::find($hotelRoomType->id, ['quantity'])->quantity;
        $this->assertEquals($quantity, 1);
    }

    /**
     * Test that the HotelRoomType quantity decreased 1
     * after deleting Free Room
     *
     * @return void
     */
    public function testDeletedFreeRoom()
    {
        $hotelRoomType = $this->seedHotelRoomType();
        $room = $this->seedRoom($hotelRoomType);
        $room->delete();
        $quantity = HotelRoomType::find($hotelRoomType->id, ['quantity'])->quantity;
        $this->assertEquals($quantity, 0);
    }

    /**
     * Test that the HotelRoomType quantity decreased 1
     * after deleting Used Room
     *
     * @return void
     */
    public function testDeletedUsedRoom()
    {
        $hotelRoomType = $this->seedHotelRoomType();
        $room = $this->seedRoom($hotelRoomType);
        $room->update(['status' => 1]);
        $room->delete();
        $quantity = HotelRoomType::find($hotelRoomType->id, ['quantity'])->quantity;
        $this->assertEquals($quantity, 0);
    }

    /**
     * Test that the HotelRoomType quantity nochange
     * after deleting Other Room
     *
     * @return void
     */
    public function testDeletedOtherRoom()
    {
        $hotelRoomType = $this->seedHotelRoomType();
        $room = $this->seedRoom($hotelRoomType);
        $room->update(['status' => 2]);
        $room->delete();
        $quantity = HotelRoomType::find($hotelRoomType->id, ['quantity'])->quantity;
        $this->assertEquals($quantity, 0);
    }
}
