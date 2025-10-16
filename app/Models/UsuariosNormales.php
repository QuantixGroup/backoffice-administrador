<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsuariosNormales extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'apellido',
        'cedula',
        'email',
        'password',
    ];
}
