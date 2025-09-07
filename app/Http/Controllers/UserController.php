<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
