<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use HotelBooking\AdminUser;

class AdminUserControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Overide setUp function. Truncate and seed the database before tests.
     */
    public function setUp()
    {
        parent::setUp();
        Session::start();
        static $seed = false;
        if (!$seed) {
            DB::table('admin_users')->truncate();
            $facAdminUser = factory(HotelBooking\AdminUser::class)->create();
            $adminUser = [
                'username'=>$facAdminUser->username,
                'password'=>'123456',
                'remember'=>1,
                '_token'  => csrf_token()
                ];
        }
        $this->actingAs();
    }

    /**
     * Override actingAs function for setting the current authenticated hotel admin.
     */
    public function actingAs($admin = null)
    {
        $admin = AdminUser::select('id', 'username', 'password')->first();
        $login = Auth::admin()->attempt([
            'username' => $admin->username,
            'password' => '123456',
        ]);
    }
    /**
     * test Status GetEditProfile in UserController
     * @return void
     */
    public function testGetEditProfileStatus()
    {
        $this->facAdminUser=factory(HotelBooking\AdminUser::class)->create();
        Auth::admin()->attempt([
            'username'=>$this->facAdminUser->username,
            'password'=>'123456'
            ], 1);
        $response = $this->call('GET', route('admin.profile.edit'));
        $this->assertEquals(200, $response->status());
    }

    /**
     * test Status PutEditProfile in UserController
     * @return void
     */
    public function testPutEditProfileStatus()
    {
        $this->facAdminUser=factory(HotelBooking\AdminUser::class)->create();
        Auth::admin()->attempt([
            'username'=>$this->facAdminUser->username,
            'password'=>'123456'
            ], 1);
        $new_profile = [
            'old_password'        =>'123456',
            'new_password'        =>'123123@',
            'confirm_new_password'=>'123123@',
            '_token'              => csrf_token()
          ];
        $response = $this->call('PUT', route('admin.profile.edit'), $new_profile);
        $this->assertRedirectedToRoute('admin.profile.edit');
        $this->assertEquals(302, $response->status());
    }
}
