<?php

namespace HotelBooking\Http\Controllers\Admin;

use HotelBooking\Hotel;
use Illuminate\Http\Request;
use HotelBooking\Http\Requests;
use HotelBooking\Http\Controllers\Controller;
use Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class HotelsController extends AdminBaseController
{
    /**
     * Display a listing of the hotel.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = ['id', 'city_id', 'name', 'quality', 'address', 'image'];
        $hotels = Hotel::select($columns)
            ->with('city')
            ->paginate(20);
        return view('admin.hotel.index', compact('hotels'));
    }

    /**
     * Show the form for creating a new hotel.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in hotel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified hotel.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified hotel.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified hotel in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified hotel from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $hotel = Hotel::findOrFail($id);
            $hotel->delete();
            Session::flash('flash_success', trans('messages.delete_success_hotel'));
            return redirect()->route('admin.hotels.index');
        } catch (ModelNotFoundException $e) {
            Session::flash('flash_error', trans('messages.delete_fail_hotel'));
            return redirect()->route('admin.hotels.index');
        }
    }
}
