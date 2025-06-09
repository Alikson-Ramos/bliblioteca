<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AutorFactory extends Factory
{
    protected $model = \App\Models\Autor::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->name,
            'biografia' => $this->faker->optional()->paragraph,
        ];
    }
}
