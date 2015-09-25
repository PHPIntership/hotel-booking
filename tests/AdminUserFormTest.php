<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminUserFormTest extends TestCase
{
  use DatabaseTransactions;

  public function setUp()
  {
    parent::setUp();
    Auth::admin()->attempt(['username'=>'admin','password'=>'123123!'],1);
  }

/**
 * test dislay page edit profile
 * @return void
 */
  public function testFormEditProfile()
  {
    $this->visit(route('admin.edit.profile'))
          ->see('Edit Profile');
  }

  /**
   * test login from paga edit profile
   * @return void
   */
  public function testFormPutEditProfile()
  {
    $this->visit(route('admin.edit.profile'))
          ->type('123123!','old_password')
          ->type('123123@','new_password')
          ->type('123123@','confirm_new_password')
          ->press('Accept')
          ->dontsee('has-error');
  }
}
