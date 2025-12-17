<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckLogin
{
    /**
     * Handle an incoming request.
     * Pastikan user sudah memilih role sebelum lanjut.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('role')) {
            return redirect()->route('pilih-role');
        }

        return $next($request);
    }
}
