<?php

namespace HotelBooking\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use HotelBooking\Http\Requests;
use HotelBooking\Http\Controllers\Controller;

class AdminAuthController extends Controller
{

    public function index(){
      return "View index admin";
    }

    public function indexLogin()
    {
      if(Auth::admin()->check())
      {
            return redirect()->route('admin.index');
      }
      return view('admin.login');
    }

    public function adminLogin(Request $request)
    {
      $username = $request['username'];
      $password = $request['password'];
      $remember = $request['remember'];
      Auth::admin()->attempt(['username' => $username, 'password' => $password],$remember);
      return Auth::admin()->get()->username;
    }

    public function adminLogout()
    {
      Auth::admin()->logout();
      return "logout";
    }

    public function adminRegister()
    {
      return "Admin Register-";
    }
}
