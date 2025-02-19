<?php

namespace Database\Factories;

use App\Models\Borrowing;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Buku;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Borrowing>
 */
class BorrowingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Borrowing::class;
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'buku_id' => Buku::inRandomOrder()->first()->id ?? Buku::factory(),
            'tgl_pinjam' => now(),
            'tgl_kembali' => now()->addDays(rand(3, 14)),
        ];
    }
}
