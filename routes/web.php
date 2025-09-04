<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsuariosNormalesController;

Route::get('/login', function () {
    return view('login');
});

Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('/socios/pendientes', [UsuariosNormalesController::class, 'mostrarPendientes']);
    Route::post('/socios/{cedula}/aprobar', [UsuariosNormalesController::class, 'aprobarPorCedula']);
    Route::get('/logout', [UserController::class, 'logout']);
});
