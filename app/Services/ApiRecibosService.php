<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiRecibosService
{
    private static $apiUrl;
    private static $apiToken;

    public function __construct()
    {
        self::$apiUrl = config('services.api_cooperativista.url', 'http://127.0.0.1:8001/api');
        self::$apiToken = config('services.api_cooperativista.token');
    }

    public static function getRecibosPorCedula($cedula)
    {
        try {
            if (!self::$apiUrl) {
                self::$apiUrl = config('services.api_cooperativista.url', 'http://127.0.0.1:8001/api');
            }

            $url = self::$apiUrl . '/recibos/' . $cedula;

            $headers = [];
            if (self::$apiToken) {
                $headers['Authorization'] = 'Bearer ' . self::$apiToken;
            }

            $response = Http::withHeaders($headers)
                ->timeout(10)
                ->get($url);

            if ($response->successful()) {
                $data = $response->json();
                return $data;
            }

            if ($response->status() === 404) {
                return [];
            }

            return [];

        } catch (\Exception $e) {
            Log::error("Error al consultar recibos: " . $e->getMessage());
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
                    } elseif ($recibo['estado'] === 'pagado' || $recibo['estado'] === 'aprobado') {
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
                'monto_total' => $montoTotal
            ];

        } catch (\Exception $e) {
            Log::error("Error al calcular estadísticas de recibos: " . $e->getMessage());
            return [
                'total' => 0,
                'pendientes' => 0,
                'pagados' => 0,
                'monto_total' => 0
            ];
        }
    }

    public static function actualizarEstadoRecibo($idPago, $nuevoEstado)
    {
        try {
            if (!self::$apiUrl) {
                self::$apiUrl = config('services.api_cooperativista.url', 'http://127.0.0.1:8001/api');
            }

            $url = self::$apiUrl . '/recibos/' . $idPago;

            $headers = ['Accept' => 'application/json'];
            if (self::$apiToken) {
                $headers['Authorization'] = 'Bearer ' . self::$apiToken;
            }

            $response = Http::withHeaders($headers)
                ->timeout(10)
                ->put($url, [
                    'estado' => $nuevoEstado
                ]);

            if ($response->successful()) {
                return true;
            }

            return false;

        } catch (\Exception $e) {
            Log::error("Error al actualizar estado: " . $e->getMessage());
            return false;
        }
    }
}
