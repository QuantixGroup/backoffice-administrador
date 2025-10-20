<?php

namespace Tests\Feature;

use Tests\TestCase;

class BackofficeAuthTest extends TestCase
{
    public function test_redirige_a_login_si_no_hay_sesion(): void
    {
        $response = $this->get('/socios/aprobados');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
}
