<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAccessMiddleware
{
    class AdminAccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        if (! auth()->user()->is_admin) {
            auth()->logout();
            return redirect()->route('home')
                ->with('error', 'Anda Bukan Admin');
        }

        return $next($request);
    }
}

}
