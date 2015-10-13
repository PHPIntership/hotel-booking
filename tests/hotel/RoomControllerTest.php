<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use HotelBooking\AdminHotel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use HotelBooking\Room;
use HotelBooking\HotelRoomType;

/**
 * Test class for RoomController
 */
class RoomControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Override setUp function. Truncate and seed the database before tests.
     */
    public function setUp()
    {
        parent::setUp();
        static $seed = false;
        if (!$seed) {
            DB::table('admin_hotels')->truncate();
            $this->seed('AdminHotelTableSeeder');
            $seed = true;
        }
    }

    /**
     * Override actingAs function for setting the current authenticated hotel admin.
     */
    public function actingAs($hotelAdmin = null)
    {
        $hotelAdmin = AdminHotel::select('id', 'hotel_id', 'username', 'password')->first();
        Auth::hotel()->login($hotelAdmin);
    }

    /**
     *Create a temporary room with Faker\Factory
     *
     *@return HotelBooking\Room.
     */
    private function createFakerRoom()
    {
        $this->actingAs();
        $faker = Faker\Factory::create();
        $request = [
            'name' => $faker->name,
            'room_type_id' => 1,
            'hotel_id' => Auth::hotel()->get()->hotel_id,
            'quality' => 'good',
            'quantity' => 0,
            'price' => 0,
            'description' => ''
        ];
        $hotelRoomType = hotelRoomType::create($request);
        $faker = Faker\Factory::create();
        $request = [
            'name' => $faker->name,
            'hotel_room_type_id' => $hotelRoomType->id,
            'status' => 0,
        ];
        return Room::create($request);
    }

    /**
     * Test create action, GET method
     *
     * @return void
     */
    public function testCreateStatus()
    {
        $this->actingAs();
        $response = $this->call('GET', route('hotel.room.create'));
        $this->assertEquals(200, $response->status());
    }

    /**
     * Test edit action, GET method
     *
     * @return void
     */
    public function testEditStatus()
    {
        $room = $this->createFakerRoom();
        $response = $this->call('GET', route('hotel.room.edit', $room->id));
        $this->assertEquals(200, $response->status());
    }

    /**
     * Test store action, POST method
     *
     * @return void
     */
    public function testStoreStatus()
    {
        $this->WithoutMiddleware();
        $response = $this->call('POST', route('hotel.room.store'));
        $this->assertEquals(302, $response->status());
    }

    /**
     * Test update action, PUT method
     *
     * @return void
     */
    public function testUpdateStatus()
    {
        $this->WithoutMiddleware();
        $response = $this->call('PUT', route('admin.hotel.update'));
        $this->assertEquals(302, $response->status());
    }

    /**
     *Test if a room is created when issert valid data.
     */
    public function testNewRoomlIsCreated()
    {
        $this->actingAs();
        $faker = Faker\Factory::create();
        $request = [
            'name' => $faker->name,
            'room_type_id' => 1,
            'hotel_id' => Auth::hotel()->get()->hotel_id,
            'quality' => 'good',
            'quantity' => 0,
            'price' => 0,
            'description' => ''
        ];
        hotelRoomType::create($request);
        $this->visit(route('hotel.room.create'))
            ->type('A105', '#name')
            ->press(trans('messages.create_submit'))
            ->seeIndatabase('rooms', ['name' => 'A105'])
            ->see(trans('messages.create_success_room'));
    }

    /**
     * Test if a room cant be created when issert null name.
     */
    public function testCreateRoomWithoutName()
    {
        $this->actingAs();
        $this->visit(route('hotel.room.create'))
            ->type('', '#name')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.required', ['attribute' => 'name']));
    }

    /**
     * Test if a room cant be created when issert name less
     * than 3 characters.
     */
    public function testCreateRoomWithNameLessThan3Characters()
    {
        $this->actingAs();
        $this->visit(route('hotel.room.create'))
            ->type('A5', '#name')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.min.string', [
                'attribute' => 'name',
                'min' => 3
                ]));
    }

    /**
     * Test if a room cant be created when issert name more
     * than 15 characters.
     */
    public function testCreateRoomWithNameMoreThan15Characters()
    {
        $this->actingAs();
        $this->visit(route('hotel.room.create'))
            ->type('A105105105105105', '#name')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.max.string', [
                'attribute' => 'name',
                'max' => 15
                ]));
    }

    /**
     * Test if a room cant be created when issert name with wrong regex.
     */
    public function testCreateRoomWithWrongRegexName()
    {
        $this->actingAs();
        $this->visit(route('hotel.room.create'))
            ->type('a105', '#name')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.regex', ['attribute' => 'name']));
    }

    /**
     *Test if a room is edited when issert valid data.
     */
    public function testNewRoomIsEdited()
    {
        $room = $this->createFakerRoom();
        $this->visit(route('hotel.room.edit', $room->id))
            ->type('A105', '#name')
            ->press(trans('messages.edit_submit'))
            ->seeIndatabase('rooms', ['name' => 'A105'])
            ->see(trans('messages.edit_success_room'));
    }

    /**
     *Test if a room is edited when issert nochange.
     */
    public function testNewRoomIsEditedWithoutChange()
    {
        $this->actingAs();
        $faker = Faker\Factory::create();
        $request = [
            'name' => $faker->name,
            'room_type_id' => 1,
            'hotel_id' => Auth::hotel()->get()->hotel_id,
            'quality' => 'good',
            'quantity' => 0,
            'price' => 0,
            'description' => ''
        ];
        $hotelRoomType = hotelRoomType::create($request);
        $faker = Faker\Factory::create();
        $request = [
            'name' => 'A105',
            'hotel_room_type_id' => $hotelRoomType->id,
            'status' => 0,
        ];
        $room = Room::create($request);
        $this->visit(route('hotel.room.edit', $room->id))
            ->press(trans('messages.edit_submit'))
            ->see(trans('messages.edit_success_room'));
    }

    /**
     * Test if a room cant be edited when issert null name.
     */
    public function testEditRoomWithoutName()
    {
        $room = $this->createFakerRoom();
        $this->visit(route('hotel.room.edit', $room->id))
            ->type('', '#name')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.required', ['attribute' => 'name']));
    }

    /**
     * Test if a room cant be edited when issert name less
     * than 3 characters.
     */
    public function testEditRoomWithNameLessThan3Characters()
    {
        $room = $this->createFakerRoom();
        $this->visit(route('hotel.room.edit', $room->id))
            ->type('A5', '#name')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.min.string', [
                'attribute' => 'name',
                'min' => 3
                ]));
    }

    /**
     * Test if a room cant be edited when issert name more
     * than 15 characters.
     */
    public function testEditRoomWithNameMoreThan15Characters()
    {
        $room = $this->createFakerRoom();
        $this->visit(route('hotel.room.edit', $room->id))
            ->type('A105105105105105', '#name')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.max.string', [
                'attribute' => 'name',
                'max' => 15
                ]));
    }

    /**
     * Test if a room cant be edited when issert name with wrong regex.
     */
    public function testEditRoomWithWrongRegexName()
    {
        $room = $this->createFakerRoom();
        $this->visit(route('hotel.room.edit', $room->id))
            ->type('a105', '#name')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.regex', ['attribute' => 'name']));
    }
}
