<?php

use HotelBooking\Room;
use HotelBooking\HotelRoomType;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoomServiceProviderTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test that the Room status is Free on creating
     *
     * @return void
     */
    public function testCreatingRoom()
    {
        $data = [
            'hotel_room_type_id' => 1,
            'name' => 'A105',
            'status' => Room::OTHER_STATUS,
        ];
        $room = Room::create($data);
        $this->assertEquals($room->status, Room::FREE_STATUS);
    }

    /**
     * Test that the Room status is Free on creating without status
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
        $this->assertEquals($room->status, Room::FREE_STATUS);
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
     * after updating Room status from Free to Other
     *
     * @return void
     */
    public function testUpdatedRoomFreeToOther()
    {
        $hotelRoomType = $this->seedHotelRoomType();
        $room = $this->seedRoom($hotelRoomType);
        $room->update(['status' => Room::OTHER_STATUS]);
        $quantity = HotelRoomType::find($hotelRoomType->id, ['quantity'])->quantity;
        $this->assertEquals($quantity, 0);
    }

    /**
     * Test that the HotelRoomType quantity increased 1
     * after updating Room status from Other to Free
     *
     * @return void
     */
    public function testUpdatedRoomOtherToFree()
    {
        $hotelRoomType = $this->seedHotelRoomType();
        $room = $this->seedRoom($hotelRoomType);
        $room->update(['status' => Room::OTHER_STATUS]);
        $room->update(['status' => Room::FREE_STATUS]);
        $quantity = HotelRoomType::find($hotelRoomType->id, ['quantity'])->quantity;
        $this->assertEquals($quantity, 1);
    }

    /**
     * Test that the HotelRoomType quantity nochange
     * after updating Room status from Free to Used
     *
     * @return void
     */
    public function testUpdatedRoomFreeToUsed()
    {
        $hotelRoomType = $this->seedHotelRoomType();
        $room = $this->seedRoom($hotelRoomType);
        $room->update(['status' => Room::USED_STATUS]);
        $quantity = HotelRoomType::find($hotelRoomType->id, ['quantity'])->quantity;
        $this->assertEquals($quantity, 1);
    }

    /**
     * Test that the HotelRoomType quantity nochange
     * after updating Room status from Used to Free
     *
     * @return void
     */
    public function testUpdatedRoomUsedToFree()
    {
        $hotelRoomType = $this->seedHotelRoomType();
        $room = $this->seedRoom($hotelRoomType);
        $room->update(['status' => Room::USED_STATUS]);
        $room->update(['status' => Room::FREE_STATUS]);
        $quantity = HotelRoomType::find($hotelRoomType->id, ['quantity'])->quantity;
        $this->assertEquals($quantity, 1);
    }

    /**
     * Test that the HotelRoomType quantity decreased 1
     * after updating Room status from Used to Other
     *
     * @return void
     */
    public function testUpdatedRoomUsedToOther()
    {
        $hotelRoomType = $this->seedHotelRoomType();
        $room = $this->seedRoom($hotelRoomType);
        $room->update(['status' => Room::USED_STATUS]);
        $room->update(['status' => Room::OTHER_STATUS]);
        $quantity = HotelRoomType::find($hotelRoomType->id, ['quantity'])->quantity;
        $this->assertEquals($quantity, 0);
    }

    /**
     * Test that the HotelRoomType quantity increased 1
     * after updating Room status from Other to Used
     *
     * @return void
     */
    public function testUpdatedRoomOtherToUsed()
    {
        $hotelRoomType = $this->seedHotelRoomType();
        $room = $this->seedRoom($hotelRoomType);
        $room->update(['status' => Room::OTHER_STATUS]);
        $room->update(['status' => Room::USED_STATUS]);
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
        $room->update(['status' => Room::USED_STATUS]);
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
        $room->update(['status' => Room::OTHER_STATUS]);
        $room->delete();
        $quantity = HotelRoomType::find($hotelRoomType->id, ['quantity'])->quantity;
        $this->assertEquals($quantity, 0);
    }
}
