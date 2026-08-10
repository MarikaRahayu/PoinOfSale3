<?php

namespace Database\Factories;

use App\Models\JenisProduk;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->value('id'),

            'foto' => 'produk/' . fake()->uuid() . '.jpg',

            'jenis_produk_id' => JenisProduk::query()->inRandomOrder()->value('id'),

            'nama' => fake()->words(3, true),

            'harga_beli' => fake()->numberBetween(5000, 500000),

            'harga_jual' => fake()->numberBetween(10000, 700000),

            'stok' => fake()->numberBetween(0, 100),
        ];
    }
}