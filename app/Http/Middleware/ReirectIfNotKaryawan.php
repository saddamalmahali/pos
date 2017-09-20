<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class ReirectIfNotKaryawan
{
    public function handle($request, Closure $next, $guard = 'karyawan')
    {
        if (!Auth::guard($guard)->check()) {
            return redirect('/');
        }   
        
        return $next($request);
    }
}
