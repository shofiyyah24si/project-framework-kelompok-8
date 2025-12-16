<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // HANYA BUAT 1 USER ADMIN SAJA
        // Tidak ada data warga, kejadian, atau posko
        User::create([
            'name' => 'Admin Tanggap Darurat',
            'email' => 'admin@bencana.local',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);
    }
}