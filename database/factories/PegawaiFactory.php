<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pegawai>
 */
class PegawaiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'code' => random_int(10000, 99999),
            'name' => $this->faker->name(),
            'role' => $this->faker->randomElement(['penyuluh pns', 'thl-tbpp', 'penyuluh swadaya', 'penyuluh swasta']),
            'kantor_id' => $this->faker->randomElement([1, 2, 3, 4])
        ];
    }
}
