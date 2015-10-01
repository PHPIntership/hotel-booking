<?php

namespace HotelBooking\Http\Controllers\Admin;

use Illuminate\Http\Request;
use HotelBooking\Http\Requests;
use HotelBooking\Http\Controllers\Controller;
use HotelBooking\AdminHotel;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminHotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $column = [
            'id',
            'hotel_id',
            'username',
            'name',
            'email',
            'phone',
            ];
        $with['hotel'] =  function ($query) {
            $query->select('id', 'name');
        };
        $adminHotels =  AdminHotel::with($with)
          ->select($column)
          ->paginate(10);
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
        return redirect()
            ->route('admin-hotel.index')
            ->with('flash_message', trans('messages.delete_success').' for '
            .trans('messages.admin_hotel').' !!!');
    }
}
