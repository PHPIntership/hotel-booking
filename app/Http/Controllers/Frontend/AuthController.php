<?php

namespace HotelBooking\Http\Controllers\Frontend;

use Request;
use HotelBooking\Http\Controllers\Controller;
use Auth;
use HotelBooking\Http\Requests\Frontend\LoginRequest;
use HotelBooking\Http\Requests\Frontend\RegisterRequest;
use Session;
use Route;
use Response;
use URL;
use HotelBooking\User;

/**
 * Auth Controller for frontend users
 */
class AuthController extends FrontendBaseController
{
    /**
     * Upload key for image upload folder
     */
    const UPLOAD_KEY = 'user';
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
        $this->middleware('user.guest', ['only' => 'postLogin']);
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

    /**
     * Get the form for register an user
     */
    public function getRegister()
    {
        return view('frontend.auth.register');
    }

    /**
     * Posting register form data
     * @param  RegisterRequest $request
     * @return view
     */
    public function postRegister(RegisterRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $imageName = $this->imageUpload(self::UPLOAD_KEY, $request->file('image'));
            $data['image'] = $imageName;
        }
        $user = User::create($data);
        if ($user) {
            Session::flash('flash_success', trans('messages.register_success'));
        } else {
            Session::flash('flash_error', trans('messages.register_fail'));
        }

        return redirect()->route('user.register');
    }
}
