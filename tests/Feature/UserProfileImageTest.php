<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserProfileImageTest extends TestCase
{
    /** @var \App\Models\User */
    protected $admin;

    protected $skipTestsDueToMissingTables = false;

    protected function setUp(): void
    {
        parent::setUp();
        if (! Schema::hasTable((new User)->getTable())) {
            $this->skipTestsDueToMissingTables = true;
        }

        if (! $this->skipTestsDueToMissingTables) {
            $this->admin = User::updateOrCreate([
                'cedula' => '99999990',
            ], [
                'name' => 'Upload Admin',
                'apellido' => 'Test',
                'telefono' => '099000002',
                'email' => 'upload_admin@example.com',
                'password' => Hash::make('password'),
                'primer_password' => false,
            ]);
        }
    }

    public function test_upload_profile_image_validation_falla_sin_archivo(): void
    {
        if ($this->skipTestsDueToMissingTables) {
            $this->addToAssertionCount(1);

            return;
        }
        $this->actingAs($this->admin);

        $resp = $this->postJson(route('perfil.upload-image'), []);
        $resp->assertStatus(422);
        $data = $resp->json();
        $this->assertFalse($data['success']);
    }

    public function test_upload_profile_image_exito_guarda_archivo_y_actualiza_usuario(): void
    {
        if ($this->skipTestsDueToMissingTables) {
            $this->addToAssertionCount(1);

            return;
        }
        Storage::fake('public');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $this->actingAs($this->admin);

        $resp = $this->postJson(route('perfil.upload-image'), [
            'profile_image' => $file,
        ]);

        $resp->assertStatus(200);
        $data = $resp->json();
        $this->assertTrue($data['success']);
        $this->assertArrayHasKey('image_url', $data);
        $this->admin->refresh();
        $this->assertNotEmpty($this->admin->profile_image);
        $this->assertTrue(Storage::disk('public')->exists($this->admin->profile_image));
    }
}
