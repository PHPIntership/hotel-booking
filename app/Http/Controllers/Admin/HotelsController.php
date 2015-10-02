<?php

namespace HotelBooking\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use HotelBooking\Hotel;
use HotelBooking\City;
use HotelBooking\Services\Admin\HotelService;
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
        $cities = [
          'cities' => City::all()
        ];
        return view("admin.hotels.create", $cities);
    }

    /**
     * Create new Hotel from request information and sotre into database
     *
     * @param HotelCreateRequest $request
     * @return redirect
     */
    public function store(HotelCreateRequest $request)
    {
        HotelService::store($request->all());
        return redirect(route('admin.hotels.create'))
            ->with('create_success', trans('admin/hotels.create_success'));
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
        $hotel = Hotel::findOrFail($id);
        $cities = [
          'cities' => City::all()
        ];
        return view("admin.hotels.edit", $hotel, $cities);
    }

    /**
     * Update Hotel from request information into database
     *
     * @param Request $request
     * @param int $id
     * @return redirect
     */
    public function update(HotelEditRequest $request, $id)
    {
        HotelService::update($request->all(), $id);
        return redirect(route('admin.hotels.edit', $id))
            ->with('edit_success', Lang::get('admin/hotels.edit_success'));
    }

    public function destroy($id)
    {
    }
}
