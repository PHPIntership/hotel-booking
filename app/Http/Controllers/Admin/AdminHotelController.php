<?php

namespace HotelBooking\Http\Controllers\Admin;

use Illuminate\Http\Request;
use HotelBooking\Http\Requests;
use HotelBooking\Http\Controllers\Controller;
use HotelBooking\AdminHotel;

class AdminHotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $adminHotels = AdminHotel::paginate(10);
        //dd($adminhotelName=AdminHotel::find(4)->hotel);
        foreach ($adminHotels as $key => $value) {
            $hotel=$value->getHotel;
            if ($hotel) {
                $value->name_hotel=$hotel->name;
            } else {
                $value->name_hotel="";
            }
        }
       //dd(json_encode($adminHotels[1]->hotel->name));
        return view('admin.hotel_index', compact('adminHotels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $adminHotel = AdminHotel::findOrFail($id);
        $adminHotel->delete();
        return redirect()->route('adminhotel.index')
        ->with(['flash_level'=>'success','flash_message'=>'Delete success!!']);
    }
}
