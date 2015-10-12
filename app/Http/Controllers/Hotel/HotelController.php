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
    /**
     * Path for upload hotel image
     */
    const UPLOAD_PATH = 'hotel';
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
        $hotelId = Auth::hotel()->get()->hotel_id;
        $columns = ['website', 'phone', 'description', 'image'];
        $hotel = Hotel::select($columns)
            ->where('id', $hotelId)->first();

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
        $hotelId = Auth::hotel()->get()->hotel_id;
        $hotel = Hotel::select('id', 'image')->where('id', $hotelId)->first();
        $updateColumns = $request->all();
        if ($request->hasFile('image')) {
            $oldImage = $hotel->image;
            $this->imageRemove(self::UPLOAD_PATH, $oldImage);
            $imageName = $this->imageUpload(self::UPLOAD_PATH, $request->file('image'));
            $updateColumns['image'] = $imageName;
        }
        if ($hotel->update($updateColumns)) {
            Session::flash('flash_success', trans('messages.edit_success_hotel'));

            return redirect()->route('hotel.profile');
        } else {
            Session::flash('flash_error', trans('messages.edit_fail_hotel'));

            return redirect()->route('hotel.profile');
        }
    }
}
