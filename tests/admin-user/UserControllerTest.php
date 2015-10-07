<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * setup Session and Auth
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        Session::start();
    }

    /**
     * test Status GetEditProfile in UserController
     * @return void
     */
    public function testGetEditProfileStatus()
    {
        $this->facAdminUser=factory(HotelBooking\AdminUser::class)->create();
        Auth::admin()->attempt([
            'username'=>$this->facAdminUser->username,
            'password'=>'123456'
            ], 1);
        $response = $this->call('GET', route('admin.profile.edit'));
        $this->assertEquals(200, $response->status());
    }

    /**
     * test Status PutEditProfile in UserController
     * @return void
     */
    public function testPutEditProfileStatus()
    {
        $this->facAdminUser=factory(HotelBooking\AdminUser::class)->create();
        Auth::admin()->attempt([
            'username'=>$this->facAdminUser->username,
            'password'=>'123456'
            ], 1);
        $new_profile = [
            'old_password'        =>'123456',
            'new_password'        =>'123123@',
            'confirm_new_password'=>'123123@',
            '_token'              => csrf_token()
          ];
        $response = $this->call('PUT', route('admin.profile.edit'), $new_profile);
        $this->assertRedirectedToRoute('admin.profile.edit');
        $this->assertEquals(302, $response->status());
    }
}
