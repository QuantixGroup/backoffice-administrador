<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

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

            if ($user instanceof User) {
                $user->fill([
                    'name' => $request->nombre,
                    'apellido' => $request->apellido,
                    'email' => $request->email,
                    'telefono' => $request->telefono,
                    'fecha_nacimiento' => $request->fecha_nacimiento,
                ]);
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
                $imagePath = $request->file('profile_image')->store('profile_images', 'public');

                $oldImage = $user->profile_image;

                $user->profile_image = $imagePath;
                $user->save();

                if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Imagen de perfil actualizada correctamente',
                    'image_url' => asset('storage/' . $imagePath)
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

    public function showProfile()
    {
        $user = Auth::user();
        $profileImageUrl = $user->profile_image ? asset('storage/' . $user->profile_image) : asset('img/admin-profile.jpg');

        return view('perfil', [
            'user' => $user,
            'profileImageUrl' => $profileImageUrl
        ]);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8',
            'confirm_new_password' => 'required|string|same:new_password',
        ], [
            'current_password.required' => 'La contraseña actual es obligatoria',
            'new_password.required' => 'La nueva contraseña es obligatoria',
            'new_password.min' => 'La nueva contraseña debe tener al menos 8 caracteres',
            'confirm_new_password.required' => 'Debes confirmar la nueva contraseña',
            'confirm_new_password.same' => 'Las contraseñas no coinciden',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = Auth::user();

            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'La contraseña actual es incorrecta'
                ], 401);
            }

            $user->password = Hash::make($request->new_password);

            if (isset($user->must_change_password)) {
                $user->must_change_password = false;
            }

            $user->save();

            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'message' => 'Contraseña actualizada correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar la contraseña: ' . $e->getMessage()
            ], 500);
        }
    }
}
