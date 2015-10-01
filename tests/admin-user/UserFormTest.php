<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserFormTest extends TestCase
{
    use DatabaseTransactions;


  /**
   * test dislay page edit profile
   * @return void
   */
    public function testFormEditProfile()
    {
        $facAdminUser=factory(HotelBooking\AdminUser::class)->create();
        Auth::admin()->attempt(['username'=>$facAdminUser->username, 'password'=>'123456'], 1);
        $this->visit(route('admin.edit.profile'))
              ->see('Edit Profile');
    }

  /**
   * test login from page edit profile
   * @return void
   */
    public function testFormPutEditProfile()
    {
        $facAdminUser=factory(HotelBooking\AdminUser::class)->create();
        Auth::admin()->attempt(['username'=>$facAdminUser->username, 'password'=>'123456'], 1);
        $this->visit(route('admin.edit.profile'))
            ->type('123456', 'old_password')
            ->type('123123@', 'new_password')
            ->type('123123@', 'confirm_new_password')
            ->press('Accept')
            ->dontsee('has-error');
    }
}
