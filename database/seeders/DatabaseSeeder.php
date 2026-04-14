<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat Akun Admin
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Operator Wikrama', // Namanya disesuaikan
            'email' => 'operator@gmail.com', // Emailnya disesuaikan
            'password' => Hash::make('password123'),
            'role' => 'operator', // INI YANG PALING PENTING
        ]);
    }
}
