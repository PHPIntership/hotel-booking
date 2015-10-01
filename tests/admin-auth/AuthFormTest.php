<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthFormTest extends TestCase
{
  /**
   * test display page login admin
   * @return void
   */
    public function testFormLogin()
    {
        $this->visit(route('admin.login'))
              ->see('Admin Login');
    }

  /**
   * test login admin
   * @return void
   */
    public function testFormPostLoginSuccess()
    {
        $this->visit(route('admin.login'))
            ->type('admin', 'username')
            ->type('123123!', 'password')
            ->check('remember')
            ->press('Sign In')
            ->see('Dashboard')
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
            ->type('123123!', 'password')
            ->check('remember')
            ->press('Sign In')
            ->see(trans('validation.required', ['attribute'=>'username']))
            ->dontsee('Dashboard');
    }

    /**
     * test post form login without password
     * @return void
     */
    public function testFormPostLoginWithoutPassword()
    {
        $this->visit(route('admin.login'))
            ->type('admin', 'username')
            ->type('', 'password')
            ->check('remember')
            ->press('Sign In')
            ->see(trans('validation.required', ['attribute'=>'password']))
            ->dontsee('Dashboard');
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
            ->press('Sign In')
            ->see(trans('validation.required', ['attribute'=>'password']))
            ->see(trans('validation.required', ['attribute'=>'username']))
            ->dontsee('Dashboard');
    }

  /**
   * test logout admin
   * @return void
   */
    public function testFormLogout()
    {
        $this->visit(route('admin.logout'))
            ->see('Admin Login');
    }
}
