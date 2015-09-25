<?php

namespace HotelBooking\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use HotelBooking\Http\Requests;
use HotelBooking\Http\Controllers\Controller;
use HotelBooking\Http\Requests\Admin\LoginRequest;

class AuthController extends AdminBaseController
{
    /**
     * [show page lofin for admin]
     * @return Response
     */
    public function getLoginAdmin()
    {
      if(Auth::admin()->check())
      {
            return redirect()->route('admin.index');
      }
      return view('admin.login');
    }

    /**
     * [login for admin]
     * @param  AdminLoginRequest $request
     * @return Response
     */
    public function postLoginAdmin(LoginRequest $request)
    {
      if(Auth::admin()->check())
      {
            return redirect()->route('admin.login');
      }
      if(Auth::admin()->attempt($request
                      ->only('username','password'),$request
                      ->has('remember')))
      {
          return redirect()->route('admin.index');
      }
      else
      {
          return redirect()->route('admin.login')
                            ->withInput($request->only('username'))
                            ->withErrors(['username'=>'These credentials do not match our records.']);
      }
    }

    /**
     * [logout for admin]
     * @return Response
     */
    public function getAdminLogout()
    {
      Auth::admin()->logout();
      return redirect()->route('admin.login');
    }

}
