<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credenciales = $request->only(['cedula', 'password']);

        if (Auth::attempt($credenciales)) {
            return redirect()->route('home');
        } else {
            return redirect('/login')->with(['error' => 'Credenciales incorrectas']);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'required|string|max:20',
            'fecha_nacimiento' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos de validación incorrectos',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = Auth::user();

            if ($user instanceof \App\Models\User) {
                $user->name = $request->nombre;
                $user->apellido = $request->apellido;
                $user->email = $request->email;
                $user->telefono = $request->telefono;
                $user->fecha_nacimiento = $request->fecha_nacimiento;
                $user->save();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado o no autenticado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Perfil actualizado correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el perfil: ' . $e->getMessage()
            ], 500);
        }
    }

    public function uploadProfileImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'El archivo debe ser una imagen válida (JPG, PNG, GIF) de máximo 2MB'
            ], 422);
        }

        try {
            $user = User::find(Auth::id());

            if ($request->hasFile('profile_image')) {
                if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                    Storage::disk('public')->delete($user->profile_image);
                }
                $imagePath = $request->file('profile_image')->store('profile_images', 'public');
                $user->profile_image = $imagePath;
                $user->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Imagen de perfil actualizada correctamente',
                    'image_url' => Storage::url($imagePath)
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No se recibió ninguna imagen'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al subir la imagen: ' . $e->getMessage()
            ], 500);
        }
    }
}
