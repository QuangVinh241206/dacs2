<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // create a test user matching our users table (no email_verified_at column)
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        // categories and products
        $this->call([CategorySeeder::class, ProductSeeder::class]);
    }
}
