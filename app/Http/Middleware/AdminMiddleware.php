<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- Se agrega este use

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica si el usuario está autenticado y si es administrador
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Si es cliente, lo redirige al inicio
        return redirect('/')->with('error', 'No tienes permisos de administrador.');
    }
}
