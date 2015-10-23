<?php

namespace HotelBooking\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use HotelBooking\Http\Requests\Frontend\OrderRequest;
use HotelBooking\Http\Controllers\Controller;
use HotelBooking\HotelRoomType;
use HotelBooking\Order;
use Carbon\Carbon;
use Session;
use Auth;

/**
 * OrderController.
 */
class OrderController extends FrontendBaseController
{
    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->auth = Auth::user();
        $this->middleware('auth.user', ['only' => 'store']);
    }

    public function index()
    {
    }

    /**
     * Load view with Booking form
     *
     * @return view
     */
    public function load($hotelRoomTypeId)
    {
        if (HotelRoomType::find($hotelRoomTypeId, ['id'])) {
            $comingDate = Session::has('coming_date')
                ?Session::get('coming_date')
                :Carbon::now()->addDay(2)->toDateString();
            $leaveDate = Session::has('leave_date')
                ?Session::get('leave_date')
                :Carbon::now()->addDay(3)->toDateString();
            $quantity = Session::has('quantity')
                ?Session::get('quantity')
                :1;
            $data = [
                'hotel_room_type_id' => $hotelRoomTypeId,
                'coming_date' => $comingDate,
                'leave_date' => $leaveDate,
                'quantity' => $quantity,
            ];
            $order = new Order($data);
            return view('frontend.order.load', compact('order'));
        } else {
            return view('frontend.errors.404');
        }
    }

    /**
     * Create new Order from request information and sotre into database
     *
     * @param $request
     *
     * @return redirect
     */
    public function store(OrderRequest $request)
    {
        $order = new Order($request->all());
        $availableQuantity = $order->availableRoomQuantity;
        if ($order->quantity <= $availableQuantity) {
            $order->user_id = $this->auth->get()->id;
            $order->save();
            Session::flash(
                'flash_success',
                trans('messages.order_success', ['price' => $order->price])
            );
        } else {
            Session::flash(
                'flash_error',
                trans(
                    'messages.order_fail',
                    ['available_quantity' => $availableQuantity]
                )
            );
        }
        Session::put('coming_date', $order->coming_date);
        Session::put('leave_date', $order->leave_date);
        Session::put('quantity', $order->quantity);
        return redirect()->route('order.load', $order->hotel_room_type_id);
    }
}
