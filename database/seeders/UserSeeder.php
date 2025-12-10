<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo admin
        User::create([
            'name' => 'Quản trị viên',
            'email' => 'admin@example.com',
            'phone' => '0123456789',
            'address' => '123 Đường ABC, Quận 1, TP.HCM',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);

        // Tạo user thường
        User::create([
            'name' => 'Nguyễn Văn An',
            'email' => 'nguyenvanan@example.com',
            'phone' => '0987654321',
            'address' => '456 Đường XYZ, Quận 2, TP.HCM',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Trần Thị Bình',
            'email' => 'tranthibinh@example.com',
            'phone' => '0912345678',
            'address' => '789 Đường DEF, Quận 3, TP.HCM',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Lê Văn Cường',
            'email' => 'levancuong@example.com',
            'phone' => '0934567890',
            'address' => '321 Đường GHI, Quận 4, TP.HCM',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Phạm Thị Dung',
            'email' => 'phamthidung@example.com',
            'phone' => '0956789012',
            'address' => '654 Đường JKL, Quận 5, TP.HCM',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Hoàng Văn Em',
            'email' => 'hoangvanem@example.com',
            'phone' => '0978901234',
            'address' => '987 Đường MNO, Quận 6, TP.HCM',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Đỗ Thị Phương',
            'email' => 'dothiphuong@example.com',
            'phone' => '0990123456',
            'address' => '147 Đường PQR, Quận 7, TP.HCM',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Vũ Văn Giang',
            'email' => 'vuvangiang@example.com',
            'phone' => '0923456789',
            'address' => '258 Đường STU, Quận 8, TP.HCM',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Bùi Thị Hoa',
            'email' => 'buithihoa@example.com',
            'phone' => '0945678901',
            'address' => '369 Đường VWX, Quận 9, TP.HCM',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Ngô Văn Huy',
            'email' => 'ngovanhuy@example.com',
            'phone' => '0967890123',
            'address' => '741 Đường YZA, Quận 10, TP.HCM',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
