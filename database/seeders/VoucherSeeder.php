<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Voucher;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Voucher::create([
            'code' => 'GIAMGIA10',
            'discount_type' => 'percent',
            'discount_value' => 10,
            'start_date' => now()->subDays(30),
            'end_date' => now()->addDays(30),
            'min_order_value' => 500000,
            'max_discount_value' => 50000,
            'is_active' => true,
        ]);

        Voucher::create([
            'code' => 'GIAMGIA20',
            'discount_type' => 'percent',
            'discount_value' => 20,
            'start_date' => now()->subDays(15),
            'end_date' => now()->addDays(45),
            'min_order_value' => 1000000,
            'max_discount_value' => 200000,
            'is_active' => true,
        ]);

        Voucher::create([
            'code' => 'GIAMGIA50K',
            'discount_type' => 'fixed',
            'discount_value' => 50000,
            'start_date' => now()->subDays(7),
            'end_date' => now()->addDays(60),
            'min_order_value' => 300000,
            'max_discount_value' => null,
            'is_active' => true,
        ]);

        Voucher::create([
            'code' => 'GIAMGIA100K',
            'discount_type' => 'fixed',
            'discount_value' => 100000,
            'start_date' => now()->subDays(3),
            'end_date' => now()->addDays(90),
            'min_order_value' => 800000,
            'max_discount_value' => null,
            'is_active' => true,
        ]);

        Voucher::create([
            'code' => 'SALE30',
            'discount_type' => 'percent',
            'discount_value' => 30,
            'start_date' => now()->addDays(1),
            'end_date' => now()->addDays(7),
            'min_order_value' => 2000000,
            'max_discount_value' => 500000,
            'is_active' => true,
        ]);

        Voucher::create([
            'code' => 'FREESHIP',
            'discount_type' => 'fixed',
            'discount_value' => 30000,
            'start_date' => now()->subDays(10),
            'end_date' => now()->addDays(20),
            'min_order_value' => 200000,
            'max_discount_value' => null,
            'is_active' => true,
        ]);

        Voucher::create([
            'code' => 'WELCOME',
            'discount_type' => 'percent',
            'discount_value' => 15,
            'start_date' => now()->subDays(60),
            'end_date' => now()->addDays(120),
            'min_order_value' => 100000,
            'max_discount_value' => 100000,
            'is_active' => true,
        ]);

        Voucher::create([
            'code' => 'BLACKFRIDAY',
            'discount_type' => 'percent',
            'discount_value' => 25,
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(10),
            'min_order_value' => 1500000,
            'max_discount_value' => 300000,
            'is_active' => false, // Chưa kích hoạt
        ]);

        Voucher::create([
            'code' => 'TETNGUYEN',
            'discount_type' => 'fixed',
            'discount_value' => 200000,
            'start_date' => now()->addDays(30),
            'end_date' => now()->addDays(40),
            'min_order_value' => 3000000,
            'max_discount_value' => null,
            'is_active' => false, // Chưa kích hoạt
        ]);

        Voucher::create([
            'code' => 'VIPMEMBER',
            'discount_type' => 'percent',
            'discount_value' => 5,
            'start_date' => now()->subDays(365),
            'end_date' => now()->addDays(365),
            'min_order_value' => 0,
            'max_discount_value' => 20000,
            'is_active' => true,
        ]);
    }
}
