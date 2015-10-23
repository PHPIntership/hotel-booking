<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use HotelBooking\AdminHotel;
use HotelBooking\HotelRoomType;

/**
 * Test for hotel room type controller tests.
 */
class RoomTypeControllerTests extends TestCase
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
            DB::table('admin_hotels')->truncate();
            DB::table('room_types')->truncate();
            DB::table('hotel_room_types')->truncate();
            DB::table('hotels')->truncate();
            $this->seed('AdminHotelTableSeeder');
            $this->seed('HotelRoomTypeSeeder');
            $this->seed('HotelTableSeeder');
            $seed = true;
        }
    }
    /**
     * Override actingAs function for setting the current authenticated hotel room type.
     */
    public function actingAs($hotelAdmin = null)
    {
        $columns = [
                'id',
                'hotel_id',
                'username',
                'password',
        ];
        $hotelAdmin = AdminHotel::select($columns)->first();
        Auth::hotel()->login($hotelAdmin);
    }
    /**
     * Test if can get correct hotel room type create page status.
     */
    public function testCreateHotelRoomTypeStatus()
    {
        $this->actingAs();
        $response = $this->call('GET', route('hotel.room-type.create'));
        $this->assertEquals(200, $response->status());
    }
    /**
     * Test Create hotel room type success.
     */
    public function testCreateHoteRoomTypeOk()
    {
        $this->actingAs();
        $this->visit(route('hotel.room-type.create'))
            ->select(1, 'room_type_id')
            ->type('Justin Beiber', '#name')
            ->type('ahh aana ana ann', '#quality')
            ->type('3', '#quantity')
            ->type('12', '#price')
            ->type('afh afa aua cyaa qja aj', '#description')
            ->press('Create')
            ->seeIndatabase('hotel_room_types', ['name' => 'Justin Beiber'])
            ->see(trans('messages.create_success_hotel_room_type'));
    }
    /**
     * Test create hotel room type fail witout name.
     */
    public function testCreateHotelRoomTypeWithOutName()
    {
        $this->actingAs();
        $this->visit(route('hotel.room-type.create'))
            ->select(1, 'room_type_id')
            ->type('', '#name')
            ->type('ahh aana ana ann', '#quality')
            ->type('3', '#quantity')
            ->type('12', '#price')
            ->type('afh afa aua cyaa qja aj', '#description')
            ->press('Create')
            ->see(trans('validation.required', ['attribute' => trans('messages.name')]));
    }
    /**
     * Test create hotel room type fail with unique.
     */
    public function testCreateHotelRoomTypeWithUnique()
    {
        $this->actingAs();
        $this->visit(route('hotel.room-type.create'))
            ->select(1, 'room_type_id')
            ->type('aa', '#name')
            ->type('ahh aana ana ann', '#quality')
            ->type('3aa', '#quantity')
            ->type('12', '#price')
            ->type('afh afa aua cyaa qja aj', '#description')
            ->press('Create')
            ->see(trans('validation.min.string', [
                'attribute' => trans('messages.name'),
                'min' => 6,
            ]))
            ->see(trans('validation.integer', ['attribute' => trans('messages.quantity')]));
    }
    /**
     * Test create hotel room type fail with name more than 30 charaters.
     */
    public function testCreateHotelRoomTypeWithNameMore30Charater()
    {
        $this->actingAs();
        $this->visit(route('hotel.room-type.create'))
            ->select(1, 'room_type_id')
            ->type('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '#name')
            ->type('ahh aana ana ann', '#quality')
            ->type('3aa', '#quantity')
            ->type('12', '#price')
            ->type('afh afa aua cyaa qja aj', '#description')
            ->press('Create')
            ->see(trans('validation.max.string', [
            'attribute' => trans('messages.name'),
            'max' => 30,
            ]));
    }
    /**
     * Test create hotel room type fail with out description.
     */
    public function testCreateHotelRoomTypeWithOutDescription()
    {
        $this->actingAs();
        $this->visit(route('hotel.room-type.create'))
            ->select(1, 'room_type_id')
            ->type('Justin Beiber', '#name')
            ->type('ahh aana ana ann', '#quality')
            ->type('3aa', '#quantity')
            ->type('12', '#price')
            ->type('', '#description')
            ->press('Create')
            ->see(trans('validation.required', ['attribute' => trans('messages.description')]));
    }
    /**
     * Test edit hotel room type success.
     */
    public function testEditHotelRoomTypeOk()
    {
        $this->actingAs();
        $hotelRoomType = HotelRoomType::select('id')
            ->where('hotel_id', Auth::hotel()->get()->hotel_id)
            ->first();
        $this->visit(route('hotel.room-type.edit', $hotelRoomType->id))
        ->type('Justin Beiber', '#name')
        ->type('ahh aana ana ann', '#quality')
        ->type('3', '#quantity')
        ->type('12', '#price')
        ->type('ah ahaa aha aha aha aaha ah', '#description')
        ->press(trans('messages.update'))
        ->see(trans('messages.edit_success_hotel_room_type'))
        ->seeInDatabase('hotel_room_types', ['name' => 'Justin Beiber']);
    }

    /**
     * Test status method GET display listing hotel room type.
     */
    public function testIndexStatus()
    {
        $this->actingAs();
        $response = $this->call('GET', 'hotel/room-type');
        $this->assertEquals(200, $response->status());
    }
    /**
     * Test status delete a hotel room type with id = 0 not exits in database.
     */
    public function testDeleteAdminHotelStatusFail()
    {
        $this->actingAs();
        $this->WithoutMiddleware();
        $response = $this->call('delete', route('hotel.room-type.destroy', 0));
        $this->assertEquals(302, $response->status());
    }
    /**
     * Test status delete a hotel room type.
     */
    public function testDeleteAdminHotelStatusOk()
    {
        $this->actingAs();
        $hotelRoomType = HotelRoomType::where('hotel_id', Auth::hotel()->get()->hotel_id)
            ->select('id')->first();
        $this->WithoutMiddleware();
        $response = $this->call('delete', route('hotel.room-type.destroy', $hotelRoomType->id));
        $this->assertEquals(302, $response->status());
    }
}
