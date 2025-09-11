<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginPorCedulaTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }
    private function crearAdmin(): User
    {
        return User::create([
            'cedula' => '12345678',
            'name' => 'Admin Demo',
            'apellido' => 'Prueba',
            'telefono' => '099123456',
            'direccion' => 'Calle Falsa 123',
            'email' => 'admin@demo.test',
            'password' => Hash::make('secreto'),
            'fecha_ingreso' => now()->toDateString(),
        ]);
    }

    public function test_login_ok_redirige_a_home_y_autentica(): void
    {
        $admin = $this->crearAdmin();

        $response = $this->post(route('login.post'), [
            'cedula' => '12345678',
            'password' => 'secreto',
        ]);

        $response->assertStatus(302);
        $response->assertRedirectToRoute('home');
        $this->assertAuthenticatedAs($admin);
    }



}
