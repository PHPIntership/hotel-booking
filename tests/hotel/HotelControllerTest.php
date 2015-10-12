<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use HotelBooking\AdminHotel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Test class for HotelController.
 */
class HotelControllerTests extends TestCase
{
    use DatabaseTransactions;

    /**
     * Overide setUp function. Truncate and seed the database before tests.
     */
    public function setUp()
    {
        parent::setUp();
        static $seed = false;
        if (!$seed) {
            DB::table('admin_hotels')->truncate();
            DB::table('hotels')->truncate();
            DB::table('cities')->truncate();
            $this->seed('AdminHotelTableSeeder');
            $this->seed('HotelTableSeeder');
            $seed = true;
        }
    }

    /**
     * Override actingAs function for setting the current authenticated hotel admin.
     */
    public function actingAs($hotelAdmin = null)
    {
        $hotelAdmin = AdminHotel::select('id', 'username', 'password')->first();
        $login = Auth::hotel()->attempt([
            'username' => $hotelAdmin->username,
            'password' => '123123',
        ]);
    }

    /**
     * Test the status when request edit page.
     */
    public function testEditStatus()
    {
        $this->actingAs();
        $this->call('GET', route('hotel.profile'));
        $this->assertResponseOk();
    }

    /**
     * Test the status of update request.
     */
    public function testUpdateStatus()
    {
        $this->WithoutMiddleware();
        $this->actingAs();
        $response = $this->call('POST', route('hotel.profile'));
        $this->assertEquals(302, $response->status());
    }

    /**
     * Test hotel admin cant edit hotel with null input fields.
     */
    public function testNullFields()
    {
        $this->actingAs();
        $this->visit(route('hotel.profile'))
            ->type('', '#website')
            ->type('', '#phone')
            ->type('', '#description')
            ->press(trans('messages.update'))
            ->see(trans('validation.required', [
                'attribute' => 'phone',
            ]))
            ->see(trans('validation.required', [
                'attribute' => 'description',
            ]));
    }

    /**
     * Test cant edit hotel with wrong website format.
     */
    public function testWrongWebsiteFormat()
    {
        $this->actingAs();
        $this->visit(route('hotel.profile'))
            ->type('notaurl', '#website')
            ->press(trans('messages.update'))
            ->see(trans('validation.url', [
                'attribute' => 'website',
            ]));
    }

    /**
     * Test cant edit hotel with phone is not a number.
     */
    public function testPhoneFieldNotANumber()
    {
        $this->actingAs();
        $this->visit(route('hotel.profile'))
            ->type('notanumber', '#phone')
            ->press(trans('messages.update'))
            ->see(trans('validation.regex', [
                'attribute' => 'phone',
            ]));
    }

    /**
     * Test cant edit hotel with phone field less than 10 characters.
     */
    public function testPhoneFieldLessThan10characters()
    {
        $this->actingAs();
        $this->visit(route('hotel.profile'))
            ->type('090911111', '#phone')
            ->press(trans('messages.update'))
            ->see(trans('validation.min.string', [
                'attribute' => 'phone',
                'min' => 10,
            ]));
    }

    /**
     * Test cant edit hotel with phone field more than 12 characters.
     */
    public function testPhoneFieldMoreThan12Characters()
    {
        $this->actingAs();
        $this->visit(route('hotel.profile'))
            ->type('0988876567788', '#phone')
            ->press(trans('messages.update'))
            ->see(trans('validation.max.string', [
                'attribute' => 'phone',
                'max' => 12,
            ]));
    }

    /**
     * Test cant edit hotel with description field less than 10 characters.
     */
    public function testDescriptionFieldLessThan10Characters()
    {
        $this->actingAs();
        $this->visit(route('hotel.profile'))
            ->type('short', '#description')
            ->press(trans('messages.update'))
            ->see(trans('validation.min.string', [
                'attribute' => 'description',
                'min' => 10,
            ]));
    }

    /**
     * Test cant edit hotel with description field more than 200 characters.
     */
    public function testDescriptionFieldMoreThan200Character()
    {
        $faker = Faker\Factory::create();
        $longDes = $faker->text(600);
        $this->actingAs();
        $this->visit(route('hotel.profile'))
            ->type($longDes, '#description')
            ->press(trans('messages.update'))
            ->see(trans('validation.max.string', [
                'attribute' => 'description',
                'max' => 200,
            ]));
    }

    /**
     * Test a hotel is update successfully
     */
    public function testAHotelIsUpdated()
    {
        $this->actingAs();
        $this->visit(route('hotel.profile'))
            ->type('website.com', '#website')
            ->type('0906777888', '#phone')
            ->type('Hotel description', '#description')
            ->press(trans('messages.update'))
            ->see(trans('messages.edit_success_hotel'));
    }
}
