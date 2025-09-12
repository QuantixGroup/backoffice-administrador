<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate([
            'cedula' => '12345678'
        ], [
            'name' => 'Admin Demo',
            'apellido' => 'Prueba',
            'telefono' => '099123456',
            'direccion' => 'Calle Falsa 123',
            'email' => 'admin@demo.test',
            'fecha_ingreso' => now(),
            'password' => Hash::make('secreto'),
        ]);
    }
}
