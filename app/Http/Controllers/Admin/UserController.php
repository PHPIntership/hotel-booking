<?php

namespace HotelBooking\Http\Controllers\Admin;

use Illuminate\Http\Request;
use HotelBooking\Http\Requests;
use HotelBooking\Http\Controllers\Controller;
use HotelBooking\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Session;

class UserController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = [
            'id',
            'username',
            'name',
            'address',
            'email',
            'phone',
            'image',
        ];
        $users = User::select($columns)->paginate(20);
        return view('admin.user.index', compact('users'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $columns = [
            'id',
            'username',
            'name',
            'address',
            'email',
            'phone',
            'image',
        ];
        try {
            $user = User::findorFail($id, $columns);
            return view('admin.user.edit', compact('user'));
        } catch (ModelNotFoundException $e) {
            Session::flash('flash_error', trans('messages.data_not_found'));

            return redirect(route('admin.user.index'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $columns = [
            'id',
            'name',
            'phone',
            'image',
        ];
        $updateInfo = $request->only('name', 'phone', 'address');
        try {
            $user = User::findorFail($id, $columns);
            $oldImage = $user['image'];
            if ($request->hasFile('image')) {
                $updateInfo['image'] = $this->imageUpload(User::UPLOAD_KEY, $request->file('image'));
                $this->imageRemove(User::UPLOAD_KEY, $oldImage);
            }
            $user->update($updateInfo);
            Session::flash('flash_success', trans('messages.update_success'));
            return view('admin.user.edit', compact('user'));
        } catch (ModelNotFoundException $e) {
            Session::flash('flash_error', trans('messages.data_not_found'));

            return redirect(route('admin.user.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findorFail($id, ['id']);
            $user->delete();
            Session::flash('flash_success', trans('messages.delete_success'));
        } catch (ModelNotFoundException $e) {
            Session::flash('flash_error', trans('messages.data_not_found'));
        }
        return redirect(route('admin.user.index'));
    }
}
