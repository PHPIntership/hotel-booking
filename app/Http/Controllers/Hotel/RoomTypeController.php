<?php

namespace HotelBooking\Http\Controllers\Hotel;

use DB;
use Session;
use HotelBooking\Hotel;
use HotelBooking\HotelRoomType;
use HotelBooking\RoomType;
use HotelBooking\Http\Requests\Hotel\RoomTypeStoreFormRequest;
use HotelBooking\Http\Requests\Hotel\RoomTypeUpdateFormRequest;
use Auth;
use HotelBooking\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        $column = [
            'id',
            'room_type_id',
            'name',
            'quality',
            'quantity',
            'price',
            'description',
            'image',
        ];
        $with['roomType'] = function ($query) {
            $query->select('id', 'name');
        };
        $hotelRoomTypes = HotelRoomType::with($with)
          ->select($column)
          ->where('hotel_id', Auth::hotel()->get()->hotel_id)
          ->paginate(10);

        return view('hotel.room-type.index', compact('hotelRoomTypes'));
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
        HotelRoomType::create($data);
        Session::flash('flash_success', trans('messages.create_success_hotel_room_type'));

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
        $columns = [
            'id',
            'name',
            'quality',
            'quantity',
            'price',
            'image',
            'description',
        ];
        try {
            $hotelRoomType = HotelRoomType::where('hotel_id', Auth::hotel()->get()->hotel_id)
                ->findOrFail($id, $columns);
            $roomType = DB::table('room_types')
                ->lists('name', 'id');

            return view('hotel.room-type.edit', compact('hotelRoomType', 'roomType'));
        } catch (ModelNotFoundException $ex) {
            return view('hotel.errors.404');
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
        $columns = [
            'id',
            'name',
            'quality',
            'quantity',
            'description',
            'image',
        ];
        try {
            $hotelRoomType = HotelRoomType::where('hotel_id', Auth::hotel()->get()->hotel_id)
                ->findOrFail($id, $columns);
            $updateInfo = $request->all();
            if ($request->hasFile('image')) {
                $updateInfo['image'] = $this->imageUpload('hotel_room_type', $request->file('image'));
                $this->imageRemove('hotel_room_type', $hotelRoomType->image);
            }
            $hotelRoomType->update($updateInfo);
            Session::flash('flash_success', trans('messages.edit_success_hotel_room_type'));

            return redirect(route('hotel.room-type.edit', $id));
        } catch (ModelNotFoundException $ex) {
            Session::flash('flash_error', trans('messages.edit_fail_hotel_room_type'));

            return redirect(route('hotel.room-type.edit', $id));
        }
    }


    /**
     * Remove the specified hotel room type from storage.
     *
     * @param int $id
     */
    public function destroy($id)
    {
        try {
            $hotelRoomType = HotelRoomType::where('hotel_id', Auth::hotel()->get()->hotel_id)
                ->findOrFail($id);
            $hotelRoomType->delete();

            return redirect()
                ->route('hotel.room-type.index')
                ->with('flash_success', trans('messages.delete_success_hotel_room_type'));
        } catch (ModelNotFoundException $ex) {
            return redirect()
                ->route('hotel.room-type.index')
                ->with('flash_error', trans('messages.delete_fail_hotel_room_type'));
        }
    }
}
