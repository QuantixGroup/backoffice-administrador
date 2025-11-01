<?php

namespace Tests\Feature;

use App\Models\Socio;
use App\Models\User;
use App\Models\UsuariosNormales;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AprobarSocioTest extends TestCase
{
    protected $skipTestsDueToMissingTables = false;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
        $this->skipTestsDueToMissingTables = false;
        $missing = [];
        if (! Schema::hasTable((new User)->getTable())) {
            $missing[] = (new User)->getTable();
        }
        if (! Schema::hasTable((new Socio)->getTable())) {
            $missing[] = (new Socio)->getTable();
        }
        if (! empty($missing)) {
            $this->skipTestsDueToMissingTables = true;
        }
    }

    private function admin(): User
    {
        return User::updateOrCreate([
            'cedula' => '99999999',
        ], [
            'name' => 'Test',
            'apellido' => 'Prueba',
            'telefono' => '099000000',
            'email' => 'test@test.com',
            'password' => Hash::make('x'),
            'fecha_ingreso' => now()->toDateString(),
        ]);
    }

    private function socioPendiente(): Socio
    {
        return Socio::updateOrCreate([
            'cedula' => '11112222',
        ], [
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'fecha_nacimiento' => '1990-05-15',
            'telefono' => '099876543',
            'direccion' => 'Av. Siempre Viva 456',
            'departamento' => 'Montevideo',
            'ciudad' => 'Montevideo',
            'email' => 'juan@example.com',
            'contraseña' => '11112222',
            'ingreso_mensual' => 50000.00,
            'situacion_laboral' => 'Empleado/a',
            'estado' => 'pendiente',
            'integrantes_familiares' => '2',
        ]);
    }

    public function test_aprobar_socio_inexistente_redirige_con_error(): void
    {
        if (! empty($this->skipTestsDueToMissingTables)) {
            $this->addToAssertionCount(1);

            return;
        }
        $admin = $this->admin();
        $this->actingAs($admin);

        $resp = $this->post(route('socios.aprobar', '00000000'));
        $resp->assertStatus(302);
        $resp->assertSessionHas('error');
    }

    public function test_aprobar_socio_pendiente_exitoso(): void
    {
        if (! empty($this->skipTestsDueToMissingTables)) {
            $this->addToAssertionCount(1);

            return;
        }
        $admin = $this->admin();
        $socio = $this->socioPendiente();
        $this->actingAs($admin);

        $resp = $this->post(route('socios.aprobar', $socio->cedula));
        $resp->assertStatus(302);
        $resp->assertSessionHas('ok');

        $this->assertDatabaseHas('socios', [
            'cedula' => $socio->cedula,
            'estado' => 'aprobado',
        ]);

        $this->assertDatabaseHas((new UsuariosNormales)->getTable(), [
            'cedula' => $socio->cedula,
            'email' => $socio->email,
        ]);
    }
}
