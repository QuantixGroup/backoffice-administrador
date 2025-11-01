<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $name
 * @property string $apellido
 * @property string $cedula
 * @property string $email
 * @property string $telefono
 * @property string $direccion
 * @property string $fecha_nacimiento
 * @property string $fecha_ingreso
 * @property string $fecha_egreso
 * @property string|null $profile_image
 * @property string $password
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admins';

    protected $fillable = [
        'name',
        'cedula',
        'email',
        'password',
        'apellido',
        'telefono',
        'direccion',
        'fecha_ingreso',
        'fecha_egreso',
        'fecha_nacimiento',
        'profile_image',
        'primer_password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'primer_password' => 'boolean',
        ];
    }

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
}
