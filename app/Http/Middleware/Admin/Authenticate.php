<?php

namespace HotelBooking\Http\Middleware\Admin;

use Closure;
use Auth;

class Authenticate
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
          return redirect()->guest(route('admin.login'));
      }
      return $next($request);
    }
}
