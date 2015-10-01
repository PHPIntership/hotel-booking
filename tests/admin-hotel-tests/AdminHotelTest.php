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
    public function testViewIndex()
    {
        $this->visit(route('admin-hotel.index'))
             ->see('Admin Hotel');
    }

    /**
    * Test delete is success
    *
    * @return void
    */
    public function testDeleted()
    {
        $this->visit(route('admin-hotel.index'))
            ->press('Delete')
            ->see('Deleted successfully!!!');
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
    * Test status delete a admin hotel with id = 30 and id = 1
    * In database id=30 is exist and id=1 not exist
    * @return void
    */
    public function testDeleteAdminHotelStatus()
    {
        $this->WithoutMiddleware();
        $response = $this->call('delete', route('admin-hotel.destroy', 46));
        $this->assertEquals(302, $response->status());

        $response = $this->call('delete', route('admin-hotel.destroy', 1));
        $this->assertEquals(404, $response->status());
    }

    /**
    * Test database have user
    *
    * @return void
    */
    public function testDatabase()
    {
        $this->seeInDatabase('admin_hotels', ['name'=>'Ba Muoi']);
        $this->seeInDatabase('admin_hotels', ['phone'=>'1234565']);
    }
}
