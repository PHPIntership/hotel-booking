<?php

namespace HotelBooking\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use HotelBooking\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use HotelBooking\Order;
use HotelBooking\Room;
use HotelBooking\CheckIn;
use HotelBooking\HotelRoomType;
use Auth;
use Session;

class CheckInController extends Controller
{
    /**
     * Construct.
     */
    public function __construct()
    {
        $this->auth = Auth::hotel();
        $this->middleware('auth.hotel');
        $this->hotelRoomType = HotelRoomType::select('id')
            ->where('hotel_id', $this->auth->get()->hotel_id)
            ->get();
    }

    /**
     * Check permission.
     *
     * @param $id order id
     *
     * @return HotelBooking/Order
     */
    public function checkPermission($id)
    {
        $columnOrders = [
            'id',
            'hotel_room_type_id',
            'coming_date',
            'leave_date',
            'price',
            'quantity',
            'status',
        ];

        return Order::where('id', $id)
            ->whereIn('hotel_room_type_id', $this->hotelRoomType)
            ->select($columnOrders)
            ->get()
            ->first();
    }

    /**
     * List check in of order.
     *
     * @param $id check in id
     *
     * @return Response
     */
    public function checkIn($id)
    {
        $columnChekIns = [
            'id',
            'room_id',
            'order_id',
            'hotel_admin_id',
            'coming_date',
            'leave_date',
            'price',
        ];
        try {
            $hotelAdminId = $this->auth->get()->id;
            $order = $this->checkPermission($id);
            if (count($order) < 1) {
                Session::flash('flash_error', trans('messages.no_permission'));

                return redirect()->route('hotel.booking-manage.index');
            }
            if ($order->status == Order::ACCEPTED_STATUS) {
                $data = [];
                for ($i = 0; $i < $order->quantity; ++$i) {
                    array_push($data, [
                        'order_id' => $id,
                        'room_id' => null,
                        'hotel_admin_id' => $hotelAdminId,
                        'coming_date' => $order->coming_date,
                    ]);
                }
                $order->syncRoom($data);
            }
            $withHotelRoomType['hotelRoomType'] = function ($query) {
                    $query->select(['id', 'name', 'price']);
            };
            $withRoom['room'] = function ($query) use ($withHotelRoomType) {
                    $query->with($withHotelRoomType)->select(['id', 'hotel_room_type_id', 'name']);
            };
            $checkIns = CheckIn::with($withRoom)->where('order_id', $id)->select($columnChekIns)->get();
            $order->update(['status' => Order::CHECKED_IN_STATUS]);
            $rooms = Room::where('hotel_room_type_id', '=', $order->hotel_room_type_id)
                ->where('status', Room::FREE_STATUS)
                ->lists('name', 'id');
            foreach ($checkIns as $value) {
                if ($value->room_id != null) {
                    $rooms[$value->room_id] = $value->room->name;
                }
            }

            return view('hotel.booking-manage.check_order', compact('checkIns', 'rooms', 'order'));
        } catch (ModelNotFoundException $e) {
        }
        Session::flash('flash_error', trans('messages.data_not_found'));

        return redirect()->route('hotel.booking-manage.index');
    }

    /**
     * Get data check in for action check in.
     *
     * @param $id check in id
     *
     * @return HotelBooking/CheckIn
     */
    public function getCheckIn($id)
    {
        $columnChekIns = [
            'id',
            'room_id',
            'order_id',
            'hotel_admin_id',
            'coming_date',
            'leave_date',
            'price',
        ];

        return CheckIn::Find($id, $columnChekIns);
    }

    /**
     * Get data check in for action check in.
     *
     * @param $id check in id
     *
     * @return HotelBooking/CheckIn
     */
    public function getCheckOut($id)
    {
        $columnChekIns = [
            'id',
            'room_id',
            'order_id',
            'hotel_admin_id',
            'coming_date',
            'leave_date',
            'price',
        ];

        $withHotelRoomType['hotelRoomType'] = function ($query) {
                $query->select(['id', 'name', 'price']);
        };
        $withRoom['room'] = function ($query) use ($withHotelRoomType) {
                $query->with($withHotelRoomType)->select(['id', 'hotel_room_type_id', 'name']);
        };
        $checkIn = CheckIn::with($withRoom)->where('id', $id)->select($columnChekIns)->get()->first();

        return $checkIn;
    }

    /**
     * Check in or check out.
     *
     * @param Request $request
     * @param $id heck in id
     *
     * @return json
     */
    public function updateCheckIn(Request $request, $id)
    {
        $responseJson = [
            'status' => '200',
            'error' => 1,
            'url' => null,
            'messages' => null,
            'data' => null,
        ];
        $hotelAdminId = $this->auth->get()->id;

        try {
            if ($request->type == 'check_in') {
                $checkIn = $this->getCheckIn($id);
                if (!empty($checkIn->leave_date)) {
                    $responseJson['messages'] = trans('messages.checked_out');

                    return json_encode($responseJson);
                }
            } else {
                $checkIn = $this->getCheckOut($id);
            }
            $order = $this->checkPermission($checkIn->order_id);
            if (count($order) < 1) {
                $responseJson['messages'] = trans('messages.no_permission');

                return json_encode($responseJson);
            }
            $validate = CheckIn::validate($request->all(), $order);
            if (!$validate->passes()) {
                $responseJson['messages'] = $validate->messages();

                return json_encode($responseJson);
            }
            $dataUpdate = [
                'room_id' => $request->room_id,
                'price' => $request->price,
                'hotel_admin_id' => $hotelAdminId,
            ];
            if (!empty($request->coming_date)) {
                $request->coming_date = date_create($request->coming_date);
                $dataUpdate += ['coming_date' => $request->coming_date];
            } else {
                $request->coming_date = null;
            }
            if (!empty($request->leave_date)) {
                $request->leave_date = date_create($request->leave_date);
                $dataUpdate += ['leave_date' => $request->leave_date];
            } else {
                $request->leave_date = null;
            }

            $checkIn->update($dataUpdate);
            $responseJson['error'] = 0;
            $responseJson['url'] = route('hotel.checkin', $checkIn->id);
            $responseJson['messages'] = trans('messages.check_success');
            $responseJson['data'] = $checkIn;
            if ($request->type == 'check_in') {
                Room::where('id', $request->room_id)->update(['status' => Room::USED_STATUS]);
            } else {
                Room::where('id', $request->room_id)->update(['status' => Room::FREE_STATUS]);
            }

            return json_encode($responseJson);
        } catch (ModelNotFoundException $e) {
            $responseJson['messages'] = trans('messages.check_fail');

            return json_encode($responseJson);
        }
    }
}
