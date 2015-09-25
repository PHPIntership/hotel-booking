<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminAuthFormTest extends TestCase
{
  /**
   * test display page login admin
   * @return void
   */
  public function testFormLoginAdmin()
  {
      $this->visit(route('admin.login'))
            ->see('Admin Login');
  }

  /**
   * test login admin
   * @return void
   */
  public function testFormPostLoginAdmin()
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
   * test logout admin
   * @return void
   */
  public function testFormAdminLogout()
  {
    $this->visit(route('admin.logout'))
          ->see('Admin Login');
  }
}
