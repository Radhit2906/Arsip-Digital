<?php

namespace Database\Factories;

use App\Models\invoices;
use App\Models\keterangan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Keterangan>
 */
class KeteranganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = keterangan::class;

    public function definition(): array
    {
        
        return [
            'invoice_id' => invoices::factory(), // Create an invoice for each keterangan
            'keterangan' => $this->faker->sentence,
            'biaya' => $this->faker->numberBetween(100, 1000),
        ];
    }
}
