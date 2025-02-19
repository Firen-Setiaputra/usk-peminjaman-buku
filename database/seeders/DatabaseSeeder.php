<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Buku;
use App\Models\Borrowing;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

         // Tambah User Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('123'),
            'jenis' => 'admin' // Pastikan ada kolom 'role' di tabel users
        ]);

        // Tambah User Biasa
        User::create([
            'name' => 'User Biasa',
            'email' => 'user@example.com',
            'password' => Hash::make('321'),
            'jenis' => 'user'
        ]);

        // Tambah Data Buku Dummy
        Buku::factory(10)->create(); // Pastikan sudah punya Factory untuk Buku

        // Tambah Data Peminjaman Dummy
        Borrowing::factory(5)->create(); // Pastikan sudah punya Factory untuk Peminjaman
    }
}
