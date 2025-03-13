<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HandleFreshInstallationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (DB::table('users')->count() === 0 && ! app()->runningInConsole() && ! app()->runningUnitTests()) {
            // redirect to register page
            return redirect()->intended(route('register', absolute: false));
        }

        return $next($request);
    }
}
