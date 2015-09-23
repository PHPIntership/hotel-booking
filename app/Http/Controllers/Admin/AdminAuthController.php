<?php

namespace HotelBooking\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use HotelBooking\Http\Requests;
use HotelBooking\Http\Controllers\Controller;
use HotelBooking\Http\Requests\Admin\AdminLoginRequest;

class AdminAuthController extends Controller
{

    public function index(){
      return "View index admin";
    }

    public function getLoginAdmin()
    {
      if(Auth::admin()->check())
      {
            return redirect()->route('admin.index');
      }
      return view('admin.login');
    }

    public function postLoginAdmin(AdminLoginRequest $request)
    {
      if(Auth::admin()->check())
      {
            return redirect()->route('admin.login');
      }
      if(Auth::admin()->attempt($request->only('username','password'),$request->has('remember')))
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

    public function getAdminLogout()
    {
      Auth::admin()->logout();
      return redirect()->route('admin.login');
    }
}
