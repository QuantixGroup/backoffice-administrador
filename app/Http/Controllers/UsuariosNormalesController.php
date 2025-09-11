<?php

namespace App\Http\Controllers;

use App\Models\Socio;
use Illuminate\Database\Eloquent\Model;
use App\Models\UsuariosNormales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UsuariosNormalesController extends Controller
{

    public function mostrarPendientes()
    {
        $sociosPendientes = Socio::where('estado', 'pendiente')->get();
        return view('socios', compact('sociosPendientes'));
    }

    public function aprobarPorCedula(string $cedula, Request $request)
    {
        $socioEncontrado = Socio::where('cedula', $cedula)
            ->where('estado', 'pendiente')
            ->first();

        if ($socioEncontrado === null) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Socio no encontrado o ya aprobado'], 404);
            }
            return redirect()->route('home')->with('error', 'Socio no encontrado o ya aprobado');
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

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Usuario aceptado con éxito',
                'socio' => [
                    'nombre' => $socioEncontrado->nombre,
                    'apellido' => $socioEncontrado->apellido,
                    'cedula' => $socioEncontrado->cedula,
                    'telefono' => $socioEncontrado->telefono,
                    'email' => $socioEncontrado->email,
                    'estado_pago_badge' => $socioEncontrado->estado_pago_badge,
                    'horas_trabajadas_badge' => $socioEncontrado->horas_trabajadas_badge,
                    'updated_at' => $socioEncontrado->updated_at->format('d/m/Y H:i')
                ]
            ]);
        }

        return redirect()->route('home')->with('ok', 'Usuario aceptado con éxito');
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
