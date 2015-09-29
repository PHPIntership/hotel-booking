<?php

namespace HotelBooking\Http\Controllers\Admin;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hotels = DB::table('hotels')
        ->select('id', 'name')
        ->get();
        return view('admin.create_admin_hotel', compact('hotels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminHotelCreateFormRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        if (AdminHotel::create($data)) {
            Session::flash('flash_message', 'You had created an admin hotel account');
        }
        return redirect()->route('admin-hotel.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $params = ['id', 'username', 'hotel_id', 'phone', 'name'];
        $adminHotel = DB::table('admin_hotels')
        ->select($params)
        ->where('id', $id)
        ->first();
        $hotels = DB::table('hotels')
        ->select('id', 'name')
        ->get();
        return view('admin.edit_admin_hotel', compact('adminHotel', 'hotels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminHotelUpdateFormRequest $request, $id)
    {
        $hotel_id = $request->input('hotel_id');
        $name = $request->input('name');
        $phone = $request->input('phone');
        $params = ['hotel_id', 'name', 'phone'];
        $adminHotel = AdminHotel::find($id);
        $adminHotel->hotel_id = $hotel_id;
        $adminHotel->name = $name;
        $adminHotel->phone = $phone;
        $adminHotel->save();
        Session::flash('flash_message', 'Successfully updated hotel admin\'s information');
        return redirect()->route('admin-hotel.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
