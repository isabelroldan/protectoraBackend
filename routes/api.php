<?php

use App\Http\Controllers\Api\MascotaController;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\SolicitudDeAdopcionController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\VerificarToken;


/* Route::post('login', action: [LoginController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/mascotas/paginadas', [MascotaController::class, 'paginated']);
    Route::get('/usuarios/paginados', [UsuarioController::class, 'paginated']);
    Route::get('/solicitudes/paginadas', [SolicitudDeAdopcionController::class, 'paginated']);

    Route::apiResource('mascotas', MascotaController::class);
    Route::apiResource('usuarios', UsuarioController::class);
    Route::apiResource('solicitudes', SolicitudDeAdopcionController::class);
    Route::get('logout', [LoginController::class, 'logout']);
}); */

Route::post('login', [LoginController::class, 'login']);

// Rutas accesibles solo con autenticación
Route::middleware(['auth:sanctum'])->group(function () {

    // ✅ Rutas accesibles por cualquier usuario autenticado
    Route::get('/mascotas/paginadas', [MascotaController::class, 'paginated']);
    Route::get('/solicitudes/paginadas', [SolicitudDeAdopcionController::class, 'paginated']);
    Route::apiResource('mascotas', MascotaController::class);
    Route::apiResource('solicitudes', SolicitudDeAdopcionController::class);
    Route::get('logout', [LoginController::class, 'logout']);
    Route::get('/mis-solicitudes', [SolicitudDeAdopcionController::class, 'misSolicitudes']);


    // ✅ Rutas protegidas para usuarios con rol 'admin'
    Route::middleware(['rol:admin'])->group(function () {
        Route::get('/usuarios/paginados', [UsuarioController::class, 'paginated']);
        Route::apiResource('usuarios', UsuarioController::class);

    });

    Route::apiResource('usuarios', UsuarioController::class);
});