<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\VoucherSeeder;
use Database\Seeders\OrderSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // categories and products first
        $this->call([CategorySeeder::class, ProductSeeder::class]);

        // then users and vouchers
        $this->call([UserSeeder::class, VoucherSeeder::class]);

        // finally orders and order details
        $this->call([OrderSeeder::class]);
    }
}
