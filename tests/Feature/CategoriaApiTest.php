<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Categoria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoriaApiTest extends TestCase
{
    use RefreshDatabase;

    private function authAdmin()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $token = $admin->createToken('api-token')->plainTextToken;
        return ['Authorization' => 'Bearer ' . $token];
    }

    public function test_admin_pode_criar_categoria()
    {
        $response = $this->withHeaders($this->authAdmin())
            ->postJson('/api/categorias', ['nome' => 'Suspense']);

        $response->assertStatus(201)
            ->assertJsonFragment(['nome' => 'Suspense']);
        $this->assertDatabaseHas('categorias', ['nome' => 'Suspense']);
    }

    public function test_admin_pode_listar_categorias()
    {
        Categoria::factory()->create(['nome' => 'Terror']);
        $response = $this->withHeaders($this->authAdmin())
            ->getJson('/api/categorias');

        $response->assertStatus(200)
            ->assertJsonFragment(['nome' => 'Terror']);
    }

    public function test_admin_pode_ver_uma_categoria()
    {
        $categoria = Categoria::factory()->create(['nome' => 'Drama']);
        $response = $this->withHeaders($this->authAdmin())
            ->getJson("/api/categorias/{$categoria->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['nome' => 'Drama']);
    }

    public function test_admin_pode_atualizar_categoria()
    {
        $categoria = Categoria::factory()->create(['nome' => 'Comedia']);
        $response = $this->withHeaders($this->authAdmin())
            ->putJson("/api/categorias/{$categoria->id}", ['nome' => 'Comédia']);

        $response->assertStatus(200)
            ->assertJsonFragment(['nome' => 'Comédia']);
        $this->assertDatabaseHas('categorias', ['nome' => 'Comédia']);
    }

    public function test_admin_pode_excluir_categoria()
    {
        $categoria = Categoria::factory()->create(['nome' => 'Aventura']);
        $response = $this->withHeaders($this->authAdmin())
            ->deleteJson("/api/categorias/{$categoria->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Categoria excluída com sucesso.']);
        $this->assertDatabaseMissing('categorias', ['nome' => 'Aventura']);
    }
}
