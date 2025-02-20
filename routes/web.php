<?php

use App\Http\Controllers\MascotaController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SolicitudDeAdopcionController;

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', [MascotaController::class, 'index'])->name('mascota.index');
Route::get('/show/{id}', [MascotaController::class, 'show'])->name('mascota.show');
Route::get('/create', [MascotaController::class, 'showCreateView'])->name('mascota.showCreateView');
Route::post('/create', [MascotaController::class, 'store'])->name('mascota.create');
Route::get('/update/{id}', [MascotaController::class, 'showUpdateView'])->name('mascota.showUpdateView');
Route::post('/update/{id}', [MascotaController::class, 'update'])->name('mascota.update');
Route::delete('/delete/{id}', [MascotaController::class, 'delete'])->name('mascota.delete');

Route::get('/usuario', [UsuarioController::class, 'index'])->name('usuario.index');
Route::get('/usuario/show/{id}', [UsuarioController::class, 'show'])->name('usuario.show');
Route::get('/usuario/create', [UsuarioController::class, 'showCreateView'])->name('usuario.showCreateView');
Route::post('/usuario/create', [UsuarioController::class, 'store'])->name('usuario.create');
Route::get('/usuario/update/{id}', [UsuarioController::class, 'showUpdateView'])->name('usuario.showUpdateView');
Route::post('/usuario/update/{id}', [UsuarioController::class, 'update'])->name('usuario.update');
Route::delete('/usuario/delete/{id}', [UsuarioController::class, 'delete'])->name('usuario.delete');

Route::get('/solicitudes', [SolicitudDeAdopcionController::class, 'index'])->name('solicitud.index');
Route::get('/solicitudes/show/{id}', [SolicitudDeAdopcionController::class, 'show'])->name('solicitud.show');
Route::get('/solicitudes/create', [SolicitudDeAdopcionController::class, 'showCreateView'])->name('solicitud.showCreateView');
Route::post('/solicitudes/create', [SolicitudDeAdopcionController::class, 'store'])->name('solicitud.create');
Route::get('/solicitudes/update/{id}', [SolicitudDeAdopcionController::class, 'showUpdateView'])->name('solicitud.showUpdateView');
Route::post('/solicitudes/update/{id}', [SolicitudDeAdopcionController::class, 'update'])->name('solicitud.update');
Route::delete('/solicitudes/delete/{id}', [SolicitudDeAdopcionController::class, 'delete'])->name('solicitud.delete');
