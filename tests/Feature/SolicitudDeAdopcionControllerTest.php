<?php

namespace Tests\Feature;

use App\Models\SolicitudDeAdopcion;
use App\Models\User;
use App\Models\Mascota;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class SolicitudDeAdopcionControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $mascota;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->artisan('migrate');
        
        $this->user = User::factory()->create();
        $this->mascota = Mascota::factory()->create();
        Sanctum::actingAs($this->user);
    }

    public function test_can_get_all_solicitudes()
    {
        SolicitudDeAdopcion::factory()->count(3)->create();

        $response = $this->getJson('/api/solicitudes');

        $response->assertStatus(200)
                 ->assertJsonCount(3)
                 ->assertJsonStructure([
                     '*' => ['id', 'usuario', 'mascota', 'fecha_solicitud', 'estado', 'comentario']
                 ]);
    }

    public function test_can_create_solicitud()
    {
        $solicitudData = [
            'usuario_id' => $this->user->id,
            'mascota_id' => $this->mascota->id,
            'fecha_solicitud' => now()->toDateString(),
            'estado' => 'pendiente',
            'comentario' => 'Me gustaría adoptar esta mascota'
        ];

        $response = $this->postJson('/api/solicitudes', $solicitudData);

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'usuario_id' => $this->user->id,
                     'mascota_id' => $this->mascota->id,
                     'estado' => 'pendiente'
                 ]);

        $this->assertDatabaseHas('solicitud_de_adopciones', [
            'usuario_id' => $this->user->id,
            'mascota_id' => $this->mascota->id
        ]);
    }

    public function test_can_show_solicitud()
    {
        $solicitud = SolicitudDeAdopcion::factory()->create([
            'usuario_id' => $this->user->id,
            'mascota_id' => $this->mascota->id
        ]);

        $response = $this->getJson("/api/solicitudes/{$solicitud->id}");

        $response->assertStatus(200)
                 ->assertJson($solicitud->toArray())
                 ->assertJsonStructure(['usuario', 'mascota']);
    }

    public function test_can_update_solicitud()
    {
        $solicitud = SolicitudDeAdopcion::factory()->create([
            'usuario_id' => $this->user->id,
            'mascota_id' => $this->mascota->id
        ]);

        $updatedData = [
            'estado' => 'aprobada',
            'comentario' => 'Solicitud aprobada'
        ];

        $response = $this->putJson("/api/solicitudes/{$solicitud->id}", $updatedData);

        $response->assertStatus(200)
                 ->assertJsonFragment($updatedData);

        $this->assertDatabaseHas('solicitud_de_adopciones', [
            'id' => $solicitud->id,
            'estado' => 'aprobada'
        ]);
    }

    public function test_can_delete_solicitud()
    {
        $solicitud = SolicitudDeAdopcion::factory()->create([
            'usuario_id' => $this->user->id,
            'mascota_id' => $this->mascota->id
        ]);

        $response = $this->deleteJson("/api/solicitudes/{$solicitud->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Solicitud eliminada']);

        $this->assertDatabaseMissing('solicitud_de_adopciones', ['id' => $solicitud->id]);
    }

    public function test_cannot_create_solicitud_with_invalid_data()
    {
        $invalidData = [
            'usuario_id' => 999, 
            'mascota_id' => 999, 
            'fecha_solicitud' => 'no es una fecha',
            'estado' => 'estado inválido'
        ];

        $response = $this->postJson('/api/solicitudes', $invalidData);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['usuario_id', 'mascota_id', 'fecha_solicitud', 'estado']);
    }

    public function test_cannot_show_nonexistent_solicitud()
    {
        $response = $this->getJson("/api/solicitudes/999");

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Solicitud no encontrada']);
    }

    public function test_cannot_update_nonexistent_solicitud()
    {
        $response = $this->putJson("/api/solicitudes/999", ['estado' => 'aprobada']);

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Solicitud no encontrada']);
    }

    public function test_cannot_delete_nonexistent_solicitud()
    {
        $response = $this->deleteJson("/api/solicitudes/999");

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Solicitud no encontrada']);
    }

    public function test_unauthenticated_user_cannot_access_api()
    {
        $this->app = $this->createApplication();
        
        $response = $this->getJson('/api/solicitudes');
        $response->assertStatus(401);
    }
}
