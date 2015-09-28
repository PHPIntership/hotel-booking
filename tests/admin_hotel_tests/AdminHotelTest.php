<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use HotelBooking\AdminHotel;

class AdminHotelTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */


     /**
     * Test display page index listing admin hotel
     *
     * @return void
     */
    public function testIndex()
    {
        $this->visit(route('adminhotel.index'))
             ->see('Admin Hotel');
    }

    /**
    * Test status method GET display listing admin hotel
    *
    * @return void
    */
    public function testGetIndex()
    {
        $response = $this->call('GET', '/admin-hotel/index');

        $this->assertEquals(200, $response->status());
    }

    /**
    * Test status delete a admin hotel with id = 30 and id = 1
    * In database id=30 is exist and id=1 not exist
    * @return void
    */
    public function testDeleteAdminHotel()
    {
        $this->WithoutMiddleware();
        $response = $this->call('delete', route('adminhotel.destroy', 30));
        $this->assertEquals(302, $response->status());

        $response = $this->call('delete', route('adminhotel.destroy', 1));
        $this->assertEquals(404, $response->status());
    }
}
