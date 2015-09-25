<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminUserControllerTest extends TestCase
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
      Auth::admin()->attempt(['username'=>'admin','password'=>'123123!'],1);
    }

    /**
     * test function tetGetEditProfile in AdminUserController
     * @return void
     */
    public function tetGetEditProfile()
    {
      $response = $this->call('GET',route('admin.edit.profile'));
      $this->assertEquals(200,$response->status());
    }

    /**
     * test function testPutEditProfile in AdminUserController
     * @return void
     */
    public function testPutEditProfile()
    {
    //  $this->withoutMiddleware();
      $new_profile = [
        'old_password'        =>'123123!',
        'new_password'        =>'123123@',
        'confirm_new_password'=>'123123@',
        '_token'              => csrf_token()
      ];
      $response = $this->call('PUT',route('admin.edit.profile'),$new_profile);
      $this->assertEquals(302,$response->status());
    }

}
