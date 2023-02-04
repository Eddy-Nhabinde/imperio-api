<?php

namespace Database\Factories;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produto>
 */
class ProdutoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Produto::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->name(),
            'tipo_id' => 1,
            'foto' => 1,
            'preco' => 1000,
            'quantidade' => 5,
            'peso' => null
        ];
    }
}
