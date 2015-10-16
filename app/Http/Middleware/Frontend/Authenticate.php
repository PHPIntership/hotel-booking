<?php

namespace HotelBooking\Http\Middleware\Frontend;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth;
use Route;

/**
 * Authenticate middleware to check user must logged in to do things
 */
class Authenticate
{
    /**
     * Authenticated user model.
     */
    protected $auth;
    /**
     * Middleware Constructor
     */
    public function __construct()
    {
        $this->auth = Auth::user();
    }
    
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->auth->check()) {
            return redirect()->guest(route('user.index'));
        }

        return $next($request);
    }
}
