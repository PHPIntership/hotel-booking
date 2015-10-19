<?php

namespace HotelBooking\Http\Controllers\Hotel;

use HotelBooking\Http\Controllers\Controller;
use Auth;
use HotelBooking\Order;
use HotelBooking\HotelRoomType;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookingManageController extends Controller
{
    /*
     * Controller constructor.
     */
    public function __construct()
    {
        $this->auth = Auth::hotel();
        $this->middleware('auth.hotel');
    }
    /*
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hotelRoomType = HotelRoomType::select('id')
            ->where('hotel_id', Auth::hotel()->get()->hotel_id)
            ->get();
        $columns = [
            'id',
            'user_id',
            'hotel_room_type_id',
            'quantity',
            'coming_date',
            'leave_date',
            'status',
        ];
        $label = [
            'info',
            'success',
            'warning',
            'danger',
        ];
        $with['user'] = function ($query) {
            $query->select('id', 'name');
        };
        $with['hotelRoomType'] = function ($query) {
            $query->select('id', 'name');
        };
        $orders = Order::with($with)
            ->select($columns)
            ->whereIn('hotel_room_type_id', $hotelRoomType)
            ->paginate(20);

        return view('hotel.booking-manage.index', compact('orders', 'label'));
    }

    /*
    * Accept order if admin hotel want accept from storage.
    *
    * @param $id
    */
    public function postAccept($id)
    {
        try {
            $order = Order::findOrFail($id, ['id', 'status']);
            $order->status = 1;
            $order->save();

            return redirect()
                ->route('hotel.booking-manage.index')
                ->with('flash_success', trans('messages.accept_success_booking_manage'));
        } catch (ModelNotFoundException $ex) {
            return redirect()
                ->route('hotel.booking-manage.index')
                ->with('flash_error', trans('messages.accept_fail_booking_manage'));
        }
    }

    /*
    * Decline order if admin hotel want decline from storage.
    *
    * @param $id
    */
    public function postDecline($id)
    {
        try {
            $order = Order::findOrFail($id, ['id', 'status']);
            $order->status = 3;
            $order->save();

            return redirect()
                ->route('hotel.booking-manage.index')
                ->with('flash_success', trans('messages.decline_success_booking_manage'));
        } catch (ModelNotFoundException $ex) {
            return redirect()
                ->route('hotel.booking-manage.index')
                ->with('flash_error', trans('messages.decline_fail_booking_manage'));
        }
    }

    /*
    * Cancel order if admin hotel want cancel from storage.
    *
    * @param $id
    */
    public function postCancel($id)
    {
        try {
            $order = Order::findOrFail($id, ['id', 'status']);
            $order->status = 3;
            $order->save();

            return redirect()
                ->route('hotel.booking-manage.index')
                ->with('flash_success', trans('messages.cancel_success_booking_manage'));
        } catch (ModelNotFoundException $ex) {
            return redirect()
                ->route('hotel.booking-manage.index')
                ->with('flash_error', trans('messages.cancel_fail_booking_manage'));
        }
    }

    /**
    * Display the specified resource.
    *
    * @param int $id
    *
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        return $id;
    }

    /*
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        try {
            $bookingManages = Order::findOrFail($id);
            $bookingManages->delete();

            return redirect()
                ->route('hotel.booking-manage.index')
                ->with('flash_success', trans('messages.delete_success_booking_manage'));
        } catch (ModelNotFoundException $ex) {
            return redirect()
                ->route('hotel.booking-manage.index')
                ->with('flash_error', trans('messages.delete_fail_booking_manage'));
        }
    }
}
