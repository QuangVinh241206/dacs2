<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('vi_VN');

        $categories = Category::all();
        if ($categories->count() == 0) {
            $this->command->info('No categories found, skipping product seeding.');
            return;
        }

        for ($i = 1; $i <= 50; $i++) {
            $name = 'Giường ' . $faker->word() . ' ' . $i;
            $category = $categories->random();
            $materials = ['Gỗ', 'Sắt', 'Thép', 'Nhựa'];
            $warranties = ['6 tháng', '1 năm', '2 năm', '3 năm', 'Không bảo hành'];

            $product = Product::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => $faker->sentence(12),
                'category_id' => $category->id,
                'discount_percent' => $faker->numberBetween(0, 40),
                'weight_capacity' => $faker->numberBetween(10, 200).' kg',
                'material' => $materials[array_rand($materials)],
                'warranty' => $warranties[array_rand($warranties)],
                'status' => 1,
            ]);

            // create 3 variants
            $sizes = ['120x200', '140x200', '160x200'];
            $colors = ['Trắng', 'Đen', 'Nâu', 'Xanh', 'Ghi'];
            $basePrice = $faker->numberBetween(1500000, 8000000);

            foreach ($sizes as $idx => $size) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'size' => $size,
                    'color' => $colors[array_rand($colors)],
                    'price' => $basePrice + ($idx * 500000),
                    'stock' => $faker->numberBetween(0, 50),
                    'sku' => 'SKU-' . strtoupper(Str::random(6)) . '-' . $i . '-' . ($idx + 1),
                ]);
            }
        }
    }
}
