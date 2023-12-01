<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pendukung>
 */
class PendukungFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'nik' => fake()->countryCode(),
            'kec' => 'PANGGUNGREJO',
            'desa' => 'MAYANGAN',
            'detail_alamat' => fake()->address(),
            'user_id' => fake()->numberBetween(1, 20),
            'tps_id' => fake()->numberBetween(1, 188),
        ];
    }
}
