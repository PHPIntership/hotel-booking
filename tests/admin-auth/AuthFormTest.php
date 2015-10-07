<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthFormTest extends TestCase
{
    use DatabaseTransactions;

  /**
   * test display page login admin
   * @return void
   */
    public function testFormLogin()
    {
        $this->visit(route('admin.login'))
            ->see(trans('messages.admin_login'));
    }

  /**
   * test login admin
   * @return void
   */
    public function testFormPostLoginSuccess()
    {
        $facAdminUser = factory(HotelBooking\AdminUser::class)->create();
        $this->visit(route('admin.login'))
            ->type($facAdminUser->username, 'username')
            ->type('123456', 'password')
            ->check('remember')
            ->press(trans('messages.sign_in'))
            ->dontsee('has-error');
    }

    /**
     * test post form login without username
     * @return void
     */
    public function testFormPostLoginWithoutUsername()
    {
        $this->visit(route('admin.login'))
            ->type('', 'username')
            ->type('123123', 'password')
            ->check('remember')
            ->press(trans('messages.sign_in'))
            ->see(trans('validation.required', ['attribute'=>'username']));
    }

    /**
     * test post form login without password
     * @return void
     */
    public function testFormPostLoginWithoutPassword()
    {
        $this->visit(route('admin.login'))
            ->type('usertest', 'username')
            ->type('', 'password')
            ->check('remember')
            ->press(trans('messages.sign_in'))
            ->see(trans('validation.required', ['attribute'=>'password']));
    }
    /**
     * test post form login without username and password
     * @return void
     */
    public function testFormPostLoginWithoutUsernameAndPassword()
    {
        $this->visit(route('admin.login'))
            ->type('', 'username')
            ->type('', 'password')
            ->check('remember')
            ->press(trans('messages.sign_in'))
            ->see(trans('validation.required', ['attribute'=>'password']))
            ->see(trans('validation.required', ['attribute'=>'username']));
    }

    /**
     * test post form login password less than six character
     * @return void
     */
    public function testFormPostLoginPassWordLessThanSixCharacter()
    {
        $this->visit(route('admin.login'))
            ->type('usertest', 'username')
            ->type('123', 'password')
            ->check('remember')
            ->press(trans('messages.sign_in'))
            ->see(trans('validation.min.string', [
                'attribute'=>'password',
                'min'=>'6'
                ]));
    }

  /**
   * test logout admin
   * @return void
   */
    public function testFormLogout()
    {
        $this->visit(route('admin.logout'))
            ->see(trans('messages.admin_login'));
    }
}
