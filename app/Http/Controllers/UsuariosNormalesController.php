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

    public function aprobarPorCedula(string $cedula, Request $request = null)
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
            $nuevoUsuario = new UsuariosNormales();
            $nuevoUsuario->name = $socioEncontrado->nombre . ' ' . $socioEncontrado->apellido;
            $nuevoUsuario->cedula = $socioEncontrado->cedula;
            $nuevoUsuario->email = $socioEncontrado->email;
            $nuevoUsuario->password = Hash::make($socioEncontrado->contraseña ?: $socioEncontrado->cedula);
            $nuevoUsuario->save();
            $appUserId = $nuevoUsuario->id;
        } else {
            $appUserId = $usuarioExistente->id;
        }

        try {
            if (empty($socioEncontrado->oauth_client_id)) {
                $secret = Str::random(40);
                $now = now();
                $clientId = DB::table('oauth_clients')->insertGetId([
                    'user_id' => $appUserId,
                    'name' => 'Socio ' . $socioEncontrado->cedula,
                    'secret' => $secret,
                    'provider' => 'users',
                    'redirect' => 'http://localhost',
                    'personal_access_client' => 0,
                    'password_client' => 1,
                    'revoked' => 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                $socioEncontrado->oauth_client_id = $clientId;
                $socioEncontrado->oauth_client_secret = $secret;
            }
        } catch (\Throwable $e) {
            Log::error('Error creando oauth client para socio ' . $socioEncontrado->cedula . ': ' . $e->getMessage());
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
}
