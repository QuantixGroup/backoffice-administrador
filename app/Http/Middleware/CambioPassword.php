<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CambioPassword
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && isset($user->primer_password) && $user->primer_password) {
            $allowed = [
                route('perfil.cambiar-password.form'),
                route('perfil.cambiar-password'),
                route('logout'),
            ];

            if (! in_array($request->url(), $allowed)) {
                return redirect()->route('perfil.cambiar-password.form');
            }
        }

        return $next($request);
    }
}
