<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Socio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreacionOauthSociosAprovados extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'socios:create-oauth-clients {--force : Overwrite existing clients}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear clientes OAuth (password) para socios aprobados sin credenciales.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $socios = Socio::where('estado', 'aprobado')->get();
        $count = $socios->count();
        $this->info("Se encontraron {$count} socios aprobados para procesar");

        foreach ($socios as $socio) {
            $cedula = $socio->cedula;
            try {
                $usuario = \App\Models\UsuariosNormales::where('cedula', $cedula)->first();
                if (!$usuario) {
                    $this->line("Omitiendo {$cedula}: no existe registro de usuario");
                    continue;
                }

                $existingClient = DB::table('oauth_clients')
                    ->where('user_id', $usuario->id)
                    ->where('password_client', 1)
                    ->where('revoked', 0)
                    ->first();

                if ($existingClient) {
                    if ($this->option('force')) {
                        DB::table('oauth_clients')->where('id', $existingClient->id)->update(['revoked' => 1]);
                        $this->line("Cliente existente revocado para {$cedula}");
                    } else {
                        $this->line("El cliente ya existe para {$cedula}, omitiendo");
                        continue;
                    }
                }

                $secret = Str::random(40);
                $now = now();
                $clientId = DB::table('oauth_clients')->insertGetId([
                    'user_id' => $usuario->id,
                    'name' => 'Socio ' . $cedula,
                    'secret' => $secret,
                    'provider' => 'users',
                    'redirect' => 'http://localhost',
                    'personal_access_client' => 0,
                    'password_client' => 1,
                    'revoked' => 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                $this->info("Cliente OAuth creado para {$cedula} (ID cliente: {$clientId})");
            } catch (\Throwable $e) {
                $this->error("Error al procesar {$cedula}: " . $e->getMessage());
            }
        }

        return 0;
    }
}
