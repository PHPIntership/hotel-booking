<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use HotelBooking\Services\Admin\HotelService;
use Faker\Factory;

class HotelServiceTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * Create Temporary request information by Faker Factory
     *
     * @return void
     */
    private function createFakerRequest()
    {
        $factory = Factory::create();
        $request = [
            'city_id' => 1,
            'name' => $factory->name,
            'quality' => 1,
            'address' => $factory->address,
            'phone' => $factory->phonenumber,
            'email' => $factory->email,
            'description' => $factory->name. $factory->address,
            'website' => '',
        ];
        return $request;
    }

    /**
     * Test store function
     *
     * @return void
     */
    public function testStore()
    {
        $request = self::createFakerRequest();
        $hotel = HotelService::store($request);
        $this->assertTrue($hotel->id > 0);
    }

    /**
     * Test update function
     *
     * @return void
     */
    public function testUpdate()
    {
        $request = self::createFakerRequest();
        $hotel = HotelService::store($request);
        $id = $hotel->id;
        $hotel = HotelService::update($request, $id);
        $this->assertTrue($hotel->id == $id);
    }
}
