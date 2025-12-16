<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WargaMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Hanya berlaku untuk user dengan role 'warga'
        if ($user->role === 'warga') {
            // List route yang diizinkan untuk warga
            $allowedRoutes = [
                'dashboard',
                'profile.index',
                'profile.avatar.update',
                'profile.avatar.delete',
                'profile.update',
                'logout'
            ];
            
            $currentRoute = $request->route()->getName();
            
            // Jika route tidak diizinkan, return 403 Forbidden
            if ($currentRoute && !in_array($currentRoute, $allowedRoutes)) {
                abort(403, 'Akses ditolak. Sebagai warga, Anda hanya dapat mengakses dashboard dan profil.');
            }
        }
        
        // Lanjutkan request
        return $next($request);
    }
}