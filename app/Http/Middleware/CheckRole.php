<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect('/login');
        }

        // Cek apakah role user ada di dalam daftar role yang diizinkan untuk rute ini
        if (!in_array(auth()->user()->role, $roles)) {
            // Jika tidak, lemparkan error 403 (akan otomatis memanggil resources/views/errors/403.blade.php)
            abort(403);
        }

        return $next($request);
    }
}
