<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HotelsControllerTest extends TestCase
{

    /**
     * Test create action, GET method
     *
     * @return void
     */
    public function testCreate()
    {
        $response = $this->call('GET', route('admin.hotels.create'));
        $this->assertEquals(200, $response->status());
    }

    /**
     * Test edit action, GET method
     *
     * @return void
     */
    public function testEdit()
    {
        $response = $this->call('GET', route('admin.hotels.edit'));
        $this->assertEquals(404, $response->status());
    }

    /**
     * Test store action, POST method
     *
     * @return void
     */
    public function testStore()
    {
        $this->WithoutMiddleware();
        $response = $this->call('POST', route('admin.hotels.store'));
        $this->assertEquals(302, $response->status());
    }

    /**
     * Test update action, PUT method
     *
     * @return void
     */
    public function testUpdate()
    {
        $this->WithoutMiddleware();
        $response = $this->call('PUT', route('admin.hotels.update'));
        $this->assertEquals(302, $response->status());
    }
}
