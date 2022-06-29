<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\History>
 */
class HistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'barang_id'         => rand(1, 7),
            'user_id'           => 1,
            'jumlah'            => rand(10, 20),
            'total'             => rand(100, 2400),
            'created_at'        => $this->faker->dateTimeBetween('-1 week', '+1 week')
        ];
    }
}
