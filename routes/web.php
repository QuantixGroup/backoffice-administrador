<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocioController;

Route::get('/socios', [SocioController::class, 'vistaSocios']);
