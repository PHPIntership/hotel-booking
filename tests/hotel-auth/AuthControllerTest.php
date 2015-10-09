<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use HotelBooking\AdminHotel;

/**
 * Tests for AuthController of hotel admin.
 */
class AuthControllerTest extends TestCase
{
    /*
     * Use DatabaseTransactions for tests
     */
    use DatabaseTransactions;

    /**
     * Test the status when request login form.
     */
    public function testGetLoginStatus()
    {
        $this->call('GET', route('hotel.login'));
        $this->assertResponseOk();
    }

    /**
     * Test if can get correct message when log in fail.
     */
    public function testErrorMessage()
    {
        $this->visit(route('hotel.login'))
            ->type('wrongusername', '#username')
            ->type('wrondpassword', '#password')
            ->press(trans('messages.sign_in'))
            ->see(trans('messages.login_fail'));
    }

    /**
     * Test if cant log in with null username.
     */
    public function testUsernameNull()
    {
        $this->visit(route('hotel.login'))
            ->type('', '#username')
            ->type('password', '#password')
            ->press(trans('messages.sign_in'))
            ->see(trans('validation.required', [
                'attribute' => 'username',
            ]));
    }

    /**
     * Test if cant log in with username is less than 6 characters.
     */
    public function testUsernameLessThan6Characters()
    {
        $this->visit(route('hotel.login'))
            ->type('min', '#username')
            ->type('password', '#password')
            ->press(trans('messages.sign_in'))
            ->see(trans('validation.min.string', [
                'attribute' => 'username',
                'min' => 6,
            ]));
    }

    /**
     * Test if cant login with username is more than 20 characters.
     */
    public function testUsernameMoreThan20Characters()
    {
        $this->visit(route('hotel.login'))
            ->type('longusernameeeeeeeeeeeeeee', '#username')
            ->type('password', '#password')
            ->press(trans('messages.sign_in'))
            ->see(trans('validation.max.string', [
                'attribute' => 'username',
                'max' => 20,
            ]));
    }

    /**
     * Test if cant login with null password.
     */
    public function testPasswordNull()
    {
        $this->visit(route('hotel.login'))
            ->type('username', '#username')
            ->type('', '#password')
            ->press(trans('messages.sign_in'))
            ->see(trans('validation.required', [
                'attribute' => 'password',
            ]));
    }

    /**
     * Test if cant login with password less than 6 characters.
     */
    public function testPasswordLessThan6Characters()
    {
        $this->visit(route('hotel.login'))
            ->type('username', '#username')
            ->type('min', '#password')
            ->press(trans('messages.sign_in'))
            ->see(trans('validation.min.string', [
                'attribute' => 'password',
                'min' => 6,
            ]));
    }

    /**
     * Test if cant login with password more than 20 characters.
     */
    public function testPasswordMoreThan20Characters()
    {
        $this->visit(route('hotel.login'))
            ->type('username', '#username')
            ->type('longpassworddddddddddddddddddd', '#password')
            ->press(trans('messages.sign_in'))
            ->see(trans('validation.max.string', [
                'attribute' => 'password',
                'max' => 20,
            ]));
    }

    /**
     * Test if can log in with correct username and password.
     */
    public function testPassLogin()
    {
        $this->seed('AdminHotelTableSeeder');
        $adminHotel = AdminHotel::select('username')->first();
        $this->visit(route('hotel.login'))
            ->type($adminHotel->username, '#username')
            ->type('123123', '#password')
            ->press(trans('messages.sign_in'))
            ->dontSee(trans('messages.login_fail'));
    }
}
