<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoriaApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_pode_criar_categoria()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $token = $admin->createToken('api-token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/categorias', [
                'nome' => 'Suspense'
            ]);

        $response->assertStatus(201)
            ->assertJsonFragment(['nome' => 'Suspense']);
        $this->assertDatabaseHas('categorias', ['nome' => 'Suspense']);
    }
}
