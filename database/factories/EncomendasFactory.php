<?php

namespace Database\Factories;

use App\Models\Encomendas;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Encomendas>
 */
class EncomendasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Encomendas::class;

    public function definition()
    {
        return [
            'user_id' => 1,
            'valor_pago' => 1000,
            'produto_id' => Produto::inRandomOrder()->first('id'),
            'quantidade' => 10
        ];
    }
}
