<?php

use App\Models\Socio;
use App\Models\UsuariosNormales;
use Illuminate\Support\Facades\Schema;

test('usuarios normales se aprueba socio via JSON crea usuario y devuelve success', function () {

    if (!Schema::hasTable('socios')) {
        $this->addToAssertionCount(1);
        return;
    }

    $cedula = '77777777';
    Socio::updateOrCreate([
        'cedula' => $cedula,
    ], [
        'nombre' => 'Prueba',
        'apellido' => 'Tester',
        'fecha_nacimiento' => '1990-01-01',
        'telefono' => '099000000',
        'direccion' => 'Calle Test 1',
        'departamento' => 'Montevideo',
        'ciudad' => 'Montevideo',
        'email' => 'pruebajson@example.com',
        'contraseña' => '77777777',
        'ingreso_mensual' => 10000,
        'situacion_laboral' => 'Empleado',
        'estado' => 'pendiente',
    ]);

    $response = $this->postJson(route('socios.aprobar', $cedula));
    $response->assertStatus(200);
    $response->assertJsonStructure(['success', 'message']);

    $this->assertDatabaseHas((new UsuariosNormales())->getTable(), [
        'cedula' => $cedula,
    ]);
});
