<?php

namespace HotelBooking\Http\Controllers\Frontend;

use Request;
use HotelBooking\Http\Controllers\Controller;
use Auth;
use HotelBooking\Http\Requests\Frontend\LoginRequest;
use Session;
use Route;
use Response;

/**
 * Auth Controller for frontend users
 */
class AuthController extends FrontendBaseController
{
    /**
     * Authenticate object.
     */
    protected $auth;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->auth = Auth::user();
        $this->middleware('user.guest', ['except' => 'getLogout']);
    }

    /**
     * Check log in data.
     */
    public function postLogin(LoginRequest $request)
    {
        $data = $request->only('username', 'password');
        $login = $this->auth->attempt($data);
        if ($login) {
            $redirectUrl = $request->input('pathname');
            return response()->json([
                'status' => 'success',
                'url' => $redirectUrl
            ]);
        } else {
            Session::flash('flash_error', trans('messages.login_fail'));
            return view('layouts.frontend.partials.flash');
        }
    }

    /**
     * Log out current hotel admin account.
     */
    public function getLogout()
    {
        $this->auth->logout();

        return redirect()->route('user.index');
    }
}
