<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'kategori_id'       => rand(1, 3),
            'supplier_id'       => rand(1, 5),
            'nama'              => $this->faker->word(),
            'harga_beli'        => rand(1000, 5000),
            'harga_jual'        => rand(5000, 9000),
            'stok'              => rand(20, 60)
        ];
    }
}
