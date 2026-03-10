<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        \App\Models\User::create([
            'name'              => 'テストユーザー',
            'email'             => 'test@test.com',
            'password'          => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
    }
}
