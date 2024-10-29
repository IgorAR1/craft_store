<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->create(
            [
                'id' => Str::uuid(),
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'phone' => fake()->phoneNumber(),
                'email' => 'admin@mail.ru',
                'email_verified_at' => now(),
                'type' => 'admin',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10)
            ],

        );
        User::create(
            [
                'id' => Str::uuid(),
                'first_name' => 'User',
                'last_name' => 'User',
                'email' => 'user@mail.ru',
                'email_verified_at' => now(),
                'phone' => fake()->phoneNumber(),
                'type' => 'user',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10)
            ],
        );
        User::create(
            [
                'id' => Str::uuid(),
                'first_name' => 'Guest',
                'last_name' => 'Guest',
                'email' => 'guest@mail.ru',
                'phone' => fake()->phoneNumber(),
                'email_verified_at' => now(),
                'type' => 'guest',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10)
            ],
        );
    }
}
