<?php

namespace HotelBooking\Http\Middleware\Hotel;

use Closure;
use Auth;

/**
 * Middleware class to make sure a hotel admin is loged in before manage things.
 */
class Authenticate
{
    /**
     * Authenticated admin hotel model.
     */
    protected $auth;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->auth = Auth::hotel();
    }

    /**
     * Check if the hotel admin is not loged in then redirect them to login page.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->auth->check()) {
            return redirect()->guest(route('hotel.login'));
        }

        return $next($request);
    }
}
