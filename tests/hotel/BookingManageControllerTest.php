<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use HotelBooking\AdminHotel;

class BookingManageControllerTest extends TestCase
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
            DB::table('users')->truncate();
            DB::table('orders')->truncate();
            $this->seed('AdminHotelTableSeeder');
            $this->seed('HotelRoomTypeSeeder');
            $this->seed('HotelTableSeeder');
            $this->seed('UserTableSeeder');
            $this->seed('OrderSeeder');
            $seed = true;
        }
    }
    /**
     * Override actingAs function for setting the current authenticated hotel booking manage.
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
     * Test display page index listing hotel booking manage.
     */
    public function testViewIndex()
    {
        $this->actingAs();
        $this->visit(route('hotel.booking-manage.index'))
             ->see(trans('messages.booking_manage'));
    }
    /**
     * Test status method GET display listing hotel booking manage.
     */
    public function testIndexStatus()
    {
        $this->actingAs();
        $response = $this->call('GET', 'hotel/booking-manage');
        $this->assertEquals(200, $response->status());
    }
    /**
     * Test accept order. status order: waiting to status accepted
     * default status waiting.
     */
    public function testAcceptedOrder()
    {
        $this->actingAs();
        $this->visit(route('hotel.booking-manage.index'))
            ->see(trans('messages.status_order_0'))
            ->press('Accept')
            ->see(trans('messages.accept_success_booking_manage'))
            ->see(trans('messages.status_order_1'));
    }
    /**
     * Test desline order. status order: waiting to status disable
     * default status waiting.
     */
    public function testDeclineOrder()
    {
        $this->actingAs();
        $this->visit(route('hotel.booking-manage.index'))
            ->see(trans('messages.status_order_0'))
            ->press('Decline')
            ->see(trans('messages.decline_success_booking_manage'))
            ->see(trans('messages.status_order_3'));
    }
}
