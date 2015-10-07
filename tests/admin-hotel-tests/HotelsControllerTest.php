<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use HotelBooking\Hotel;
use HotelBooking\City;

class HotelsControllerTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * Test the status receive when access index page
     * @return void
     */
    public function testIndexStatus()
    {
        $this->call('GET', route('admin.hotels.index'));
        $this->assertResponseOk();
    }

    /**
     * Test if can get to correct index page
     */
    public function testViewIndex()
    {
        $this->visit(route('admin.hotels.index'))
            ->see(trans('messages.hotel_management'));
    }

    /**
     * Test the status receive when delete a hotel
     */
    public function testDeleteStatus()
    {
        $this->WithoutMiddleware();
        $this->seed('HotelSeedForTest');
        $hotel = Hotel::select('id')->first();
        $response = $this->call('delete', route('admin.hotels.destroy', $hotel->id));
        $this->assertEquals(302, $response->status());
    }

    /**
     * Test if a hotel is soft deleted in the database
     */
    public function testAHotelIsDeleted()
    {
        $this->WithoutMiddleware();
        $this->seed('HotelSeedForTest');
        $hotel = Hotel::select('id')->first();
        $response = $this->call('delete', route('admin.hotels.destroy', $hotel->id));
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
        $response = $this->call('delete', route('admin.hotels.destroy', 0));
        $this->assertEquals(302, $response->status());
    }
}
