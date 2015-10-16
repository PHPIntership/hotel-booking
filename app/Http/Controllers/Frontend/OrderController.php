<?php

namespace HotelBooking\Http\Controllers\Frontend;

use HotelBooking\Http\Controllers\Controller;
use HotelBooking\HotelRoomType;
use HotelBooking\CheckIn;
use HotelBooking\Order;
use Carbon\Carbon;
/**
 * OrderController.
 */
class OrderController extends FrontendBaseController
{
    /**
     * Load view with table of Order list
     *
     * @return view
     */
    public function history()
    {
    }

    /**
     * Load view with Booking form
     *
     * @return view
     */
    public function create()
    {
    }

    /**
     * Create new Order from request information and sotre into database
     *
     * @param $request
     *
     * @return redirect
     */
    public function store(Request $request)
    {
    }
}
