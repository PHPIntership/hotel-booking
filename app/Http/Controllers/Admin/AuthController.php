<?php

namespace HotelBooking\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use HotelBooking\Http\Requests;
use HotelBooking\Http\Controllers\Controller;
use HotelBooking\Http\Requests\Admin\LoginRequest;

class AuthController extends AdminBaseController
{

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }
    /**
     * [show page lofin for admin]
     * @return Response
     */
    public function getLogin()
    {
        return view('admin.login');
    }

    /**
     * [login for admin]
     * @param  AdminLoginRequest $request
     * @return Response
     */
    public function postLogin(LoginRequest $request)
    {
        if (Auth::admin()->attempt($request->only('username', 'password'), $request->has('remember'))) {
            return redirect()->intended(route('admin.index'));
        } else {
            return redirect()->route('admin.login')
                              ->withInput($request->only('username', 'remember'))
                              ->withErrors(['username'=>'These credentials do not match our records.']);
        }
    }

    /**
     * [logout for admin]
     * @return Response
     */
    public function getLogout()
    {
        Auth::admin()->logout();
        return redirect()->route('admin.login');
    }
}
