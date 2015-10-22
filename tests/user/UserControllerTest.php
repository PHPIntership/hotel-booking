<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use HotelBooking\User;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Create User.
     *
     * @return HotelBooking\User
     */
    public function createUser()
    {
        $faker = Faker\Factory::create();
        $roomType = User::create([
            'name' => $faker->name,
            'username' => $faker->username,
            'password' => $faker->password,
            'email' => $faker->email,
            'phone' => '0'.rand(100000000, 99999999999),
            'address' => $faker->address,
        ]);

        return $roomType;
    }

    /**
     * Test Index User status.
     *
     * @return void
     */
    public function testIndexUserStatus()
    {
        $response = $this->call('GET', route('admin.user.index'));
        $this->assertEquals(200, $response->status());
        $this->assertContains(trans('messages.user'), $response->content());
    }

    /**
     * Test Edit User status.
     *
     * @return void
     */
    public function testEditUserStatus()
    {
        $user = $this->createUser();
        $response = $this->call('GET', route('admin.user.edit', $user->id));
        $this->assertEquals(200, $response->status());
        $this->assertContains(trans('messages.edit_user'), $response->content());
    }

    /**
     * Test Put Update User status.
     *
     * @return void
     */
    public function testPutUpdateUserStatus()
    {
        $this->WithoutMiddleware();
        $faker = Faker\Factory::create();
        $user = $this->createUser();
        $request = [
            'name' => $faker->name,
            'phone' => '0'.rand(100000000, 99999999999),
        ];
        $response = $this->call('PUT', route('admin.user.update', $user->id), $request);
        $this->assertEquals(302, $response->status());
    }

    /**
     * Test Delete User Update status
     *
     * @return void
     */
    public function testDeleteUserStatus()
    {
        $this->WithoutMiddleware();
        $user = $this->createUser();
        $response = $this->call('DELETE', route('admin.user.destroy', $user->id));
        $this->assertEquals(302, $response->status());
    }
}
