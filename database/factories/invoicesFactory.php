<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\invoices>
 */
class invoicesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
           'id_invoice' =>fake()->word(),
            'kategori' =>fake()->sentence(100),
            'date' =>fake()->date(),
            'seller' =>fake()->name(),
            'alamat_seller' =>fake()->address(),
            'payer' =>fake()->name(),
            'alamat_payer' =>fake()->address(),
            'total_biaya'=>fake()->randomNumber()

        ];
    }
}
