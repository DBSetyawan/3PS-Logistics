<?php

namespace warehouse\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    //optional
    public function handle($request, Closure $next, $guard = null)
    {
        // if (Auth::guard($guard)->check()) {
        //     if ($request->ajax()) {
        //         # code...
        //         return response('Unauthorized',401);
        //     } else {
        //         # code...
        //         // return redirect()->to('/dashboard');
                
        //     return $next($request);

        //     }
    
        // }   
     
        // if (Auth::guard($guard)->check()):
        if (Auth::check()):
            return redirect()->route('dashboard');
        endif;

        return $next($request);

    }
    
}
