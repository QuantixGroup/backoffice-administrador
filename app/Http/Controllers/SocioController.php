<?php

namespace App\Http\Controllers;
use App\Models\Socio;

use Illuminate\Http\Request;

class SocioController extends Controller
{
    public function Index()
    {
        $socios = Socio::all();
        return view("index", ["socios" => $socios]);
    }

    public function Insertar(Request $request)
    {
        $socio = new Socio();
        $socio->cedula = $request->post("cedula");
        $socio->nombre = $request->post("nombre");
        $socio->apellido = $request->post("apellido");
        $socio->telefono = $request->post("telefono");
        $socio->direccion = $request->post("direccion");
        $socio->email = $request->post("email");
        $socio->contraseña = $request->post("contraseña");
        $socio->IngresoMensual = $request->post("IngresoMensual");
        $socio->profesion = $request->post("profesion");
        $socio->estado = $request->post("estado");
        $socio->IntegrantesFamiliares = $request->post("IntegrantesFamiliares");
        $socio->FechaIngreso = $request->post("FechaIngreso");
        $socio->FechaEgreso = $request->post("FechaEgreso");
        $socio->save();

        return redirect("/")->with("socioAgregado", true);
    }
}
