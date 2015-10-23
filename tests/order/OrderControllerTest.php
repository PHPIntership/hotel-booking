<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use HotelBooking\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use HotelBooking\HotelRoomType;
use HotelBooking\Hotel;
use HotelBooking\City;
use HotelBooking\Order;
use HotelBooking\Room;
use Carbon\Carbon;

/**
 * Test class for OrderController
 */
class OrderControllerTest extends TestCase
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
            $this->seedUser();
            $seed = true;
        }
    }

    /**
     * Override actingAs function for setting the current authenticated hotel admin.
     */
    public function actingAs($hotelAdmin = null)
    {
        $user = User::select('id')->first();
        Auth::user()->login($user);
    }

    /**
     *Create a temporary User with Faker\Factory
     *
     *@return HotelBooking\User.
     */
    private function seedUser()
    {
        $faker = Faker\Factory::create();
        $request = [
            'username' => $faker->username,
            'password' => $faker->password,
            'email' => $faker->email,
            'phone' => $faker->phonenumber,
            'name' => $faker->name,
        ];
        return User::create($request);
    }

    /**
     *Create a temporary Hotel with Faker\Factory
     *
     *@return HotelBooking\User.
     */
    private function seedHotel()
    {
        $faker = Faker\Factory::create();
        $city = City::create(['name' => $faker->name]);
        $request = [
            'city_id' => $city->id,
            'name' => $faker->name,
            'quality' => 1,
            'address' => $faker->address,
            'phone' => $faker->phonenumber,
            'email' => $faker->email,
            'description' => $faker->text,
        ];
        return Hotel::create($request);
    }

    /**
     *Create a temporary HotelRoomType with Faker\Factory
     *
     *@return HotelBooking\User.
     */
    private function seedHotelRoomType()
    {
        $faker = Faker\Factory::create();
        $hotel = $this->seedHotel();
        $request = [
            'room_type_id' => 1,
            'hotel_id' => $hotel->id,
            'name' => $faker->name,
            'quality' => 'normal',
            'price' => 10,
            'description' => $faker->text,
        ];
        $hotelRoomType = HotelRoomType::create($request);
        Room::create([
            'hotel_room_type_id' => $hotelRoomType->id,
            'name' => $faker->name,
        ]);
        return $hotelRoomType;
    }

    /**
     * Test load action, GET method
     *
     * @return void
     */
    public function testLoadStatus()
    {
        $hotelRoomType = $this->seedHotelRoomType();
        $response = $this->call('GET', route('order.load', $hotelRoomType->id));
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
        $response = $this->call('POST', route('order.store'));
        $this->assertEquals(302, $response->status());
    }

    /**
     * Test if the Order is created when issert valid data.
     *
     * @return void
     */
    public function testOrderCreated()
    {
        $this->actingAs();
        $hotelRoomType = $this->seedHotelRoomType();
        $this->visit(route('order.load', $hotelRoomType->id))
            ->press(trans('messages.order_submit'))
            ->see(trans('messages.order_success', ['price' => 10]));
    }

    /**
     * Test if the Order cant be created when issert out of available quantity.
     *
     * @return void
     */
    public function testOrderWithOutOfQuantity()
    {
        $this->actingAs();
        $hotelRoomType = $this->seedHotelRoomType();
        $this->visit(route('order.load', $hotelRoomType->id))
            ->type('2', '#quantity')
            ->press(trans('messages.order_submit'))
            ->see(trans('messages.order_fail', ['available_quantity' => 1]));
    }

    /**
     * Test if the Order cant be created when issert null comingDate.
     *
     * @return void
     */
    public function testOrderWithoutComingDate()
    {
        $this->actingAs();
        $hotelRoomType = $this->seedHotelRoomType();
        $this->visit(route('order.load', $hotelRoomType->id))
            ->type('', '#coming_date')
            ->press(trans('messages.order_submit'))
            ->see(trans('validation.required', ['attribute' => 'coming date']));
    }

    /**
     * Test if the Order cant be created when issert comingDate without date format.
     *
     * @return void
     */
    public function testOrderWithoutDateFormatComingDate()
    {
        $this->actingAs();
        $hotelRoomType = $this->seedHotelRoomType();
        $this->visit(route('order.load', $hotelRoomType->id))
            ->type('abc', '#coming_date')
            ->press(trans('messages.order_submit'))
            ->see(trans('validation.date', ['attribute' => 'coming date']));
    }

    /**
     * Test if the Order cant be created when issert comingDate without after tomorrow.
     *
     * @return void
     */
    public function testOrderWithComingDateNotAfterTomorrow()
    {
        $this->actingAs();
        $hotelRoomType = $this->seedHotelRoomType();
        $this->visit(route('order.load', $hotelRoomType->id))
            ->type(Carbon::now()->toDateString(), '#coming_date')
            ->press(trans('messages.order_submit'))
            ->see(trans('validation.after', [
                'attribute' => 'coming date',
                'date' => 'tomorrow'
                ]));
    }

    /**
     * Test if the Order cant be created when issert null leaveDate.
     *
     * @return void
     */
    public function testOrderWithoutLeaveDate()
    {
        $this->actingAs();
        $hotelRoomType = $this->seedHotelRoomType();
        $this->visit(route('order.load', $hotelRoomType->id))
            ->type('', '#leave_date')
            ->press(trans('messages.order_submit'))
            ->see(trans('validation.required', ['attribute' => 'leave date']));
    }

    /**
     * Test if the Order cant be created when issert leaveDate without date format.
     *
     * @return void
     */
    public function testOrderWithoutDateFormatLeaveDate()
    {
        $this->actingAs();
        $hotelRoomType = $this->seedHotelRoomType();
        $this->visit(route('order.load', $hotelRoomType->id))
            ->type('abc', '#leave_date')
            ->press(trans('messages.order_submit'))
            ->see(trans('validation.date', ['attribute' => 'leave date']));
    }

    /**
     * Test if the Order cant be created when issert leaveDate without after comingDate.
     *
     * @return void
     */
    public function testOrderWithLeaveDateNotAfterComingDate()
    {
        $this->actingAs();
        $hotelRoomType = $this->seedHotelRoomType();
        $this->visit(route('order.load', $hotelRoomType->id))
            ->type(Carbon::now()->addDay(2)->toDateString(), '#coming_date')
            ->type(Carbon::now()->toDateString(), '#leave_date')
            ->press(trans('messages.order_submit'))
            ->see(trans('validation.after', [
                'attribute' => 'leave date',
                'date' => 'coming date'
                ]));
    }

    /**
     * Test if the Order cant be created when issert null quantity.
     *
     * @return void
     */
    public function testOrderWithoutQuantity()
    {
        $this->actingAs();
        $hotelRoomType = $this->seedHotelRoomType();
        $this->visit(route('order.load', $hotelRoomType->id))
            ->type('', '#quantity')
            ->press(trans('messages.order_submit'))
            ->see(trans('validation.required', ['attribute' => 'quantity']));
    }

    /**
     * Test if the Order cant be created when issert quantity less than 1.
     *
     * @return void
     */
    public function testOrderWithQuantityLessThan1()
    {
        $this->actingAs();
        $hotelRoomType = $this->seedHotelRoomType();
        $this->visit(route('order.load', $hotelRoomType->id))
            ->type('0', '#quantity')
            ->press(trans('messages.order_submit'))
            ->see(trans('validation.min.numeric', [
                'attribute' => 'quantity',
                'min' => 1
                ]));
    }

    /**
     * Test if the Order cant be created when issert non integer quantity.
     *
     * @return void
     */
    public function testOrderWithNoneIntegerQuantity()
    {
        $this->actingAs();
        $hotelRoomType = $this->seedHotelRoomType();
        $this->visit(route('order.load', $hotelRoomType->id))
            ->type('a', '#quantity')
            ->press(trans('messages.order_submit'))
            ->see(trans('validation.integer', ['attribute' => 'quantity']));
    }

    /**
     * Test if the Order cant be created when issert wrong regex comment.
     *
     * @return void
     */
    public function testOrderWithWrongRegexComment()
    {
        $this->actingAs();
        $hotelRoomType = $this->seedHotelRoomType();
        $this->visit(route('order.load', $hotelRoomType->id))
            ->type('(a)', '#comment')
            ->press(trans('messages.order_submit'))
            ->see(trans('validation.regex', ['attribute' => 'comment']));
    }
}
