<?php

namespace App\Http\Controllers;

use App\Models\Socio;
use Illuminate\Database\Eloquent\Model;
use App\Models\UsuariosNormales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class UsuariosNormalesController extends Controller
{

    public function mostrarPendientes()
    {
        $sociosPendientes = Socio::where('estado', 'pendiente')->get();
        return view('socios', compact('sociosPendientes'));
    }

    public function aprobarPorCedula(string $cedula)
    {
        $socioEncontrado = Socio::where('cedula', $cedula)
            ->where('estado', 'pendiente')
            ->first();

        if ($socioEncontrado === null) {
            return back()->with('error', 'Socio no encontrado o ya aprobado');
        }

        $usuarioExistente = UsuariosNormales::where('cedula', $socioEncontrado->cedula)->first();

        if ($usuarioExistente === null) {
            $nuevoUsuario = new UsuariosNormales();
            $nuevoUsuario->name = $socioEncontrado->nombre . ' ' . $socioEncontrado->apellido;
            $nuevoUsuario->cedula = $socioEncontrado->cedula;
            $nuevoUsuario->email = $socioEncontrado->email;
            $nuevoUsuario->password = Hash::make($socioEncontrado->contraseña ?: $socioEncontrado->cedula);
            $nuevoUsuario->save();
        }

        $socioEncontrado->estado = 'aprobado';
        $socioEncontrado->save();

        return back()->with('ok', 'Socio aprobado y usuario creado.');
    }

    public function mostrarDetalle(string $cedula)
    {
        $socio = Socio::where('cedula', $cedula)->first();

        if ($socio === null) {
            return redirect()->route('home')->with('error', 'Socio no encontrado');
        }

        return view('socio-detalle', compact('socio'));
    }

    public function rechazarPorCedula(string $cedula)
    {
        $socioEncontrado = Socio::where('cedula', $cedula)
            ->where('estado', 'pendiente')
            ->first();

        if ($socioEncontrado === null) {
            return redirect()->route('home')->with('error', 'Socio no encontrado o ya procesado');
        }

        $socioEncontrado->estado = 'rechazado';
        $socioEncontrado->save();

        return redirect()->route('home')->with('ok', 'Usuario rechazado con éxito');
    }
}
