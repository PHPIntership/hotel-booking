<?php

namespace HotelBooking\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use HotelBooking\Http\Requests;
use HotelBooking\Http\Controllers\Controller;
use HotelBooking\Http\Requests\Admin\LoginRequest;

class AuthController extends AdminBaseController
{

    protected $auth;
    public function __construct()
    {
        $this->auth = Auth::admin();
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * show page login for admin
     * @return Response
     */
    public function getLogin()
    {
        return view('admin.auth.login');
    }

    /**
     * login for admin
     * @param  AdminLoginRequest $request
     * @return Response
     */
    public function postLogin(LoginRequest $request)
    {
        $login=$this->auth->attempt($request->only('username', 'password'), $request->has('remember'));
        if ($login) {
            return redirect()->intended(route('admin.profile.edit'));
        } else {
            return redirect()->route('admin.login')
                ->withInput($request->only('username', 'remember'))
                ->withErrors(['username'=>'These credentials do not match our records.']);
        }
    }

    /**
     * logout for admin
     * @return Response
     */
    public function getLogout()
    {
        $this->auth->logout();
        return redirect()->route('admin.login');
    }
}
