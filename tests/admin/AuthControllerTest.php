<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthControllerTest extends TestCase
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
     * test function getLogin in AuthController
     * @return void
     */
    public function testGetLogin()
    {
      $response = $this->call('GET',route('admin.login'));
      $this->assertEquals(200, $response->status());
    }

    /**
     * test function testPostLogin in AuthController
     * @return void
     */
    public function testPostLogin()
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
     * test function testGetLogout in AuthController
     * @return void
     */
    public function testGetLogout()
    {
      $response = $this->call('GET',route('admin.logout'));
      $this->assertEquals(302, $response->status());
    }
}
