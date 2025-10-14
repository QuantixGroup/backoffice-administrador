<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsuariosNormalesController;
use App\Http\Controllers\RecibosController;
use App\Models\Socio;
use App\Services\ApiCooperativistaService;

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [UserController::class, 'login'])->name('login.post');

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        $sociosPendientes = Socio::where('estado', 'pendiente')->get();

        foreach ($sociosPendientes as $socio) {
            try {
                $datos = ApiCooperativistaService::getDatosCooperativista($socio->cedula);

                if (is_array($datos) && !empty($datos)) {
                    $changed = false;

                    if (isset($datos['nombre']) && $datos['nombre'] !== $socio->nombre) {
                        $socio->nombre = $datos['nombre'];
                        $changed = true;
                    }
                    if (isset($datos['apellido']) && $datos['apellido'] !== $socio->apellido) {
                        $socio->apellido = $datos['apellido'];
                        $changed = true;
                    }
                    if (isset($datos['fecha_nacimiento']) && $datos['fecha_nacimiento'] !== $socio->fecha_nacimiento) {
                        $socio->fecha_nacimiento = $datos['fecha_nacimiento'];
                        $changed = true;
                    }
                    if (isset($datos['email']) && $datos['email'] !== $socio->email) {
                        $socio->email = $datos['email'];
                        $changed = true;
                    }
                    if (isset($datos['telefono']) && $datos['telefono'] !== $socio->telefono) {
                        $socio->telefono = $datos['telefono'];
                        $changed = true;
                    }
                    if (isset($datos['departamento']) && $datos['departamento'] !== $socio->departamento) {
                        $socio->departamento = $datos['departamento'];
                        $changed = true;
                    }
                    if (isset($datos['situacion_laboral']) && $datos['situacion_laboral'] !== $socio->situacion_laboral) {
                        $socio->situacion_laboral = $datos['situacion_laboral'];
                        $changed = true;
                    }
                    if (isset($datos['ingresos_mensuales'])) {
                        if ($datos['ingresos_mensuales'] !== $socio->ingreso_mensual) {
                            $socio->ingreso_mensual = $datos['ingresos_mensuales'];
                            $changed = true;
                        }
                    }

                    if ($changed) {
                        $socio->save();
                    }
                }
            } catch (\Exception $e) {
            }
        }

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
    Route::put('/recibos/actualizar-estado/{idPago}', [RecibosController::class, 'actualizarEstado'])->name('recibos.actualizar.estado');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
});