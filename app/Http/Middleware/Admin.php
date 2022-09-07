<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
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
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'sub-admin' || Auth::user()->type == 'user') {
            return $next($request);
        } else {
            return redirect(route('dashboard'));
        }
    }
}
