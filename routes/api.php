<?php

use App\Http\Controllers\Api\MascotaController;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\SolicitudDeAdopcionController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\VerificarToken;


Route::post('login', action: [LoginController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/mascotas/paginadas', [MascotaController::class, 'paginated']);
    Route::get('/usuarios/paginados', [UsuarioController::class, 'paginated']);
    Route::get('/solicitudes/paginadas', [SolicitudDeAdopcionController::class, 'paginated']);

    Route::apiResource('mascotas', MascotaController::class);
    Route::apiResource('usuarios', UsuarioController::class);
    Route::apiResource('solicitudes', SolicitudDeAdopcionController::class);
    Route::get('logout', [LoginController::class, 'logout']);
});