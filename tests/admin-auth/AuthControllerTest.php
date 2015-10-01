<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $facAdminUser;


    /**
     * test Status getLogin in AuthController
     * @return void
     */
    public function testGetLoginStatus()
    {
        $resPonse = $this->call('GET', route('admin.login'));
        $this->assertEquals(200, $resPonse->status());
    }

    /**
     * test sataus post login
     * @return void
     */
    public function testPostLoginStatus()
    {
        Session::start();
        $facAdminUser = factory(HotelBooking\AdminUser::class)->create();
        $adminUser = [
              'username'=>$facAdminUser->username,
              'password'=>'123456',
              'remember'=>1,
              '_token'  => csrf_token()
          ];
        $resPonse = $this->call('POST', route('admin.login'), $adminUser);
        $this->assertEquals(302, $resPonse->status());
    }

    /**
     * test sataus post login without username
     * @return void
     */
    public function testPostLoginWithoutUsernameStatus()
    {
        Session::start();
        $adminUser = [
              'username'=>'',
              'password'=>'123456',
              'remember'=>1,
              '_token'  => csrf_token()
          ];
        $resPonse = $this->call('POST', route('admin.login'), $adminUser);
        $this->assertEquals(302, $resPonse->status());
    }

    /**
     * test sataus post login without password
     * @return void
     */
    public function testPostLoginWithoutPasswordStatus()
    {
        Session::start();
        $adminUser = [
              'username'=>'testpass',
              'password'=>'',
              'remember'=>1,
              '_token'  => csrf_token()
          ];
        $resPonse = $this->call('POST', route('admin.login'), $adminUser);
        $this->assertEquals(302, $resPonse->status());
    }

    /**
     * test sataus post login without username and password
     * @return void
     */
    public function testPostLoginWithoutUserameAndPasswordStatus()
    {
        Session::start();
        $adminUser = [
              'username'=>'',
              'password'=>'',
              'remember'=>1,
              '_token'  => csrf_token()
          ];
        $resPonse = $this->call('POST', route('admin.login'), $adminUser);
        $this->assertEquals(302, $resPonse->status());
    }
    /**
     * test status get logout
     * @return void
     */
    public function testGetLogoutStatus()
    {
        $response = $this->call('GET', route('admin.logout'));
        $this->assertEquals(302, $response->status());
    }
}
