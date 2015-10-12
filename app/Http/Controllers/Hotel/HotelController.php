<?php

namespace HotelBooking\Http\Controllers\Hotel;

use HotelBooking\Http\Controllers\Controller;
use HotelBooking\Hotel;
use Auth;
use HotelBooking\Http\Requests\Hotel\EditFormRequest;
use Session;

/**
 * Hotel Controller.
 */
class HotelController extends HotelBaseController
{
    const PATH = 'hotel';
    /**
     * Constructor to implement auth middleware.
     */
    public function __construct()
    {
        $this->middleware('auth.hotel');
    }
    /**
     * Show the form for editing the hotel which the admin hotel owned.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $hotelID = Auth::hotel()->get()->hotel_id;
        $hotel = Hotel::select('website', 'phone', 'description', 'image')
            ->where('id', $hotelID)->first();

        return view('hotel.edit', compact('hotel'));
    }

    /**
     * Update the hotel information in storage.
     *
     * @param HotelBooking\Http\Requests\Hotel\EditFormRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(EditFormRequest $request)
    {
        $hotelID = Auth::hotel()->get()->hotel_id;
        $hotel = Hotel::select('id', 'image')->where('id', $hotelID)->first();
        $updateColumns = $request->all();
        if ($request->hasFile('image')) {
            $oldImage = $hotel->image;
            $this->imageRemove(self::PATH, $oldImage);
            $imageName = $this->imageUpload(self::PATH, $request->file('image'));
            $updateColumns['image'] = $imageName;
        }
        if ($hotel->update($updateColumns)) {
            Session::flash('flash_success', trans('messages.edit_success_hotel'));

            return redirect()->route('hotel.edit');
        } else {
            Session::flash('flash_error', trans('messages.edit_fail_hotel'));

            return redirect()->route('hotel.edit');
        }
    }
}
