<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use HotelBooking\RoomType;

class RoomTypeControllerTest extends TestCase
{
    //use WithoutMiddleware;

    /**
     * create room type.
     *
     * @return HotelBooking\RoomType
     */
    public function createRoomType()
    {
        $faker = Faker\Factory::create();
        $roomType = RoomType::create([
            'name' => $faker->name,
            'quality' => 'good',
        ]);

        return $roomType;
    }

    /**
     * test status create action.
     */
    public function testCreateStatus()
    {
        $response = $this->call('GET', route('admin.room-type.create'));
        $this->assertEquals(200, $response->status());
    }

    /**
     * test status store action.
     */
    public function testStoreStatus()
    {
        $this->WithoutMiddleware();
        $faker = Faker\Factory::create();
        $request = [
            'name' => $faker->name,
            'quality' => 'Good',
        ];
        $response = $this->call('POST', route('admin.hotel.store'), $request);
        $this->assertEquals(302, $response->status());
    }

    /**
     * test status edit action.
     */
    public function testEditStatus()
    {
        $roomType = $this->createRoomType();
        $response = $this->call('GET', route('admin.room-type.edit', $roomType->id));
        $this->assertEquals(200, $response->status());
    }

    /**
     * test status update action.
     */
    public function testUpdateStatus()
    {
        $this->WithoutMiddleware();
        $faker = Faker\Factory::create();
        $request = [
            'name' => $faker->name,
            'quality' => 'bad',
        ];
        $roomType = $this->createRoomType();
        $response = $this->call('PUT', route('admin.hotel.update', $roomType->id), $request);
        $this->assertEquals(302, $response->status());
    }
}
