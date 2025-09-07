<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;              // admins
use App\Models\Socio;             // socios (en api-usuarios)
use App\Models\UsuariosNormales;  // users (usuarios normales)
use Illuminate\Support\Facades\Hash;

class AprobarSocioTest extends TestCase
{
    public function test_aprobar_socio_crea_usuario_y_actualiza_estado(): void
    {
        // admin para poder pasar el middleware
        User::create([
            'cedula'    => '99999999',
            'name'      => 'Admin Test',
            'apellido'  => 'Prueba',
            'telefono'  => '099000000',
            'direccion' => 'Admin 123',
            'email'     => 'adm@test',
            'password'  => Hash::make('clave'),
        ]);

        // socio pendiente (misma estructura que tu seeder)
        Socio::create([
            'cedula'            => '11112222',
            'nombre'            => 'Juana',
            'apellido'          => 'Pérez',
            'email'             => 'juana@example.com',
            'contraseña'        => 'clave123',
            'telefono'          => '0998765432',
            'direccion'         => 'Av. Siempre Viva 456',
            'departamento'      => 'Montevideo',
            'ciudad'            => 'Montevideo',
            'ingreso_mensual'   => 50000,
            'situacion_laboral' => 'Empleado/a',
            'fecha_nacimiento'  => '1990-05-15',
            'estado'            => 'pendiente',
        ]);

        // login admin
        $this->post('/login', ['cedula' => '99999999', 'password' => 'clave']);
        $this->assertAuthenticated();

        // aprobar
        $resp = $this->post('/socios/11112222/aprobar');
        $resp->assertStatus(302);
        $resp->assertRedirect(); // back o /socios/pendientes (lo que tengas)

        $creado = UsuariosNormales::where('cedula', '11112222')->first();
        $this->assertNotNull($creado);
        $this->assertTrue(
            Hash::check('clave123', $creado->password) || Hash::check('11112222', $creado->password)
        );
        $this->assertSame('aprobado', Socio::where('cedula', '11112222')->first()->estado);
    }

    public function test_aprobar_socio_inexistente_da_404(): void
    {
        User::create([
            'cedula'    => '99999999',
            'name'      => 'Admin Test',
            'apellido'  => 'Prueba',
            'telefono'  => '099000000',
            'direccion' => 'Admin 123',
            'email'     => 'adm@test',
            'password'  => Hash::make('clave'),
        ]);

        $this->post('/login', ['cedula' => '99999999', 'password' => 'clave']);
        $this->assertAuthenticated();

        $resp = $this->post('/socios/00000000/aprobar');
        $resp->assertStatus(404);
    }
}
