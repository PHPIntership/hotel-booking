<?php

namespace HotelBooking\Http\Middleware;

use Closure;
use Auth;

class AuthenticateAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      if (!Auth::admin()->check()) {
          return redirect()->route('admin.login');
      }
      return $next($request);
    }
}
