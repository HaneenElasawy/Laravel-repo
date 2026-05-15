<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Haneen',
            'email' => 'nino@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'Mohamed',
            'email' => 'mohamed@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'Ali',
            'email' => 'ali@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        $this->call(PostSeeder::class);
    }
}
