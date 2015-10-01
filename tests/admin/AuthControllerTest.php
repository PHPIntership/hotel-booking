<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthControllerTest extends TestCase
{
    /**
     * test Status getLogin in AuthController
     * @return void
     */
    public function testGetLoginStatus()
    {
        $response = $this->call('GET', route('admin.login'));
        $this->assertEquals(200, $response->status());
    }

    /**
     * test Status postLogin in AuthController
     * @return void
     */
    public function testPostLoginStatus()
    {
        Session::start();
        $useradmin = [
              'username'=>'admin',
              'password'=>'123123!',
              'remember'=>1,
              '_token'  => csrf_token()
          ];
        $response = $this->call('POST', route('admin.login'), $useradmin);
        $this->assertEquals(302, $response->status());
    }

    /**
     * test Status getLogout in AuthController
     * @return void
     */
    public function testGetLogoutStatus()
    {
        $response = $this->call('GET', route('admin.logout'));
        $this->assertEquals(302, $response->status());
    }
}
