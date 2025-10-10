<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Socio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateOauthClientsForApprovedSocios extends Command
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
    protected $description = 'Create oauth password clients for approved socios without credentials.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $socios = Socio::where('estado', 'aprobado')->get();

        $this->info('Found ' . $socios->count() . ' approved socios to process');

        foreach ($socios as $socio) {
            try {
                $usuario = \App\Models\UsuariosNormales::where('cedula', $socio->cedula)->first();

                if (!$usuario) {
                    continue;
                }

                $existingClient = DB::table('oauth_clients')
                    ->where('user_id', $usuario->id)
                    ->where('password_client', 1)
                    ->where('revoked', 0)
                    ->first();

                if ($existingClient && !$this->option('force')) {
                    continue;
                }

                if ($this->option('force') && $existingClient) {
                    DB::table('oauth_clients')
                        ->where('id', $existingClient->id)
                        ->update(['revoked' => 1]);
                }

                $secret = Str::random(40);
                $now = now();
                $clientId = DB::table('oauth_clients')->insertGetId([
                    'user_id' => $usuario->id,
                    'name' => 'Socio ' . $socio->cedula,
                    'secret' => $secret,
                    'provider' => 'users',
                    'redirect' => 'http://localhost',
                    'personal_access_client' => 0,
                    'password_client' => 1,
                    'revoked' => 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                $this->info('Created OAuth client for ' . $socio->cedula . ' (Client ID: ' . $clientId . ')');
            } catch (\Exception $e) {
                $this->error('Failed for ' . $socio->cedula . ': ' . $e->getMessage());
            }
        }

        return 0;
    }
}