<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'username' => 'herve',
            'email' => 'admin@hometutor.com',
            'password' => Hash::make('herve@123'),
            'role' => 'admin'
        ]);
    }
}
