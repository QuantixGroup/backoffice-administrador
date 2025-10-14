<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiCooperativistaService
{
    private static $apiUrl;
    private static $apiToken;

    public function __construct()
    {
        self::$apiUrl = config('services.api_cooperativista.url');
        self::$apiToken = config('services.api_cooperativista.token');
    }

    public static function getDatosCooperativista($cedula)
    {
        try {
            if (!self::$apiUrl) {
                self::$apiUrl = config('services.api_cooperativista.url', 'http://127.0.0.1:8001/api');
            }

            $ultimoEstado = 'pendiente';

            $recibosUrl = self::$apiUrl . '/recibos/' . $cedula;
            $headers = ['Accept' => 'application/json'];

            if (self::$apiToken) {
                $headers['Authorization'] = 'Bearer ' . self::$apiToken;
            }

            $response = Http::withHeaders($headers)->timeout(5)->get($recibosUrl);

            if ($response->successful()) {
                $recibos = $response->json();
                if (!empty($recibos) && is_array($recibos)) {
                    $ultimoEstado = $recibos[0]['estado'] ?? 'pendiente';
                }
            }

            $horasTrabajadas = ApiHorasService::getHorasTrabajadas($cedula);

            return [
                'ultimo_estado_pago' => $ultimoEstado,
                'horas_trabajadas' => $horasTrabajadas
            ];

        } catch (\Exception $e) {
            return [
                'ultimo_estado_pago' => 'pendiente',
                'horas_trabajadas' => 0
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
