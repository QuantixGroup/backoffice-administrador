<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ApiRecibosService
{
    public static function getRecibosPorCedula($cedula)
    {
        try {
            $recibos = DB::table('pagos_mensuales')
                ->where('cedula', $cedula)
                ->orderBy('fecha_comprobante', 'desc')
                ->get()
                ->map(function ($recibo) {
                    return [
                        'id_pago' => $recibo->id_pago,
                        'cedula' => $recibo->cedula,
                        'monto' => $recibo->monto,
                        'fecha_comprobante' => $recibo->fecha_comprobante,
                        'archivo_comprobante' => $recibo->archivo_comprobante,
                        'estado' => $recibo->estado,
                        'mes' => $recibo->mes,
                        'anio' => $recibo->anio,
                        'observacion' => $recibo->observacion ?? '',
                    ];
                })
                ->toArray();

            return $recibos;

        } catch (\Exception $e) {
            return [];
        }
    }

    public static function getEstadisticasRecibos($cedula)
    {
        try {
            $recibos = self::getRecibosPorCedula($cedula);

            $total = count($recibos);
            $pendientes = 0;
            $pagados = 0;
            $montoTotal = 0;

            foreach ($recibos as $recibo) {
                if (isset($recibo['estado'])) {
                    if ($recibo['estado'] === 'pendiente') {
                        $pendientes++;
                    } elseif ($recibo['estado'] === 'pagado' || $recibo['estado'] === 'aceptado') {
                        $pagados++;
                    }
                }

                if (isset($recibo['monto'])) {
                    $montoTotal += floatval($recibo['monto']);
                }
            }

            return [
                'total' => $total,
                'pendientes' => $pendientes,
                'pagados' => $pagados,
                'monto_total' => $montoTotal,
            ];

        } catch (\Exception $e) {
            return [
                'total' => 0,
                'pendientes' => 0,
                'pagados' => 0,
                'monto_total' => 0,
            ];
        }
    }

    public static function actualizarEstadoRecibo($idPago, $nuevoEstado, $observacion = null)
    {
        try {
            $updateData = ['estado' => $nuevoEstado];

            if ($observacion !== null) {
                $updateData['observacion'] = $observacion;
            }

            $updated = DB::table('pagos_mensuales')
                ->where('id_pago', $idPago)
                ->update($updateData);

            return $updated > 0;

        } catch (\Exception $e) {
            return false;
        }
    }

    public static function obtenerPdfRecibo($idPago)
    {
        try {
            $pago = DB::table('pagos_mensuales')
                ->where('id_pago', $idPago)
                ->first();

            if (! $pago || ! $pago->archivo_comprobante) {
                return null;
            }

            $rutaRelativa = $pago->archivo_comprobante;

            $ubicacionesPosibles = [
                storage_path('app/public/'.$rutaRelativa),
                base_path('../api-usuarios/storage/app/public/'.$rutaRelativa),
                base_path('../api-cooperativa/storage/app/public/'.$rutaRelativa),
                $rutaRelativa,
                public_path($rutaRelativa),
                public_path('storage/'.$rutaRelativa),
            ];

            $rutaArchivo = null;

            foreach ($ubicacionesPosibles as $ubicacion) {
                if (file_exists($ubicacion)) {
                    $rutaArchivo = $ubicacion;
                    break;
                }
            }

            if (! $rutaArchivo) {
                return null;
            }

            $contenidoPdf = file_get_contents($rutaArchivo);

            if ($contenidoPdf === false) {
                return null;
            }

            return $contenidoPdf;

        } catch (\Exception $e) {
            return null;
        }
    }
}
