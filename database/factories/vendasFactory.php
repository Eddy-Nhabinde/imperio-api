<?php

namespace Database\Factories;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\vendas>
 */
class vendasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\vendas::class;

    public function definition()
    {
        return [
            'user_id' => 1,
            'valorPago' => 400,
            'produto_id' => Produto::inRandomOrder()->first('id'),
            'quantidade' => 5,
            'estado' => 'cancelada'
        ];
    }
}
