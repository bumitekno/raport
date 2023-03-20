<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (Auth::guard('admin')->check()) {
            return redirect('/dashboard');
        } else if (Auth::guard('user')->check()) {
            return redirect('/dashboard');
        } else if (Auth::guard('parent')->check()) {
            return redirect('/dashboard');
        } else if (Auth::guard('teacher')->check()) {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
