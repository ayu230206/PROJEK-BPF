<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- TAMBAHKAN BARIS INI!

class IsBpdpks
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Baris 19 yang menyebabkan error kini akan berfungsi:
        if (!Auth::check() || Auth::user()->role !== 'bpdpks') {
            abort(403, 'Akses ditolak. Anda bukan BPDPKS.');
        }

        return $next($request);
    }
}
