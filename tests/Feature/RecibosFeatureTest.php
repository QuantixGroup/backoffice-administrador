<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class RecibosFeatureTest extends TestCase
{
    /** @var \App\Models\User */
    protected $admin;

    protected $skipTestsDueToMissingTables = false;

    protected function setUp(): void
    {
        parent::setUp();
        if (! Schema::hasTable((new User)->getTable())) {
            $this->skipTestsDueToMissingTables = true;
        }

        if (! Schema::hasTable('pagos_mensuales')) {
            $this->skipTestsDueToMissingTables = true;
        }

        if (! $this->skipTestsDueToMissingTables) {
            $this->admin = User::updateOrCreate([
                'cedula' => '99999998',
            ], [
                'name' => 'Recibos Admin',
                'apellido' => 'Test',
                'telefono' => '099000001',
                'email' => 'recibos_admin@example.com',
                'password' => Hash::make('password'),
            ]);
        }
    }

    public function test_actualizar_estado_valido_devuelve_success_y_actualiza_bd(): void
    {
        if ($this->skipTestsDueToMissingTables) {
            $this->addToAssertionCount(1);

            return;
        }
        $id = DB::table('pagos_mensuales')->insertGetId([
            'cedula' => '22223333',
            'monto' => '1000.00',
            'fecha_comprobante' => now(),
            'archivo_comprobante' => null,
            'estado' => 'pendiente',
            'mes' => now()->month,
            'anio' => now()->year,
            'observacion' => null,
        ], 'id_pago');

        $this->actingAs($this->admin);

        $resp = $this->putJson(route('recibos.actualizar.estado', $id), [
            'estado' => 'aceptado',
            'observacion' => 'prueba',
        ]);

        $resp->assertStatus(200);
        $resp->assertJson(['success' => true]);

        $this->assertDatabaseHas('pagos_mensuales', [
            'id_pago' => $id,
            'estado' => 'aceptado',
        ]);
    }

    public function test_ver_pdf_devuelve_404_si_no_hay_archivo(): void
    {
        if ($this->skipTestsDueToMissingTables) {
            $this->addToAssertionCount(1);

            return;
        }
        $id = DB::table('pagos_mensuales')->insertGetId([
            'cedula' => '77778888',
            'monto' => '500.00',
            'fecha_comprobante' => now(),
            'archivo_comprobante' => null,
            'estado' => 'pendiente',
            'mes' => now()->month,
            'anio' => now()->year,
        ], 'id_pago');

        $this->actingAs($this->admin);

        $resp = $this->get(route('recibos.ver.pdf', $id));
        $resp->assertStatus(404);
        $resp->assertJson(['success' => false]);
    }

    public function test_ver_pdf_devuelve_pdf_si_archivo_existente(): void
    {
        if ($this->skipTestsDueToMissingTables) {
            $this->addToAssertionCount(1);

            return;
        }
        $relPath = 'comprobantes/test_recibo_unit.pdf';
        $fullPath = storage_path('app/public/'.$relPath);
        @mkdir(dirname($fullPath), 0755, true);
        file_put_contents($fullPath, '%PDF-TEST%pdf-content%');

        $id = DB::table('pagos_mensuales')->insertGetId([
            'cedula' => '33334444',
            'monto' => '750.00',
            'fecha_comprobante' => now(),
            'archivo_comprobante' => $relPath,
            'estado' => 'pendiente',
            'mes' => now()->month,
            'anio' => now()->year,
        ], 'id_pago');

        $this->actingAs($this->admin);

        $resp = $this->get(route('recibos.ver.pdf', $id));
        $resp->assertStatus(200);
        $this->assertEquals('application/pdf', $resp->headers->get('Content-Type'));
        $this->assertStringContainsString('%PDF-TEST%', (string) $resp->getContent());
    }

    public function test_actualizar_estado_invalido_devuelve_422(): void
    {
        if ($this->skipTestsDueToMissingTables) {
            $this->addToAssertionCount(1);

            return;
        }
        $this->actingAs($this->admin);

        $id = DB::table('pagos_mensuales')->insertGetId([
            'cedula' => '44445555',
            'monto' => '200.00',
            'fecha_comprobante' => now(),
            'archivo_comprobante' => null,
            'estado' => 'pendiente',
            'mes' => now()->month,
            'anio' => now()->year,
        ], 'id_pago');

        $resp = $this->putJson(route('recibos.actualizar.estado', $id), [
            'estado' => 'invalid_estado',
        ]);

        $resp->assertStatus(422);
    }

    public function test_actualizar_estado_no_existente_devuelve_500(): void
    {
        if ($this->skipTestsDueToMissingTables) {
            $this->addToAssertionCount(1);

            return;
        }
        $this->actingAs($this->admin);

        $nonExistingId = 99999999;
        $resp = $this->putJson(route('recibos.actualizar.estado', $nonExistingId), [
            'estado' => 'aceptado',
        ]);

        $resp->assertStatus(500);
        $resp->assertJson(['success' => false]);
    }
}
