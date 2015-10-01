<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use HotelBooking\AdminHotel;

class AdminHotelTest extends TestCase
{
    use DatabaseTransactions;
     /**
     * Test display page index listing admin hotel
     *
     * @return void
     */
    public function testViewIndex()
    {
        $this->visit(route('admin-hotel.index'))
             ->see('Admin Hotel');
    }

    /**
    * Test status method GET display listing admin hotel
    *
    * @return void
    */
    public function testIndexStatus()
    {
        $response = $this->call('GET', '/admin-hotel');

        $this->assertEquals(200, $response->status());
    }

    /**
    * Test status delete a admin hotel
    * @return void
    */
    public function testDeleteAdminHotelStatusOk()
    {
        $faker = Faker\Factory::create();
        AdminHotel::create([
            'hotel_id' => rand(1, 9),
            'username' => $faker->firstName,
            'password' => bcrypt(str_random(10)),
            'name' => $faker->name,
            'email' => $faker->email,
            'phone' => $faker->phoneNumber
            ]);
        $adminHotel = AdminHotel::select('id')->first();
        $this->WithoutMiddleware();
        $response = $this->call('delete', route('admin-hotel.destroy', $adminHotel->id));
        $this->assertEquals(302, $response->status());
    }

    /**
    * Test status delete a admin hotel with id = 0 not exits in database
    * @return void
    */
    public function testDeleteAdminHotelStatusFail()
    {
        $this->WithoutMiddleware();
        $response = $this->call('delete', route('admin-hotel.destroy', 0));
        $this->assertEquals(404, $response->status());
    }
}
