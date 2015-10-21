<?php

namespace HotelBooking\Http\Controllers\Admin;

use DB;
use Session;
use HotelBooking\Hotel;
use HotelBooking\AdminHotel;
use HotelBooking\Http\Requests\Admin\AdminHotelCreateFormRequest;
use HotelBooking\Http\Requests\Admin\AdminHotelUpdateFormRequest;
use HotelBooking\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Controller class for Admin Hotel.
 */
class AdminHotelController extends AdminBaseController
{

    /**
     * Display a listing of the hotel admins.
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
        $with['hotel'] = function ($query) {
            $query->select('id', 'name');
        };
        $adminHotels = AdminHotel::with($with)
          ->select($column)
          ->paginate(10);

        return view('admin.admin-hotel.index', compact('adminHotels'));
    }

    /**
     * Show the form for creating a new hotel admin.
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
     * @param \Illuminate\Http\Request\Admin\AdminHotelCreateFormRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AdminHotelCreateFormRequest $request)
    {
        $data = $request->all();
        if (AdminHotel::create($data)) {
            Session::flash('flash_success', trans('messages.create_success_admin_hotel'));
        } else {
            Session::flash('flash_error', trans('messages.create_fail_admin_hotel'));
        }

        return redirect()->route('admin-hotel.create');
    }

    /**
     * Show the form for editing the specified hotel admin.
     *
     * @param int $id
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
     * @param \Illuminate\Http\Request\Admin\AdminHotelUpdateFormRequest $request
     * @param int                                                        $id
     */
    public function update(AdminHotelUpdateFormRequest $request, $id)
    {
        $adminHotel = AdminHotel::findOrFail($id);
        if ($adminHotel->update($request->all())) {
            Session::flash('flash_success', trans('messages.edit_success_admin_hotel'));
        } else {
            Session::flash('flash_error', trans('messages.edit_fail_admin_hotel'));
        }

        return redirect()->route('admin-hotel.edit', $id);
    }

    /**
     * Remove the specified hotel from storage.
     *
     * @param int $id
     */
    public function destroy($id)
    {
        try {
            $adminHotel = AdminHotel::findOrFail($id);
            $adminHotel->delete();

            return redirect()
                ->route('admin-hotel.index')
                ->with('flash_success', trans('messages.delete_success_admin_hotel'));
        } catch (ModelNotFoundException $ex) {
            return redirect()
                ->route('admin-hotel.index')
                ->with('flash_error', trans('messages.delete_fail_admin_hotel'));
        }
    }
}
