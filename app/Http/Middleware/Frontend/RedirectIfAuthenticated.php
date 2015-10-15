<?php

namespace HotelBooking\Http\Middleware\Frontend;

use Closure;
use Auth;
use Route;
use Session;

/**
 * Middleware class to alert user to logged out first if they have signed in.
 */
class RedirectIfAuthenticated
{
    /**
     * Authenticated user model.
     */
    protected $auth;

    /**
     * Middleware constructor.
     */
    public function __construct()
    {
        $this->auth = Auth::user();
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->check()) {
            Session::flash('flash_info', trans('messages.logged_in'));
            return view('layouts.frontend.partials.flash');
        }

        return $next($request);
    }
}
