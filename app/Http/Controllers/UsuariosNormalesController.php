<?php

namespace App\Http\Controllers;

use App\Models\Socio;
use App\Models\UsuariosNormales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsuariosNormalesController extends Controller
{
    public function mostrarPendientes()
    {
        $sociosPendientes = Socio::where('estado', 'pendiente')->get();

        return view('socios', compact('sociosPendientes'));
    }

    public function aprobarPorCedula(string $cedula, ?Request $request = null)
    {
        $socioEncontrado = Socio::where('cedula', $cedula)
            ->where('estado', 'pendiente')
            ->first();

        if ($socioEncontrado === null) {
            if ($request && $request->expectsJson()) {
                return response()->json(['error' => 'Socio no encontrado o ya aprobado'], 404);
            }

            return back()->with('error', 'Socio no encontrado o ya aprobado');
        }

        $usuarioExistente = UsuariosNormales::where('cedula', $socioEncontrado->cedula)->first();
        $appUserId = null;

        if ($usuarioExistente === null) {
            $nuevoUsuario = new UsuariosNormales;
            $partesNombre = preg_split('/\s+/', trim($socioEncontrado->nombre));

            $nuevoUsuario->nombre = $partesNombre[0];
            $nuevoUsuario->apellido = trim($socioEncontrado->apellido);
            $nuevoUsuario->cedula = $socioEncontrado->cedula;
            $nuevoUsuario->email = $socioEncontrado->email;
            $nuevoUsuario->password = Hash::make($socioEncontrado->contraseña ?: $socioEncontrado->cedula);
            $nuevoUsuario->save();
            $appUserId = $nuevoUsuario->id;
        } else {
            $appUserId = $usuarioExistente->id;
        }

        try {
            $existingClient = DB::table('oauth_clients')
                ->where('user_id', $appUserId)
                ->where('password_client', 1)
                ->where('revoked', 0)
                ->first();

            if (! $existingClient) {
                $secret = Str::random(40);
                $now = now();
                $clientId = DB::table('oauth_clients')->insertGetId([
                    'user_id' => $appUserId,
                    'name' => 'Socio '.$socioEncontrado->cedula,
                    'secret' => $secret,
                    'provider' => 'users',
                    'redirect' => 'http://localhost',
                    'personal_access_client' => 0,
                    'password_client' => 1,
                    'revoked' => 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        } catch (\Throwable $e) {
        }

        $socioEncontrado->estado = 'aprobado';
        $socioEncontrado->save();

        if ($request && $request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Socio aprobado y usuario creado.']);
        }

        return redirect()->route('home')->with('ok', 'Socio aprobado y usuario creado.');
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

    public function eliminarPorCedula(string $cedula, ?Request $request = null)
    {
        try {
            $result = Socio::eliminarPorCedula($cedula);
        } catch (\Throwable $e) {
            if ($request && $request->expectsJson()) {
                return response()->json(['error' => 'Error al eliminar usuario'], 500);
            }

            return back()->with('error', 'Error al eliminar usuario');
        }

        if (! $result) {
            if ($request && $request->expectsJson()) {
                return response()->json(['error' => 'Solo se pueden eliminar socios aprobados'], 400);
            }

            return back()->with('error', 'Solo se pueden eliminar socios aprobados');
        }

        if ($request && $request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('socios.aprobados')->with('ok', 'Usuario eliminado correctamente');
    }
}
