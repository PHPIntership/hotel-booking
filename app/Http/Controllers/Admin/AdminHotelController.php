<?php

namespace HotelBooking\Http\Controllers\Admin;

use Hash;
use DB;
use Session;
use HotelBooking\Hotel;
use HotelBooking\AdminHotel;
use Illuminate\Http\Request;
use HotelBooking\Http\Requests;
use HotelBooking\Http\Requests\Admin\AdminHotelCreateFormRequest;
use HotelBooking\Http\Requests\Admin\AdminHotelUpdateFormRequest;
use HotelBooking\Http\Controllers\Controller;
use HotelBooking\Http\Controllers\Admin\AdminBaseController;

class AdminHotelController extends AdminBaseController
{
    /**
     * Display a listing of the hotel admins.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a hotel admin
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hotels = DB::table('hotels')
            ->lists('name', 'id');
        return view('admin.admin-hotel.create', compact('hotels'));
    }

    /**
     * Store a newly created hotel admin in storage.
     *
     * @param  \Illuminate\Http\Request\Admin\
     *          AdminHotelCreateFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminHotelCreateFormRequest $request)
    {
        $data = $request->all();
        if (AdminHotel::create($data)) {
            Session::flash('flash_message', trans('messages.create_success').
                ' for '.trans('messages.hotel_admin')
            );
        }
        return redirect()->route('admin-hotel.create');
    }

    /**
     * Display the specified hotel admin.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified hotel admin.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $columns = ['id', 'username', 'hotel_id', 'phone', 'name'];
        $adminHotel = AdminHotel::select($columns)
            ->where('id', $id)
            ->first();
        $hotels = DB::table('hotels')
            ->lists('name', 'id');
        return view('admin.admin-hotel.edit', compact('adminHotel', 'hotels'));
    }

    /**
     * Update the specified hotel admin in storage.
     *
     * @param  \Illuminate\Http\Request\Admin\
     *         AdminHotelUpdateFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminHotelUpdateFormRequest $request, $id)
    {
        $adminHotel = AdminHotel::findOrFail($id);
        $adminHotel->update($request->all());
        Session::flash('flash_message', trans('messages.edit_success').
            ' for '.trans('messages.hotel_admin')
        );
        return redirect()->route('admin-hotel.edit', $id);
    }

    /**
     * Remove the specified hotel from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
