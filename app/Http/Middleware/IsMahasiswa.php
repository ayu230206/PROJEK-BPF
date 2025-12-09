<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsMahasiswa
{
    public function handle($request, Closure $next)
    {

        if (!Auth::check() || Auth::user()->role !== 'mahasiswa') {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
