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
            Log::info("Consultando datos cooperativista para cédula: {$cedula} - API no implementada");

            return [
                'estado_pago' => 'pendiente',
                'horas_trabajadas' => 0
            ];

        } catch (\Exception $e) {
            Log::error("Error al consultar datos cooperativista: " . $e->getMessage());
            return [
                'estado_pago' => 'pendiente',
                'horas_trabajadas' => 0
            ];
        }
    }

    public static function getHistorialCompleto($cedula)
    {
        try {
            Log::info("Consultando historial completo para cédula: {$cedula} - API no implementada");
            return [];

        } catch (\Exception $e) {
            Log::error("Error al consultar historial completo: " . $e->getMessage());
            return [];
        }
    }
}
