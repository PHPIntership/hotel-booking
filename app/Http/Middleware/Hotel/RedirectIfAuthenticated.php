<?php

namespace HotelBooking\Http\Middleware\Hotel;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth;
use Route;

/**
 * Middleware class to redirect hotel admin out of login page if they have signed in
 */
class RedirectIfAuthenticated
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param Guard $auth
     */
    public function __construct()
    {
        $this->auth = Auth::hotel();
    }

    /**
     * Check if a hotel admin have logged in then redirect them to index page
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->check()) {
            if (Route::has('hotel.index')) {
                return redirect(route('hotel.index'));
            } else {
                return 'this hotel admin already log in';
            }
        }

        return $next($request);
    }
}
