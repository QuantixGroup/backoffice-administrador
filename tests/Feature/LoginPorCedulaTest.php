<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;              
use Illuminate\Support\Facades\Hash;

class LoginPorCedulaTest extends TestCase
{
    public function test_login_por_cedula_ok(): void
    {
        User::create([
            'cedula'    => '12345678',
            'name'      => 'Admin Demo',
            'apellido'  => 'Prueba',
            'telefono'  => '099123456',
            'direccion' => 'Calle Falsa 123',
            'email'     => 'admin@demo.test',
            'password'  => Hash::make('secreto'),
        ]);

        $resp = $this->post('/login', [
            'cedula'   => '12345678',
            'password' => 'secreto',
        ]);

        $resp->assertStatus(302);
        $resp->assertRedirect('/');
        $this->assertAuthenticated();
    }

    public function test_login_por_cedula_falla(): void
    {
        User::create([
            'cedula'    => '12345678',
            'name'      => 'Admin Demo',
            'apellido'  => 'Prueba',
            'telefono'  => '099123456',
            'direccion' => 'Calle Falsa 123',
            'email'     => 'admin@demo.test',
            'password'  => Hash::make('secreto'),
        ]);

        $resp = $this->post('/login', [
            'cedula'   => '12345678',
            'password' => 'mal',
        ]);

        $resp->assertStatus(302);
        $resp->assertRedirect('/login');
        $this->assertGuest();
    }
}
