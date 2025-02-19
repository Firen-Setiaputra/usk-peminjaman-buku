<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Buku;
use App\Models\Kategori;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Buku>
 */
class BukuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'judul' => $this->faker->sentence(),
            'penulis' => $this->faker->name(),
            'penerbit' => $this->faker->company(),
            'tahun' => $this->faker->year(),
            'isbn' => $this->faker->randomNumber(9, true), // ISBN biasanya 10 atau 13 digit
            'kategori_id' => Kategori::inRandomOrder()->first()->id ?? Kategori::factory(),
            'jumlah' => $this->faker->numberBetween(1, 20),
        ];
    }
}
