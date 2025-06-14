<?php

namespace Database\Factories;

use App\Models\Livro;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Livro>
 */
class LivroFactory extends Factory
{
    protected $model = Livro::class;

    public function definition()
    {
        return [
            'titulo' => $this->faker->unique()->sentence(3),
            'ano_publicacao' => $this->faker->year,
            'categoria_id' => Categoria::factory(),
            'status' => 'disponível',
        ];
    }
}
