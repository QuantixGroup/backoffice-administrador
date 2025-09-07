<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsuariosNormalesController;

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [UserController::class, 'login'])->name('login.post');

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return view('index');
    })->name('home');

    Route::get('/socios/pendientes', [UsuariosNormalesController::class, 'mostrarPendientes']);
    Route::post('/socios/{cedula}/aprobar', [UsuariosNormalesController::class, 'aprobarPorCedula'])->name('socios.aprobar');
    Route::get('/logout', [UserController::class, 'logout']);
});
