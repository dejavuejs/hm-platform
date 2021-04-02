<?php

namespace Orca\Audience\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAudience
{
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @param  string|null  $guard
    * @return mixed
    */
    public function handle($request, Closure $next, $guard = 'audience')
    {
        if (! Auth::guard($guard)->check()) {
            return redirect()->route('audience.session.index');
        } else {
            if (Auth::guard($guard)->user()->status == 0) {
                Auth::guard($guard)->logout();

                session()->flash('warning', trans('site::app.audience.login-form.not-activated'));
                return redirect()->route('audience.session.index');
            }
        }

        return $next($request);
    }
}
