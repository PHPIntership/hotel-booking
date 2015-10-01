<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use HotelBooking\Services\Admin\HotelService;
use HotelBooking\Hotel;

class AdminHotelsTest extends TestCase
{

    use DatabaseMigrations;
    use DatabaseTransactions;

    /**
     *
     *
     * @return void
     */
    public function testCreateGET()
    {
        $response = $this->call('GET', route('admin.hotels.create'));
        $this->assertEquals(200, $response->status());
    }

    /**
     *
     *
     * @return void
     */
    public function testEditGet()
    {
        $response = $this->call('GET', route('admin.hotels.edit'));
        $this->assertEquals(404, $response->status());
    }

    /**
     *
     *
     * @return void
     */
    public function testStorePOST()
    {
        $this->WithoutMiddleware();
        $response = $this->call('POST', route('admin.hotels.store'));
        $this->assertEquals(302, $response->status());
    }

    /**
     *
     *
     * @return void
     */
    public function testUpdatePUT()
    {
        $this->WithoutMiddleware();
        $response = $this->call('PUT', route('admin.hotels.update'));
        $this->assertEquals(302, $response->status());
    }
}
