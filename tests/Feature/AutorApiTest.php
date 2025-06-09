<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Autor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutorApiTest extends TestCase
{
    use RefreshDatabase;

    private function authAdmin()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $token = $admin->createToken('api-token')->plainTextToken;
        return ['Authorization' => 'Bearer ' . $token];
    }

    public function test_admin_pode_criar_autor()
    {
        $response = $this->withHeaders($this->authAdmin())
            ->postJson('/api/autores', [
                'nome' => 'Machado de Assis',
                'biografia' => 'Um dos maiores escritores brasileiros.'
            ]);

        $response->assertStatus(201)
            ->assertJsonFragment(['nome' => 'Machado de Assis']);
        $this->assertDatabaseHas('autores', ['nome' => 'Machado de Assis']);
    }

    public function test_admin_pode_listar_autores()
    {
        Autor::factory()->create(['nome' => 'Monteiro Lobato']);
        $response = $this->withHeaders($this->authAdmin())
            ->getJson('/api/autores');

        $response->assertStatus(200)
            ->assertJsonFragment(['nome' => 'Monteiro Lobato']);
    }

    public function test_admin_pode_ver_um_autor()
    {
        $autor = Autor::factory()->create(['nome' => 'Clarice Lispector']);
        $response = $this->withHeaders($this->authAdmin())
            ->getJson("/api/autores/{$autor->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['nome' => 'Clarice Lispector']);
    }

    public function test_admin_pode_atualizar_autor()
    {
        $autor = Autor::factory()->create(['nome' => 'Cecilia']);
        $response = $this->withHeaders($this->authAdmin())
            ->putJson("/api/autores/{$autor->id}", ['nome' => 'Cecília Meireles']);

        $response->assertStatus(200)
            ->assertJsonFragment(['nome' => 'Cecília Meireles']);
        $this->assertDatabaseHas('autores', ['nome' => 'Cecília Meireles']);
    }

    public function test_admin_pode_excluir_autor()
    {
        $autor = Autor::factory()->create(['nome' => 'Rubem Braga']);
        $response = $this->withHeaders($this->authAdmin())
            ->deleteJson("/api/autores/{$autor->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Autor excluído com sucesso.']);
        $this->assertDatabaseMissing('autores', ['nome' => 'Rubem Braga']);
    }
}
