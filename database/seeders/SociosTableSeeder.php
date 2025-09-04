<?php

namespace Database\Seeders;

use App\Models\Socio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SociosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Socio::create([
            'cedula' => '11112222',
            'nombre' => 'Juana',
            'apellido' => 'Pérez',
            'email' => 'juana@example.com',
            'contraseña' => 'clave123',  
            'telefono' => '0998765432',
            'direccion' => 'Av. Siempre Viva 456',
            'departamento' => 'Montevideo',
            'ciudad' => 'Montevideo',
            'ingreso_mensual' => 50000,
            'situacion_laboral' => 'Empleado/a',
            'fecha_nacimiento' => '1990-05-15',
            'estado' => 'pendiente'
        ]);
    }
}
