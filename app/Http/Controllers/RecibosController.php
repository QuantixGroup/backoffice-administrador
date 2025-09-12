<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Socio;

class RecibosController extends Controller
{
    public function index()
    {
        $sociosAprobados = Socio::where('estado', 'aprobado')->get();
        return view('recibos-pagos', compact('sociosAprobados'));
    }

    public function detalle(Request $request)
    {
        $recibos = [];
        $cooperativista = null;

        $documento = $request->get('documento');

        if ($documento) {
            $cooperativista = Socio::where('cedula', $documento)->first();
            if ($cooperativista) {
                $recibos = $this->obtenerRecibosPorParametros($cooperativista->nombre, $cooperativista->apellido, $documento);
            }
        }

        return view('recibos-detalle', compact('recibos', 'cooperativista'));
    }

    private function obtenerRecibosPorParametros($nombre, $apellido, $documento)
    {
        return [
            [
                'numero' => '001',
                'nombre_completo' => trim(($nombre ?? '') . ' ' . ($apellido ?? '')),
                'mes' => 'Enero',
                'año' => '2025'
            ],
            [
                'numero' => '002',
                'nombre_completo' => trim(($nombre ?? '') . ' ' . ($apellido ?? '')),
                'mes' => 'Febrero',
                'año' => '2025'
            ],
            [
                'numero' => '003',
                'nombre_completo' => trim(($nombre ?? '') . ' ' . ($apellido ?? '')),
                'mes' => 'Marzo',
                'año' => '2025'
            ]
        ];
    }
}
