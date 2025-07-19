<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocioController;

Route::get('/', [SocioController::class, 'Index']);
Route::post('/socio', [SocioController::class, 'Insertar']);