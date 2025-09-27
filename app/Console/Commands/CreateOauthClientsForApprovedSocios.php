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
        $socios = Socio::where('estado', 'aprobado')
            ->when(!$this->option('force'), function ($q) {
                $q->whereNull('oauth_client_id');
            })
            ->get();

        $this->info('Found ' . $socios->count() . ' socios to process');

        foreach ($socios as $socio) {
            try {
                $secret = Str::random(40);
                $now = now();
                $clientId = DB::table('oauth_clients')->insertGetId([
                    'user_id' => null,
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

                $socio->oauth_client_id = $clientId;
                $socio->oauth_client_secret = $secret;
                $socio->save();

                $this->info('Created client for ' . $socio->cedula . ' id=' . $clientId);
            } catch (\Exception $e) {
                $this->error('Failed for ' . $socio->cedula . ': ' . $e->getMessage());
            }
        }

        return 0;
    }
}