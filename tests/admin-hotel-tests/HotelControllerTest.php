<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use HotelBooking\Hotel;
use HotelBooking\City;

/**
 * Test class for HotelsController
 */
class HotelControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test create action, GET method
     *
     * @return void
     */
    public function testCreateStatus()
    {
        $response = $this->call('GET', route('admin.hotel.create'));
        $this->assertEquals(200, $response->status());
    }

    /**
     * Test edit action, GET method
     *
     * @return void
     */
    public function testEditStatus()
    {
        $faker = Faker\Factory::create();
        $request = [
            'name' => $faker->name,
            'city_id' => 1,
            'quality' => 1,
            'address' => $faker->address,
            'phone' => $faker->phonenumber,
            'email' => $faker->email,
            'description' => $faker->text,
        ];
        $hotel = Hotel::create($request);
        $response = $this->call('GET', route('admin.hotel.edit', $hotel->id));
        $this->assertEquals(200, $response->status());
    }

    /**
     * Test store action, POST method
     *
     * @return void
     */
    public function testStoreStatus()
    {
        $this->WithoutMiddleware();
        $response = $this->call('POST', route('admin.hotel.store'));
        $this->assertEquals(302, $response->status());
    }

    /**
     * Test update action, PUT method
     *
     * @return void
     */
    public function testUpdateStatus()
    {
        $this->WithoutMiddleware();
        $response = $this->call('PUT', route('admin.hotel.update'));
        $this->assertEquals(302, $response->status());
    }
    
    /**
     * Test the status receive when access index page
     * @return void
     */
    public function testIndexStatus()
    {
        $this->call('GET', route('admin.hotel.index'));
        $this->assertResponseOk();
    }

    /**
     * Test if can get to correct index page
     */
    public function testViewIndex()
    {
        $this->visit(route('admin.hotel.index'))
            ->see(trans('messages.hotel_management'));
    }

    /**
     * Test the status receive when delete a hotel
     */
    public function testDeleteStatus()
    {
        $this->WithoutMiddleware();
        $this->seed('HotelTableSeeder');
        $hotel = Hotel::select('id')->first();
        $response = $this->call('delete', route('admin.hotel.destroy', $hotel->id));
        $this->assertEquals(302, $response->status());
    }

    /**
     * Test if a hotel is soft deleted in the database
     */
    public function testAHotelIsDeleted()
    {
        $this->WithoutMiddleware();
        $this->seed('HotelTableSeeder');
        $hotel = Hotel::select('id')->first();
        $response = $this->call('delete', route('admin.hotel.destroy', $hotel->id));
        $this->notSeeInDatabase('hotels', [
            'id'=>$hotel->id,
            'deleted_at'=>'NULL'
        ]);
    }

    /**
     * Test that admin cant delete a hotel with non-exist id
     */
    public function testDeleteHotelFail()
    {
        $this->WithoutMiddleware();
        $response = $this->call('delete', route('admin.hotel.destroy', 0));
        $this->assertEquals(302, $response->status());
    }
}
