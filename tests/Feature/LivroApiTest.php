<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Livro;
use App\Models\Categoria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LivroApiTest extends TestCase
{
    use RefreshDatabase;

    private function authAdmin()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $token = $admin->createToken('api-token')->plainTextToken;
        return ['Authorization' => 'Bearer ' . $token];
    }

    public function test_admin_pode_criar_livro()
    {
        $categoria = Categoria::factory()->create();
        $response = $this->withHeaders($this->authAdmin())
            ->postJson('/api/livros', [
                'titulo' => 'O Senhor dos Anéis',
                'ano_publicacao' => 1954,
                'categoria_id' => $categoria->id,
                'status' => 'disponível'
            ]);

        $response->assertStatus(201)
            ->assertJsonFragment(['titulo' => 'O Senhor dos Anéis']);
        $this->assertDatabaseHas('livros', ['titulo' => 'O Senhor dos Anéis']);
    }

    public function test_admin_pode_listar_livros()
    {
        Livro::factory()->create(['titulo' => 'Harry Potter']);
        $response = $this->withHeaders($this->authAdmin())
            ->getJson('/api/livros');

        $response->assertStatus(200)
            ->assertJsonFragment(['titulo' => 'Harry Potter']);
    }

    public function test_admin_pode_ver_um_livro()
    {
        $livro = Livro::factory()->create(['titulo' => 'Dom Quixote']);
        $response = $this->withHeaders($this->authAdmin())
            ->getJson("/api/livros/{$livro->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['titulo' => 'Dom Quixote']);
    }

    public function test_admin_pode_atualizar_livro()
    {
        $livro = Livro::factory()->create(['titulo' => 'Teste']);
        $categoria = Categoria::factory()->create();
        $response = $this->withHeaders($this->authAdmin())
            ->putJson("/api/livros/{$livro->id}", [
                'titulo' => 'Teste Atualizado',
                'ano_publicacao' => 2000,
                'categoria_id' => $categoria->id,
                'status' => 'disponível'
            ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['titulo' => 'Teste Atualizado']);
        $this->assertDatabaseHas('livros', ['titulo' => 'Teste Atualizado']);
    }

    public function test_admin_pode_excluir_livro()
    {
        $livro = Livro::factory()->create(['titulo' => 'Livro a Excluir']);
        $response = $this->withHeaders($this->authAdmin())
            ->deleteJson("/api/livros/{$livro->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Livro excluído com sucesso.']);
        $this->assertDatabaseMissing('livros', ['titulo' => 'Livro a Excluir']);
    }
}
