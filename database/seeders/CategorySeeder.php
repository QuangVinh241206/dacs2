<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $names = [
            'Giường ngủ gỗ',
            'Giường thông minh',
            'Giường sắt',
            'Giường tầng',
            'Giường trẻ em',
        ];

        foreach ($names as $name) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => $name . ' chất lượng tốt',
            ]);
        }
    }
}
