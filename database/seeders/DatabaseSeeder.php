<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'username' => 'cipher',
            'email' => 'cipher@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'nama_lengkap' => 'Test User',
            'role' => 'admin', 
            'status' => 'aktif', 
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
    }
}
