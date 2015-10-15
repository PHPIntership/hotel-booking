<?php

namespace HotelBooking\Http\Controllers\Frontend;

use Request;
use HotelBooking\Http\Controllers\Controller;
use Auth;
use HotelBooking\Http\Requests\Frontend\LoginRequest;
use Session;
use Route;
use Response;
use URL;

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
            $redirectUrl = URL::previous();
            return response()->json([
                'status' => 'success',
                'message' => '',
                'url' => $redirectUrl ? $redirectUrl : route('user.index')
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => trans('messages.login_fail'),
                'url' => ''
            ]);
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
