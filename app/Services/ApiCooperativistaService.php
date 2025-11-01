<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ApiCooperativistaService
{
    public static function getDatosCooperativista($cedula)
    {
        try {
            $ultimoPago = DB::table('pagos_mensuales')
                ->where('cedula', $cedula)
                ->orderBy('fecha_comprobante', 'desc')
                ->first();

            $ultimoEstado = $ultimoPago ? $ultimoPago->estado : 'pendiente';
            $horasTrabajadas = ApiHorasService::getHorasTrabajadas($cedula);

            return [
                'ultimo_estado_pago' => $ultimoEstado,
                'horas_trabajadas' => $horasTrabajadas,
            ];

        } catch (\Exception $e) {
            return [
                'ultimo_estado_pago' => 'pendiente',
                'horas_trabajadas' => 0,
            ];
        }
    }

    public static function getHistorialCompleto($cedula)
    {
        try {
            return ApiHorasService::getHistorialHoras($cedula);

        } catch (\Exception $e) {
            return [];
        }
    }
}
