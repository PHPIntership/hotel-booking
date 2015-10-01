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
        Auth::admin()->attempt([
            'username'=>$facAdminUser->username,
            'password'=>'123456'
            ], 1);
        $this->visit(route('admin.profile.edit'))
              ->see(trans('messages.edit_profile'));
    }

  /**
   * test login from page edit profile
   * @return void
   */
    public function testFormPutEditProfile()
    {
        $facAdminUser=factory(HotelBooking\AdminUser::class)->create();
        Auth::admin()->attempt([
            'username'=>$facAdminUser->username,
            'password'=>'123456'
            ], 1);
        $this->visit(route('admin.profile.edit'))
            ->type('123456', 'old_password')
            ->type('123123@', 'new_password')
            ->type('123123@', 'confirm_new_password')
            ->press(trans('messages.update'))
            ->see(trans('messages.edit_profile'))
            ->dontsee('has-error');
    }

    /**
     * test form put profile without old password
     * @return void
     */
    public function testFormPutEditProfileWithoutOldPassword()
    {
        $facAdminUser=factory(HotelBooking\AdminUser::class)->create();
        Auth::admin()->attempt([
            'username'=>$facAdminUser->username,
            'password'=>'123456'
            ], 1);
        $this->visit(route('admin.profile.edit'))
            ->type('', 'old_password')
            ->type('123123@', 'new_password')
            ->type('123123@', 'confirm_new_password')
            ->press(trans('messages.update'))
            ->see(trans('validation.required', ['attribute'=>'old password']));
    }

    /**
     * test form put profile without old new password
     * @return void
     */
    public function testFormPutEditProfileWithoutNewPassword()
    {
        $facAdminUser=factory(HotelBooking\AdminUser::class)->create();
        Auth::admin()->attempt([
            'username'=>$facAdminUser->username,
            'password'=>'123456'
            ], 1);
        $this->visit(route('admin.profile.edit'))
            ->type('123456', 'old_password')
            ->type('', 'new_password')
            ->type('123123@', 'confirm_new_password')
            ->press(trans('messages.update'))
            ->see(trans('validation.required', ['attribute'=>'new password']));
    }

    /**
     * test form put profile without confirm new password
     * @return void
     */
    public function testFormPutEditProfileWithoutConfirmNewPassword()
    {
        $facAdminUser=factory(HotelBooking\AdminUser::class)->create();
        Auth::admin()->attempt([
            'username'=>$facAdminUser->username,
            'password'=>'123456'
            ], 1);
        $this->visit(route('admin.profile.edit'))
            ->type('123456', 'old_password')
            ->type('123123@', 'new_password')
            ->type('', 'confirm_new_password')
            ->press(trans('messages.update'))
            ->see(trans('validation.required', ['attribute'=>'confirm new password']));
    }

    /**
     * test form put profile password invalid
     * @return void
     */
    public function atestFormPutEditProfileOldPasswordInvalid()
    {
        $facAdminUser=factory(HotelBooking\AdminUser::class)->create();
        Auth::admin()->attempt([
            'username'=>$facAdminUser->username,
            'password'=>'123456'
            ], 1);
        $this->visit(route('admin.profile.edit'))
            ->type('123456', 'old_password')
            ->type('123123@', 'new_password')
            ->type('123123@', 'confirm_new_password')
            ->press(trans('messages.update'))
            ->see(trans('validation.invalid', ['name'=>'old password']));
    }

    /**
     * test form put profile old pass and confirm pass is not same
     * @return void
     */
    public function atestFormPutEditProfileNewPasswordAndConfimNewPasswordNotSame()
    {
        $facAdminUser=factory(HotelBooking\AdminUser::class)->create();
        Auth::admin()->attempt([
            'username'=>$facAdminUser->username,
            'password'=>'123456'
            ], 1);
        $this->visit(route('admin.profile.edit'))
            ->type('123456', 'old_password')
            ->type('123123@', 'new_password')
            ->type('123123!!!!', 'confirm_new_password')
            ->press(trans('messages.update'))
            ->see(trans('validation.same', [
                'attribute' =>'old password',
                'other'     =>'confirm new password'
                ]));
    }
}
