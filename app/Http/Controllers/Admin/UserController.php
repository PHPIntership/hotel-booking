<?php

namespace HotelBooking\Http\Controllers\Admin;

use HotelBooking\Http\Requests\Admin\UserRequest;
use HotelBooking\AdminUser;
use Auth;
use Hash;
use Session;

class UserController extends AdminBaseController
{
    /**
     * @var authenticate
     */
    protected $auth;

    public function __construct()
    {
        $this->auth = Auth::admin();
    }
    /**
     * Show view edit profile Admin User.
     *
     * @return Response
     */
    public function getEditProfile()
    {
        return view('admin.user.edit');
    }

    /**
     * update Profile Admin User.
     *
     * @param AdminUserRequest $request [description]
     *
     * @return Response
     */
    public function putEditProfile(UserRequest $request)
    {
        $new_password = $request->new_password;
        $old_password = $request->old_password;
        if (!Hash::check($old_password, $this->auth->get()->password)) {
            return redirect()->route('admin.profile.edit')
                ->withErrors([
                    'old_password' => trans('validation.invalid', ['name' => 'old password']),
                ]);
        }
        $admin_user = AdminUser::findOrFail($this->auth->get()->id);
        $new_password = Hash::make($new_password);
        $admin_user->update([
            'password' => $new_password,
          ]);
        Session::flash('flash_success', trans('messages.update_success'));

        return redirect()->route('admin.profile.edit');
    }
}
