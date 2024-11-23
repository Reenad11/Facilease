<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        if (!auth()->guard($guards[0])->check() && $request->segment(1) == 'admin') {
            return redirect()->route('auth.login');
        }
        if (!auth()->guard($guards[0])->check() && $request->segment(1) == 'student') {
            return redirect()->route('auth.login');
        }
        if (!auth()->guard($guards[0])->check() && $request->segment(1) == 'faculty') {
            return redirect()->route('auth.login');
        }
        return $next($request);
    }
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('main_admin.login');
        }
    }
}
