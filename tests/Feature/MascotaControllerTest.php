<?php

namespace Tests\Feature;

use App\Models\Mascota;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class MascotaControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_can_get_all_mascotas()
    {
        Sanctum::actingAs($this->user);
        Mascota::factory()->count(3)->create();

        $response = $this->getJson('/api/mascotas');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_can_create_mascota()
    {
        Sanctum::actingAs($this->user);
        $mascotaData = [
            'nombre' => 'Firulais',
            'especie' => 'Perro',
            'raza' => 'Labrador',
            'edad' => 3,
            'descripcion' => 'Perro amigable y juguetón',
            'estado' => 'disponible'
        ];

        $response = $this->postJson('/api/mascotas', $mascotaData);

        $response->assertStatus(201)
                 ->assertJsonFragment(['nombre' => 'Firulais', 'especie' => 'Perro']);

        $this->assertDatabaseHas('mascotas', ['nombre' => 'Firulais']);
    }

    public function test_can_show_mascota()
    {
        Sanctum::actingAs($this->user);
        $mascota = Mascota::factory()->create();

        $response = $this->getJson("/api/mascotas/{$mascota->id}");

        $response->assertStatus(200)
                 ->assertJson($mascota->toArray());
    }

    public function test_can_update_mascota()
    {
        Sanctum::actingAs($this->user);
        $mascota = Mascota::factory()->create();

        $updatedData = [
            'nombre' => 'Max',
            'estado' => 'en proceso de adopción'
        ];

        $response = $this->putJson("/api/mascotas/{$mascota->id}", $updatedData);

        $response->assertStatus(200)
                 ->assertJsonFragment(['nombre' => 'Max', 'estado' => 'en proceso de adopción']);

        $this->assertDatabaseHas('mascotas', ['id' => $mascota->id, 'nombre' => 'Max']);
    }

    public function test_can_delete_mascota()
    {
        Sanctum::actingAs($this->user);
        $mascota = Mascota::factory()->create();

        $response = $this->deleteJson("/api/mascotas/{$mascota->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Mascota eliminada']);

        $this->assertDatabaseMissing('mascotas', ['id' => $mascota->id]);
    }

    public function test_cannot_create_mascota_with_invalid_data()
    {
        Sanctum::actingAs($this->user);
        $invalidData = [
            'nombre' => '',
            'especie' => '',
            'raza' => '',
            'edad' => 'no es un número',
            'descripcion' => '',
            'estado' => 'estado inválido'
        ];

        $response = $this->postJson('/api/mascotas', $invalidData);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nombre', 'especie', 'raza', 'edad', 'descripcion', 'estado']);
    }

    public function test_cannot_show_nonexistent_mascota()
    {
        Sanctum::actingAs($this->user);
        $response = $this->getJson("/api/mascotas/999");

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Mascota no encontrada']);
    }

    public function test_cannot_update_nonexistent_mascota()
    {
        Sanctum::actingAs($this->user);
        $response = $this->putJson("/api/mascotas/999", ['nombre' => 'Test']);

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Mascota no encontrada']);
    }

    public function test_cannot_delete_nonexistent_mascota()
    {
        Sanctum::actingAs($this->user);
        $response = $this->deleteJson("/api/mascotas/999");

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Mascota no encontrada']);
    }

    public function test_unauthenticated_user_cannot_access_api()
    {
        $response = $this->getJson('/api/mascotas');
        $response->assertStatus(401);
    }
}
