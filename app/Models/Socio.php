<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use App\Services\ApiCooperativistaService;


class Socio extends Model
{
    use SoftDeletes;
    protected $table = 'socios';

    protected $fillable = [
        'cedula',
        'nombre',
        'apellido',
        'fecha_nacimiento',
        'telefono',
        'direccion',
        'departamento',
        'ciudad',
        'email',
        'foto_perfil',
        'contraseña',
        'ingreso_mensual',
        'situacion_laboral',
        'estado',
        'integrantes_familiares',
        'fecha_ingreso',
        'fecha_egreso'
    ];

    private $datosApi = null;

    private function getDatosApi()
    {
        if ($this->datosApi === null) {
            $this->datosApi = ApiCooperativistaService::getDatosCooperativista($this->cedula);
        }
        return $this->datosApi;
    }

    public function getEstadoPagoAttribute()
    {
        $datos = $this->getDatosApi();
        return $datos['estado_pago'] ?? 'pendiente';
    }

    public function getEstadoPagoBadgeAttribute()
    {
        $estado = $this->estado_pago;

        switch ($estado) {
            case 'pagado':
                return '<span class="badge bg-success">Pagado</span>';
            case 'vencido':
                return '<span class="badge bg-danger">Vencido</span>';
            case 'pendiente':
            default:
                return '<span class="badge bg-secondary">Pendiente</span>';
        }
    }

    public function getHorasTrabajadasAttribute()
    {
        $datos = $this->getDatosApi();
        return $datos['horas_trabajadas'] ?? 0;
    }

    public function getHorasTrabajadasBadgeAttribute()
    {
        $horas = $this->horas_trabajadas;
        return $horas . ' hrs';
    }

    public function getIngresosMensualesAttribute()
    {
        return $this->attributes['ingreso_mensual'] ?? null;
    }


}