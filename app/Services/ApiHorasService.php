<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ApiHorasService
{
    public static function getHorasTrabajadas($cedula)
    {
        try {
            $totalHoras = DB::table('registros_horas')
                ->where('cedula', $cedula)
                ->sum('conteo_de_horas');

            return $totalHoras ?? 0;

        } catch (\Exception $e) {
            return 0;
        }
    }

    public static function getHistorialHoras($cedula)
    {
        try {
            $registros = DB::table('registros_horas')
                ->where('cedula', $cedula)
                ->orderBy('fecha', 'desc')
                ->get()
                ->map(function ($registro) {
                    return [
                        'id' => $registro->id,
                        'fecha' => $registro->fecha,
                        'conteo_de_horas' => $registro->conteo_de_horas,
                        'tipo_trabajo' => $registro->tipo_trabajo,
                        'descripcion' => $registro->descripcion,
                        'estado' => $registro->estado,
                        'comprobante_compensacion' => $registro->comprobante_compensacion,
                        'monto_compensacion' => $registro->monto_compensacion,
                        'fecha_compensacion' => $registro->fecha_compensacion,
                    ];
                })
                ->toArray();

            return $registros;

        } catch (\Exception $e) {
            return [];
        }
    }
}
