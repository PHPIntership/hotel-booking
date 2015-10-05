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

/**
 * HotelsController
 */

class HotelsController extends AdminBaseController
{

    public function index()
    {
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
        return view('admin.hotels.create', compact('cities'));
    }

    /**
     * Create new Hotel from request information and sotre into database
     *
     * @param HotelCreateRequest $request
     * @return redirect
     */
    public function store(HotelCreateRequest $request)
    {
        if (Hotel::create($request->all())) {
            Session::flash('flash_success', trans('messages.create_success_hotel'));
        } else {
            Session::flash('flash_error', trans('messages.create_fail_hotel'));
        }
        return redirect(route('admin.hotels.create'));
    }

    public function show($id)
    {
    }

    /**
     * Load view with Hotel editting form
     *
     * @param int $id
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
            return view('admin.hotels.edit', compact('hotel', 'cities'));
        } else {
            return view('admin.errors.503');
        }
    }

    /**
     * Update Hotel from request information into database
     *
     * @param HotelEditRequest $request
     * @param int $id
     * @return redirect
     */
    public function update(HotelEditRequest $request, $id)
    {
        $hotel = Hotel::select('id', 'image')
            ->where('id', $id)
            ->first();
        if ($hotel) {
            $oldImage = $hotel->image;
            $updateInfo = $request->all();
            if ($request->hasFile('image')) {
                $updateInfo['image'] = $this->imageUpload($request->file('image'));
            }
            if ($hotel->update($updateInfo)) {
                $this->imageRemove($oldImage);
                Session::flash('flash_success', trans('messages.edit_success_hotel'));
            } else {
                $this->imageRemove($updateInfo['image']);
                Session::flash('flash_error', trans('messages.edit_fail_hotel'));
            };
        }
        return redirect(route('admin.hotels.edit', $id));
    }

    public function destroy($id)
    {
    }
}
