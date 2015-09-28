<?php

namespace HotelBooking\Http\Controllers\Admin;

use Illuminate\Http\Request;
use HotelBooking\Hotel;
use HotelBooking\Services\Admin\HotelService;
use HotelBooking\Http\Requests\Admin\HotelCreateRequest;
use HotelBooking\Http\Requests\Admin\HotelEditRequest;
use HotelBooking\Http\Controllers\Controller;

/**
 * AdminBaseController
 */

class AdminHotelsController extends Controller
{

    public function index()
    {
    }

    public function create()
    {
        return view("admin.hotels.create");
    }

    public function store(HotelCreateRequest $request)
    {
        $hotel= HotelService::save($request->all());
        return $hotel;
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $hotel = Hotel::findOrFail($id);
        $cities = HotelService::cities();
        return view("admin.hotels.edit", $hotel, $cities);
    }

    public function update(HotelEditRequest $request, $id)
    {
        $hotel= HotelService::update($request->all(), $id);
        return $hotel;
    }

    public function destroy($id)
    {
    }
}
