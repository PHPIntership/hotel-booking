<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use HotelBooking\User;

/**
 * Test for edit profile user.
 */
class UserProfileTest extends TestCase
{
    use DatabaseTransactions;

     /**
      *Overide setUp function. Truncate and seed the database before tests.
      */
    public function setUp()
    {
        parent::setUp();
        static $seed = false;
        if (!$seed) {
            DB::table('users')->truncate();
            $this->seed('UserTableSeeder');
            $seed = true;
        }
    }
    
    /**
     * Override actingAs function for setting the current authenticated user.
     */
    public function actingAs($user = null)
    {
        $columns = [
            'id',
            'username',
            'password',
        ];
        $user = User::select($columns)->first();
        Auth::user()->login($user);
    }
    /**
     * Test display page index listing user profile.
     */
    public function testViewIndex()
    {
        $this->actingAs();
        $this->visit(route('user.profile'))
            ->see(trans('messages.profile_infomation'));
    }
    /**
     * Test status method GET display listing user profile.
     */
    public function testIndexStatus()
    {
        $this->actingAs();
        $response = $this->call('GET', 'profile');
        $this->assertEquals(200, $response->status());
    }
    /**
     * Test edit profile successfully.
     */
    public function testEditUserProfileOk()
    {
        $this->actingAs();
        $this->visit(route('user.profile'))
            ->type('Justin Beiber', '#name')
            ->type('195 Nguyen Luong Bang street', '#address')
            ->type('01234567891', '#phone')
            ->press(trans('messages.update'))
            ->see(trans('messages.update_success_profile'));
    }
    /**
     * Test edit user profile with name that than 30 charaters
     */
    public function testEditProfileNameMore30Charater()
    {
        $this->actingAs();
        $this->visit(route('user.profile'))
            ->type('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '#name')
            ->type('195 Nguyen Luong Bang street', '#address')
            ->type('01234567891', '#phone')
            ->press(trans('messages.update'))
            ->see(trans('validation.max.string', [
            'attribute' => trans('messages.name'),
            'max' => 30,
            ]));
    }
    /**
     * Test edit user profile with name unique
     */
    public function testEditUserProfileWithNameUnique()
    {
        $this->actingAs();
        $this->visit(route('user.profile'))
            ->type('J', '#name')
            ->type('195 Nguyen Luong Bang street', '#address')
            ->type('01234567891', '#phone')
            ->press(trans('messages.update'))
            ->see(trans('validation.min.string', [
                'attribute' => trans('messages.name'),
                'min' => 6,
            ]));
    }
    /**
     * Test edit user profile phone unique.
     */
    public function testEditUserProfileWithPhoneUnique()
    {
        $this->actingAs();
        $this->visit(route('user.profile'))
            ->type('Justin Beiber', '#name')
            ->type('195 Nguyen Luong Bang street', '#address')
            ->type('012345678x', '#phone')
            ->press(trans('messages.update'))
            ->see(trans('validation.regex', ['attribute' => trans('messages.phone')]));
    }
}
