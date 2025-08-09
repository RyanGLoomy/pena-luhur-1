<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Akun Admin
        User::create([
            'name' => 'Admin Pena Luhur',
            'email' => 'admin@penaluhur.com',
            'password' => Hash::make('password'), // Ganti dengan password yang aman
        ]);

        // Panggil BookSeeder
        $this->call(BookSeeder::class);
    }
}
