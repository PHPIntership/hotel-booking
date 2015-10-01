<?php

namespace HotelBooking\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use HotelBooking\Hotel;
use HotelBooking\Services\Admin\HotelService;
use HotelBooking\Http\Requests\Admin\HotelCreateRequest;
use HotelBooking\Http\Requests\Admin\HotelEditRequest;
use HotelBooking\Http\Controllers\Controller;

/**
 * AdminHotelsController
 */

class AdminHotelsController extends Controller
{

    public function index()
    {
    }

    /**
     *
     *
     * @return view
     */
    public function create()
    {
        $thead = Lang::get('admin/hotels.thead');
        $cities = HotelService::cities();
        return view("admin.hotels.create", $cities)
                  ->with($thead);
    }

    /**
     *
     *
     * @param Request $request
     * @return redirect
     */
    public function store(HotelCreateRequest $request)
    {
        HotelService::save($request->all());
        return redirect(route('hotels.create'))
            ->with('msg', Lang::get('admin/hotels.create_success'));
    }

    public function show($id)
    {
    }

    /**
     *
     *
     * @param int $id
     * @return view
     */
    public function edit($id)
    {
        $thead = Lang::get('admin/hotels.thead');
        $hotel = Hotel::findOrFail($id);
        $cities = HotelService::cities();
        return view("admin.hotels.edit", $hotel, $cities)
                ->with($thead);

    }

    /**
     *
     *
     * @param Request $request
     * @param int $id
     * @return redirect
     */
    public function update(HotelEditRequest $request, $id)
    {
        HotelService::update($request->all(), $id);
        return redirect(route('admin.hotels.edit', $id))
            ->with('msg', Lang::get('admin/hotels.edit_success'));
    }

    public function destroy($id)
    {
    }
}
