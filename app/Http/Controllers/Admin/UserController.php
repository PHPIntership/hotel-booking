<?php

namespace HotelBooking\Http\Controllers\Admin;

use HotelBooking\Http\Requests\Admin\UserRequest;
use HotelBooking\AdminUser;
use Auth;
use Hash;
use Session;
/**
 * Admin UserController
 */
class UserController extends AdminBaseController
{
    /**
     * Authenticator
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
     * Update Profile Admin User.
     *
     * @param AdminUserRequest $request [description]
     *
     * @return Response
     */
    public function putEditProfile(UserRequest $request)
    {
        $newPassword = $request->new_password;
        $oldPassword = $request->old_password;
        if (!Hash::check($oldPassword, $this->auth->get()->password)) {
            return redirect()->route('admin.profile.edit')
                ->withErrors([
                    'old_password' => trans('validation.invalid', ['name' => 'old password']),
                ]);
        }
        $adminUser = AdminUser::findOrFail($this->auth->get()->id);
        $newPassword = Hash::make($newPassword);
        $adminUser->update([
            'password' => $newPassword,
          ]);
        Session::flash('flash_success', trans('messages.update_success'));

        return redirect()->route('admin.profile.edit');
    }
}
