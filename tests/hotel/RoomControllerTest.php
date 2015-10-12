<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use HotelBooking\Room;
use HotelBooking\HotelRoomType;

/**
 * Test class for RoomController
 */
class RoomControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test create action, GET method
     *
     * @return void
     */
    public function testCreateStatus()
    {
        $response = $this->call('GET', route('hotel.room.create'));
        $this->assertEquals(200, $response->status());
    }
}
