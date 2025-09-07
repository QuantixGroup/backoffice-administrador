<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Socio;
use App\Models\UsuariosNormales;
use Illuminate\Support\Facades\Hash;

class AprobarSocioTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }
    private function admin(): User
    {
        return User::create([
            'cedula' => '99999999',
            'name' => 'Admin',
            'apellido' => 'Prueba',
            'telefono' => '099000000',
            'direccion' => 'Admin 123',
            'email' => 'a@a',
            'password' => Hash::make('x'),
            'fecha_ingreso' => now()->toDateString(),
        ]);
    }

    private function socioPendiente(): Socio
    {
        return Socio::create([
            'cedula' => '11112222',
            'nombre' => 'Juana',
            'apellido' => 'Pérez',
            'fecha_nacimiento' => '1990-05-15',
            'telefono' => '099876543',
            'direccion' => 'Av. Siempre Viva 456',
            'departamento' => 'Montevideo',
            'ciudad' => 'Montevideo',
            'email' => 'juana@example.com',
            'contraseña' => 'clave123',   
            'ingreso_mensual' => 50000.00,
            'situacion_laboral' => 'Empleado/a',
            'estado' => 'pendiente',
            'integrantes_familiares' => '2',         
        ]);
    }


        public function test_aprobar_inexistente_redirige_con_error(): void
    {
        $admin = $this->admin();
        $this->actingAs($admin);

        $resp = $this->post(route('socios.aprobar','00000000'));
        $resp->assertStatus(302);
        $resp->assertSessionHas('error'); 
    }
    public function test_aprobar_socio_pendiente_exitoso(): void
    {
        $admin = $this->admin();
        $socio = $this->socioPendiente();
        $this->actingAs($admin);

        $resp = $this->post(route('socios.aprobar',$socio->cedula));
        $resp->assertStatus(302);
        $resp->assertSessionHas('success'); 

        $this->assertDatabaseHas('socios', [
            'cedula' => $socio->cedula,
            'estado' => 'aprobado',
        ]);

        $this->assertDatabaseHas('usuarios_normales', [
            'cedula' => $socio->cedula,
            'email' => $socio->email,
        ]);
    }
}
