<?php

namespace HotelBooking\Http\Controllers\Admin;

use DB;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use HotelBooking\Hotel;
use HotelBooking\City;
use HotelBooking\Http\Requests\Admin\HotelCreateRequest;
use HotelBooking\Http\Requests\Admin\HotelEditRequest;
use HotelBooking\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Auth;

/**
 * HotelController
 */

class HotelController extends AdminBaseController
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
        //return $hotels;
        return view('admin.hotel.index', compact('hotels'));
    }

    /**
     * Load view with Hotel creating form
     *
     * @return view
     */
    public function create()
    {
        $cities = DB::table('cities')
            ->lists('name', 'id');
        return view('admin.hotel.create', compact('cities'));
    }

    /**
     * Create new Hotel from request information and sotre into database
     *
     * @param HotelCreateRequest $request
     *
     * @return redirect
     */
    public function store(HotelCreateRequest $request)
    {
        if (Hotel::create($request->all())) {
            Session::flash('flash_success', trans('messages.create_success_hotel'));
        } else {
            Session::flash('flash_error', trans('messages.create_fail_hotel'));
        }
        return redirect(route('admin.hotel.create'));
    }

    public function show($id)
    {
        return $id;
    }

    /**
     * Load view with Hotel editting form
     *
     * @param int $id
     *
     * @return view
     */
    public function edit($id)
    {
        $columns = [
            'id',
            'city_id',
            'name',
            'quality',
            'address',
            'phone',
            'email',
            'website',
            'image',
            'description'
        ];
        $hotel = Hotel::select($columns)
            ->where('id', $id)
            ->first();
        $cities = DB::table('cities')
            ->lists('name', 'id');
        if ($hotel) {
            return view('admin.hotel.edit', compact('hotel', 'cities'));
        } else {
            return view('admin.errors.503');
        }
    }

    /**
     * Update Hotel from request information into database
     *
     * @param HotelEditRequest $request
     * @param int $id
     *
     * @return redirect
     */
    public function update(HotelEditRequest $request, $id)
    {
        $hotel = Hotel::select('id', 'image')
            ->where('id', $id)
            ->first();
        if ($hotel) {
            $updateInfo = $request->all();
            if ($request->hasFile('image')) {
                $updateInfo['image'] = $this->imageUpload('hotel', $request->file('image'));
                $oldImage = $hotel->image;
            }
            if ($hotel->update($updateInfo)) {
                if (isset($oldImage)) {
                    $this->imageRemove('hotel', $oldImage);
                }
                Session::flash('flash_success', trans('messages.edit_success_hotel'));
            } else {
                $this->imageRemove('hotel', $updateInfo['image']);
                Session::flash('flash_error', trans('messages.edit_fail_hotel'));
            };
        }
        return redirect(route('admin.hotel.edit', $id));
    }

    /**
     * Remove the specified hotel from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $hotel = Hotel::findOrFail($id);
            $hotel->delete();
            Session::flash('flash_success', trans('messages.delete_success_hotel'));

            return redirect()->route('admin.hotel.index');
        } catch (ModelNotFoundException $e) {
            Session::flash('flash_error', trans('messages.delete_fail_hotel'));

            return redirect()->route('admin.hotel.index');
        }
    }
}
