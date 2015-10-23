<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use HotelBooking\RoomType;
use HotelBooking\AdminUser;

class RoomTypeControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Overide setUp function. Truncate and seed the database before tests.
     */
    public function setUp()
    {
        parent::setUp();
        static $seed = false;
        if (!$seed) {
            DB::table('admin_users')->truncate();
            $facAdminUser = factory(HotelBooking\AdminUser::class)->create();
            $adminUser = [
                'username'=>$facAdminUser->username,
                'password'=>'123456',
                'remember'=>1,
                '_token'  => csrf_token()
                ];
        }
        $this->actingAs();
    }

    /**
     * Override actingAs function for setting the current authenticated hotel admin.
     */
    public function actingAs($admin = null)
    {
        $admin = AdminUser::select('id', 'username', 'password')->first();
        $login = Auth::admin()->attempt([
            'username' => $admin->username,
            'password' => '123456',
        ]);
    }

    /**
     * Create room type.
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
     * Test status create action.
     */
    public function testCreateStatus()
    {
        $response = $this->call('GET', route('admin.room-type.create'));
        $this->assertEquals(200, $response->status());
    }

    /**
     * Test status store action.
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
     * Test status edit action.
     */
    public function testEditStatus()
    {
        $roomType = $this->createRoomType();
        $response = $this->call('GET', route('admin.room-type.edit', $roomType->id));
        $this->assertEquals(200, $response->status());
    }

    /**
     * Test status update action.
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

    /**
     * Test status Display a listing action.
     */
    public function testIndexStatus()
    {
        $response = $this->call('GET', route('admin.room-type.index'));
        $this->assertEquals(200, $response->status());
    }

    /**
     * Test status delete room type action.
     */
    public function testDeleteStatus()
    {
        $this->WithoutMiddleware();
        $roomType = $this->createRoomType();
        $response = $this->call('DELETE', route('admin.room-type.destroy', $roomType->id));
        $this->assertEquals(302, $response->status());
    }
}
