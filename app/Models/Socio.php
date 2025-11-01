<?php

namespace App\Models;

use App\Services\ApiCooperativistaService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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
        'fecha_egreso',
        'deleted_at',
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

        return $datos['ultimo_estado_pago'] ?? 'pendiente';
    }

    public function getEstadoPagoBadgeAttribute()
    {
        $estado = $this->estado_pago;

        switch ($estado) {
            case 'aceptado':
                return '<span class="badge bg-success">Aceptado</span>';
            case 'rechazado':
                return '<span class="badge bg-danger">Rechazado</span>';
            case 'pendiente':
            default:
                return '<span class="badge bg-warning text-dark">Pendiente</span>';
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

        return $horas.' hrs';
    }

    public function getIngresosMensualesAttribute()
    {
        return $this->attributes['ingreso_mensual'] ?? null;
    }

    public static function eliminarPorCedula(string $cedula): bool
    {
        $socio = self::where('cedula', $cedula)->firstOrFail();
        if (($socio->estado ?? null) !== 'aprobado') {
            return false;
        }

        return DB::transaction(function () use ($socio, $cedula) {
            $socio->delete();

            $user = UsuariosNormales::where('cedula', $cedula)->first();
            if (! $user) {
                return true;
            }

            $userId = $user->id;
            $user->delete();

            DB::table('oauth_access_tokens')->where('user_id', $userId)->update(['revoked' => 1]);

            DB::table('oauth_refresh_tokens')
                ->whereIn('access_token_id', function ($q) use ($userId) {
                    $q->select('id')->from('oauth_access_tokens')->where('user_id', $userId);
                })->delete();

            DB::table('personal_access_tokens')->where('tokenable_id', $userId)->delete();
            DB::table('sessions')->where('user_id', $userId)->delete();

            return true;
        });
    }
}
