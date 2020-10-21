<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Admin {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if(Auth::guard('admin')->check()) {
            return $next($request);
        } else {
			$redirect_to = $request->url();
            return redirect('/admin/login?redirect_to='.$redirect_to.'');
        }

        return $next($request);
    }
}
