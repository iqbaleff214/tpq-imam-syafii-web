<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Santri
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->peran != 'Santri') {
            return redirect()->route('home');
        }

        if (!in_array(Auth::user()->santri->status, ['Aktif', 'Lulus'])) {
            Auth::logout();
        }

        return $next($request);
    }
}
