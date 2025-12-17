<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPemerintahProfile
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('pilih-role');
        }

        if (Auth::user()->role === 'pemerintah') {
            $user = Auth::user();
            if (!$user->pemerintahProfile) {
                return redirect()->route('pemerintah.register.form')
                    ->with('warning', 'Silakan lengkapi profil pemerintah terlebih dahulu.');
            }
        }

        return $next($request);
    }
}
