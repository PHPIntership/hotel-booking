<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use HotelBooking\Services\Admin\HotelService;

class AdminHotelsTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */

    //use DatabaseTransactions;
    public function testCreateGET()
    {
        $response = $this->call('GET', route('admin.hotels.create'));
        $this->assertEquals(200, $response->status());
    }

    public function testEditGet()
    {
        $response = $this->call('GET', route('admin.hotels.edit', 1));
        $this->assertEquals(200, $response->status());

        $response = $this->call('GET', route('admin.hotels.edit', 0));
        $this->assertEquals(404, $response->status());
    }

    public function testStorePOST()
    {
        $this->WithoutMiddleware();
        $response = $this->call('POST', route('admin.hotels.store'));
        $this->assertEquals(302, $response->status());
    }

    public function testUpdatePUT()
    {
        $this->WithoutMiddleware();
        $response = $this->call('PUT', route('admin.hotels.update'));
        $this->assertEquals(302, $response->status());
    }
}
