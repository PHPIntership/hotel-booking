<?php

namespace HotelBooking\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use HotelBooking\Http\Requests\Admin\RoomTypeStoreFormRequest;
use HotelBooking\Http\Requests\Admin\RoomTypeUpdateFormRequest;
use HotelBooking\RoomType;
use Session;

/**
 * Room Type Controller.
 */
class RoomTypeController extends AdminBaseController
{

    /**
     * Display a listing of the Room Type.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = [
            'id',
            'name',
            'quality',
            'image',
        ];
        $roomTypes = RoomType::select($columns)->paginate(20);
        return view('admin.room-type.index', compact('roomTypes'));
    }

    /**
     * Show the form for creating a new Room Type.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.room-type.create');
    }

    /**
     * Store a newly created Room Type in storage.
     *
     * @param RoomTypeCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(RoomTypeStoreFormRequest $request)
    {
        $roomType = $request->only('name', 'quality');
        if ($request->hasFile('image')) {
            $roomType['image'] = $this->imageUpload(RoomType::UPLOAD_KEY, $request->file('image'));
        }
        if (RoomType::create($roomType)) {
            Session::flash('flash_success', trans('messages.create_success'));
        } else {
            Session::flash('flash_error', trans('messages.create_fail'));
        }

        return redirect(route('admin.room-type.create'));
    }

    /**
     * Show the form for editing the specified Room Type.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $columns = [
            'id',
            'name',
            'quality',
            'image',
        ];
        try {
            $roomType = RoomType::findOrFail($id, $columns);
            return view('admin.room-type.edit', compact('roomType'));
        } catch (ModelNotFoundException $e) {
            Session::flash('flash_error', trans('messages.data_not_found'));

            return redirect(route('admin.room-type.index'));
        }
    }

    /**
     * Update the specified Room Type.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(RoomTypeUpdateFormRequest $request, $id)
    {
        $columns = [
            'id',
            'name',
            'quality',
            'image',
        ];
        $updateInfo = $request->only('name', 'quality');
        try {
            $roomType = RoomType::findOrFail($id, $columns);
            $oldImage = $roomType['image'];
            if ($request->hasFile('image')) {
                $updateInfo['image'] = $this->imageUpload(RoomType::UPLOAD_KEY, $request->file('image'));
                $this->imageRemove(RoomType::UPLOAD_KEY, $oldImage);
            }
            if ($roomType->update($updateInfo)) {
                Session::flash('flash_success', trans('messages.update_success'));
            } else {
                Session::flash('flash_error', trans('messages.update_fail'));
            }

            return redirect(route('admin.room-type.edit', $id));
        } catch (ModelNotFoundException $e) {
            Session::flash('flash_error', trans('messages.data_not_found'));

            return redirect(route('admin.room-type.index'));
        }
    }

    /**
     * Remove the specified Room Type from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $roomType = RoomType::findOrFail($id, ['id']);
            $roomType->delete();
            Session::flash('flash_success', trans('messages.delete_success'));
        } catch (ModelNotFoundException $e) {
            Session::flash('flash_error', trans('messages.delete_fail'));
        }

        return redirect()->route('admin.room-type.index');
    }
}
