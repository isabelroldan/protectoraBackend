<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerificarToken
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->header('Authorization')) {
            return response()->json(['error' => 'Token no proporcionado'], 401);
        }

        if ($request->header('Authorization') !== 'mi-token-secreto') {
            return response()->json(['error' => 'Token inválido'], 403);
        }

        return $next($request);
    }
}

