<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Socio;
use App\Services\ApiRecibosService;

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
                try {
                    $recibosApi = ApiRecibosService::getRecibosPorCedula($documento);

                    $recibos = collect($recibosApi)->map(function ($recibo, $index) {
                        return [
                            'id_pago' => $recibo['id_pago'] ?? null,
                            'numero' => str_pad($recibo['id_pago'] ?? ($index + 1), 3, '0', STR_PAD_LEFT),
                            'monto' => '$' . number_format($recibo['monto'] ?? 0, 2),
                            'mes' => $this->obtenerNombreMes($recibo['mes'] ?? null),
                            'año' => $recibo['anio'] ?? $recibo['año'] ?? date('Y'),
                            'estado' => $recibo['estado'] ?? 'pendiente',
                            'fecha_comprobante' => $recibo['fecha_comprobante'] ?? null,
                            'archivo_comprobante' => $recibo['archivo_comprobante'] ?? null,
                            'observacion' => $recibo['observacion'] ?? ''
                        ];
                    })->toArray();
                } catch (\Exception $e) {
                    $recibos = [];
                }
            }
        }

        return view('recibos-detalle', compact('recibos', 'cooperativista'));
    }

    private function obtenerNombreMes($mes)
    {
        if (!$mes)
            return '-';

        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];

        return $meses[intval($mes)] ?? $mes;
    }

    public function actualizarEstado(Request $request, $idPago)
    {
        try {
            $request->validate([
                'estado' => 'required|in:pendiente,aceptado,rechazado',
                'observacion' => 'nullable|string'
            ]);

            $nuevoEstado = $request->input('estado');
            $observacion = $request->input('observacion');

            $resultado = ApiRecibosService::actualizarEstadoRecibo($idPago, $nuevoEstado, $observacion);

            if ($resultado) {
                return response()->json([
                    'success' => true,
                    'message' => 'Se actualizó el recibo correctamente'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No se pudo actualizar el estado del recibo'
                ], 500);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la solicitud'
            ], 500);
        }
    }

    public function verPdf($idPago)
    {
        try {
            $pdfData = ApiRecibosService::obtenerPdfRecibo($idPago);

            if ($pdfData) {
                return response($pdfData)
                    ->header('Content-Type', 'application/pdf')
                    ->header('Content-Disposition', 'inline; filename="recibo_' . $idPago . '.pdf"');
            }

            return response()->json([
                'success' => false,
                'message' => 'No se encontró ningún archivo PDF'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al encontrar algún archivo PDF',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
