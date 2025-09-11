<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiHorasService
{
    private static $apiUrl;
    private static $apiToken;

    public function __construct()
    {
        self::$apiUrl = config('services.api_horas.url');
        self::$apiToken = config('services.api_horas.token');
    }

    public static function getHorasTrabajadas($cedula)
    {
        try {
            Log::info("Consultando horas trabajadas para cédula: {$cedula} - API no encontrada");
            return 0;

        } catch (\Exception $e) {
            Log::error("Error al consultar horas trabajadas: " . $e->getMessage());
            return 0;
        }
    }

    public static function getHistorialHoras($cedula)
    {
        try {
            Log::info("Consultando historial de horas para cédula: {$cedula} - API no encontrada");
            return [];

        } catch (\Exception $e) {
            Log::error("Error al consultar historial de horas: " . $e->getMessage());
            return [];
        }
    }
}
