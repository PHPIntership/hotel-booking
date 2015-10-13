<?php

namespace HotelBooking\Http\Controllers\Hotel;

use DB;
use Session;
use HotelBooking\Hotel;
use HotelBooking\HotelRoomType;
use HotelBooking\Http\Requests\Hotel\RoomTypeStoreFormRequest;
use HotelBooking\Http\Requests\Hotel\RoomTypeUpdateFormRequest;
use Auth;

/**
 * Hotel Room Type Controller.
 */
class RoomTypeController extends HotelBaseController
{
    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->auth = Auth::hotel();
        $this->middleware('auth.hotel');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hotelRoomType = Hotel::select('name', 'id')
            ->where('hotel_id', Auth::hotel()->get()->hotel_id);
        $roomTypes = DB::table('room_types')
            ->lists('name', 'id');

        return view('hotel.room-type.create', compact('hotelRoomType', 'roomTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(RoomTypeStoreFormRequest $request)
    {
        $data = $request->all();
        $data['hotel_id'] = Auth::hotel()->get()->hotel_id;
        if ($request->hasFile('image')) {
            $data['image'] = $this->imageUpload('hotel_room_type', $request->file('image'));
        }
        if (HotelRoomType::create($data)) {
            Session::flash('flash_success', trans('messages.create_success_hotel_room_type'));
        } else {
            Session::flash('flash_error', trans('messages.create_fail_hotel_room_type'));
        };

        return redirect()->route('hotel.room-type.create');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $columns = ['id', 'name', 'quality', 'quantity', 'price', 'image', 'description'];
        $hotelRoomType = HotelRoomType::select($columns)
            ->where('id', $id)
            ->where('hotel_id', Auth::hotel()->get()->hotel_id)
            ->first();
        $roomType = DB::table('room_types')
            ->lists('name', 'id');
        if ($hotelRoomType) {
            return view('hotel.room-type.edit', compact('hotelRoomType', 'roomType'));
        } else {
            return view('hotel.errors.503');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(RoomTypeUpdateFormRequest $request, $id)
    {
        $comlumn = [
            'id',
            'name',
            'quality',
            'quantity',
            'description',
            'image',
        ];
        $hotelRoomType = HotelRoomType::select($comlumn)
            ->where('id', $id)
            ->where('hotel_id', Auth::hotel()->get()->hotel_id)
            ->first();
        if ($hotelRoomType) {
            $updateInfo = $request->all();
            if ($request->hasFile('image')) {
                $updateInfo['image'] = $this->imageUpload('hotel_room_type', $request->file('image'));
                $oldImage = $hotelRoomType->image;
            }
            if ($hotelRoomType->update($updateInfo)) {
                if (isset($oldImage)) {
                    $this->imageRemove('hotel_room_type', $oldImage);
                }
                Session::flash('flash_success', trans('messages.edit_success_hotel_room_type'));
            } else {
                $this->imageRemove('hotel_room_type', $updateInfo['image']);
                Session::flash('flash_error', trans('messages.edit_fail_hotel_room_type'));
            };
        }

        return redirect(route('hotel.room-type.edit', $id));
    }
}
