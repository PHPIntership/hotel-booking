<?php

namespace HotelBooking\Http\Controllers\Frontend;

use HotelBooking\Http\Controllers\Controller;
use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use HotelBooking\User;
use HotelBooking\Http\Requests\Frontend\ProfileRequest;
use Session;

class ProfileController extends FrontendBaseController
{
    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->auth = Auth::user();
        $this->middleware('auth.user');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProfile()
    {
        $id = $this->auth->get()->id;
        $columns = [
            'id',
            'name',
            'address',
            'email',
            'phone',
            'image',
        ];
        try {
            $user = User::findOrFail($id, $columns);

            return view('frontend.profile.profile', compact('user'));
        } catch (ModelNotFoundException $ex) {
            return view('frontend.errors.404');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function putProfile(ProfileRequest $request)
    {
        $id = $this->auth->get()->id;
        $columns = [
            'id',
            'name',
            'address',
            'email',
            'phone',
            'image',
        ];
        try {
            $user = User::findOrFail($id, $columns);

            $updateInfo = $request->all();
            if ($request->hasFile('image')) {
                $updateInfo['image'] = $this->imageUpload('user', $request->file('image'));
                $this->imageRemove('user', $user->image);
            }
            $user->update($updateInfo);
            Session::flash('flash_success', trans('messages.update_success_profile'));

            return redirect(route('user.profile'));
        } catch (ModelNotFoundException $ex) {
            Session::flash('flash_error', trans('messages.update_fail_profile'));

            return redirect(route('user.profile'));
        }
    }
}
