<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerificarToken
{
    /**
     * Maneja la solicitud entrante y verifica la validez del token de autorización.
     * 
     * Yqa no se usa porque lo cambie por la Autenticacion
     * 
     * @param  \Illuminate\Http\Request  $request  La solicitud HTTP entrante.
     * @param  \Closure  $next  La siguiente acción en la cadena de middleware.
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el encabezado 'Authorization' está presente en la solicitud
        if (!$request->header('Authorization')) {
            return response()->json(['error' => 'Token no proporcionado'], 401);
        }

        // Comprobar si el token proporcionado es válido
        if ($request->header('Authorization') !== 'token-validacion') {
            return response()->json(['error' => 'Token inválido'], 403);
        }

        // Permitir que la solicitud continúe hacia la siguiente capa de la aplicación
        return $next($request);
    }
}

