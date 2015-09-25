<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminAuthControllerTest extends TestCase
{
  /**
   * [setUp description]
   */
    // public function setUp()
    // {
  	// 	parent::setUp();
  	// 	Session::start();
  	// }

    /**
     * test function getLoginAdmin in AdminAuthController
     * @return void
     */
    public function testGetLoginAdmin()
    {
      $response = $this->call('GET',route('admin.login'));
      $this->assertEquals(200, $response->status());
    }

    /**
     * test function testPostLoginAdmin in AdminAuthController
     * @return void
     */
    public function testPostLoginAdmin()
    {
      Session::start();
      $useradmin = [
        'username'=>'admin',
        'password'=>'123123!',
        'remember'=>1,
        '_token'  => csrf_token()
      ];
      $response = $this->call('POST',route('admin.login'),$useradmin);
      $this->assertEquals(302,$response->status());
    }

    /**
     * test function testGetLogoutAdmin in AdminAuthController
     * @return void
     */
    public function testGetLogoutAdmin()
    {
      $response = $this->call('GET',route('admin.logout'));
      $this->assertEquals(302, $response->status());
    }
}
