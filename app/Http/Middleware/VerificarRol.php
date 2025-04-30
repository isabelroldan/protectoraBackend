<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarRol
{
    public function handle(Request $request, Closure $next, string $rol): Response
    {
        if (!$request->user() || $request->user()->rol !== $rol) {
            return response()->json(['message' => 'No autorizado. Se requiere rol: ' . $rol], 403);
        }

        return $next($request);
    }
}
