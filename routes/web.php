<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsuariosNormalesController;
use App\Http\Controllers\RecibosController;
use App\Models\Socio;

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [UserController::class, 'login'])->name('login.post');

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        $sociosPendientes = Socio::where('estado', 'pendiente')->get();
        return view('inicio', compact('sociosPendientes'));
    })->name('home');

    Route::get('/perfil', [UserController::class, 'showProfile'])->name('perfil');

    Route::post('/perfil/update', [UserController::class, 'updateProfile'])->name('perfil.update');
    Route::post('/perfil/upload-image', [UserController::class, 'uploadProfileImage'])->name('perfil.upload-image');

    Route::get('/socios/pendientes', function () {
        $sociosAprobados = Socio::where('estado', 'aprobado')->get();
        return view('listado-cooperativistas', compact('sociosAprobados'));
    })->name('socios.pendientes');

    Route::get('/socios/{cedula}/detalle', [UsuariosNormalesController::class, 'mostrarDetalle'])->name('socios.detalle');
    Route::post('/socios/{cedula}/aprobar', [UsuariosNormalesController::class, 'aprobarPorCedula'])->name('socios.aprobar');
    Route::post('/socios/{cedula}/rechazar', [UsuariosNormalesController::class, 'rechazarPorCedula'])->name('socios.rechazar');

    Route::get('/recibos', [RecibosController::class, 'index'])->name('recibos.pagos');
    Route::get('/recibos/detalle', [RecibosController::class, 'detalle'])->name('recibos.detalle');

    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
});
