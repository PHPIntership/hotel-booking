<?php

namespace HotelBooking\Http\Controllers\Admin;

use HotelBooking\Hotel;
use HotelBooking\Http\Controllers\Controller;
use Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Hotels Controller.
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

        return view('admin.hotel.index', compact('hotels'));
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
