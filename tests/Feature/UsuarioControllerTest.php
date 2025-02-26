<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class UsuarioControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_can_get_all_users()
    {
        Sanctum::actingAs($this->user);
        User::factory()->count(2)->create();

        $response = $this->getJson('/api/usuarios');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_can_create_user()
    {
        Sanctum::actingAs($this->user);
        $userData = [
            'name' => 'Isa',
            'email' => 'isa@gmail.com',
            'password' => 'password',
            'direccion' => 'Calle Sin Nombre 1',
            'telefono' => '123456789',
        ];

        $response = $this->postJson('/api/usuarios', $userData);

        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => 'Isa', 'email' => 'isa@gmail.com']);
    }

    public function test_can_show_user()
    {
        Sanctum::actingAs($this->user);
        $response = $this->getJson("/api/usuarios/{$this->user->id}");

        $response->assertStatus(200)
                 ->assertJson($this->user->toArray());
    }

    public function test_can_update_user()
    {
        Sanctum::actingAs($this->user);
        $updatedData = [
            'name' => 'Isa Editado',
            'email' => 'isaeditado@gmail.com',
            'password' => 'password123',
            'direccion' => 'Calle Sin Cambiada 1',
            'telefono' => '123456789',
        ];

        $response = $this->putJson("/api/usuarios/{$this->user->id}", $updatedData);

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Isa Editado', 'email' => 'isaeditado@gmail.com']);
    }

    public function test_can_delete_user()
    {
        Sanctum::actingAs($this->user);
        $response = $this->deleteJson("/api/usuarios/{$this->user->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Usuario eliminado']);
    }

    public function test_unauthenticated_user_cannot_access_api()
    {
        $response = $this->getJson('/api/usuarios');
        $response->assertStatus(401);
    }
}
