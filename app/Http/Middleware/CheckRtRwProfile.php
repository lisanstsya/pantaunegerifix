<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRtRwProfile
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('pilih-role');
        }

        if (session('role') === 'rt_rw') {

            if (!Auth::user()->rtRwProfile) {
                return redirect()->route('rt-rw.create-profile')
                    ->with('warning', 'Silakan lengkapi data pribadi RT/RW terlebih dahulu.');
            }
        }

        return $next($request);
    }
}
