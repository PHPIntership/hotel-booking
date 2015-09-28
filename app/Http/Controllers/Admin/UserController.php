<?php

namespace HotelBooking\Http\Controllers\Admin;

use Illuminate\Http\Request;
use HotelBooking\Http\Requests;
use HotelBooking\Http\Controllers\Controller;
use HotelBooking\Http\Requests\Admin\UserRequest;
use HotelBooking\AdminUser;
use Auth;
use Hash;

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
       * Show view edit profile Admin User
       * @return Response
       */
    public function getEditProfile()
    {
        return view('admin.edit_profile');
    }

      /**
       * update Profile Admin User
       * @param  AdminUserRequest $request [description]
       * @return Response
       */
    public function putEditProfile(UserRequest $request)
    {
        $new_password = $request->new_password;
        $old_password = $request->old_password;
        if (!Hash::check($old_password, $this->auth->get()->password)) {
            return redirect()->route('admin.edit.profile')
                              ->withErrors([
                                  'old_password'=>'Old Password invalid'
                                ]);
        }
        $admin_user = AdminUser::findOrFail($this->auth->get()->id);
        $admin_user->update([
            'password'=>Hash::make($new_password)
          ]);
        return redirect()->route('admin.edit.profile')
                          ->with([
                              'flash_level'   =>'success',
                              'flash_message' =>'Change password success!!'
                              ]);
    }
}
