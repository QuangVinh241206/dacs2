<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\Voucher;
use App\Models\Product;
use App\Models\OrderDetail;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $vouchers = Voucher::where('is_active', true)->get();

        // Tạo orders với thông tin cơ bản
        $ordersData = [
            [
                'user_id' => $users->random()->id,
                'order_date' => now()->subDays(30),
                'voucher_id' => $vouchers->random()->id,
                'shipping_address' => '456 Đường XYZ, Quận 2, TP.HCM',
                'order_status' => 'completed',
                'payment_method' => 'COD',
                'receiver_name' => 'Nguyễn Văn An',
                'receiver_phone' => '0987654321',
            ],
            [
                'user_id' => $users->random()->id,
                'order_date' => now()->subDays(25),
                'voucher_id' => null,
                'shipping_address' => '789 Đường DEF, Quận 3, TP.HCM',
                'order_status' => 'completed',
                'payment_method' => 'bank_transfer',
                'receiver_name' => 'Trần Thị Bình',
                'receiver_phone' => '0912345678',
            ],
            [
                'user_id' => $users->random()->id,
                'order_date' => now()->subDays(20),
                'voucher_id' => $vouchers->random()->id,
                'shipping_address' => '321 Đường GHI, Quận 4, TP.HCM',
                'order_status' => 'completed',
                'payment_method' => 'momo',
                'receiver_name' => 'Lê Văn Cường',
                'receiver_phone' => '0934567890',
            ],
            [
                'user_id' => $users->random()->id,
                'order_date' => now()->subDays(5),
                'voucher_id' => $vouchers->random()->id,
                'shipping_address' => '654 Đường JKL, Quận 5, TP.HCM',
                'order_status' => 'processing',
                'payment_method' => 'COD',
                'receiver_name' => 'Phạm Thị Dung',
                'receiver_phone' => '0956789012',
            ],
            [
                'user_id' => $users->random()->id,
                'order_date' => now()->subDays(3),
                'voucher_id' => null,
                'shipping_address' => '987 Đường MNO, Quận 6, TP.HCM',
                'order_status' => 'processing',
                'payment_method' => 'bank_transfer',
                'receiver_name' => 'Hoàng Văn Em',
                'receiver_phone' => '0978901234',
            ],
            [
                'user_id' => $users->random()->id,
                'order_date' => now()->subDays(2),
                'voucher_id' => $vouchers->random()->id,
                'shipping_address' => '147 Đường PQR, Quận 7, TP.HCM',
                'order_status' => 'shipping',
                'payment_method' => 'momo',
                'receiver_name' => 'Đỗ Thị Phương',
                'receiver_phone' => '0990123456',
            ],
            [
                'user_id' => $users->random()->id,
                'order_date' => now()->subDays(15),
                'voucher_id' => null,
                'shipping_address' => '258 Đường STU, Quận 8, TP.HCM',
                'order_status' => 'cancelled',
                'payment_method' => 'COD',
                'receiver_name' => 'Vũ Văn Giang',
                'receiver_phone' => '0923456789',
            ],
            [
                'user_id' => $users->random()->id,
                'order_date' => now()->subHours(12),
                'voucher_id' => $vouchers->random()->id,
                'shipping_address' => '369 Đường VWX, Quận 9, TP.HCM',
                'order_status' => 'pending',
                'payment_method' => 'bank_transfer',
                'receiver_name' => 'Bùi Thị Hoa',
                'receiver_phone' => '0945678901',
            ],
            [
                'user_id' => $users->random()->id,
                'order_date' => now()->subHours(6),
                'voucher_id' => null,
                'shipping_address' => '741 Đường YZA, Quận 10, TP.HCM',
                'order_status' => 'pending',
                'payment_method' => 'momo',
                'receiver_name' => 'Ngô Văn Huy',
                'receiver_phone' => '0967890123',
            ],
            [
                'user_id' => $users->random()->id,
                'order_date' => now()->subHours(1),
                'voucher_id' => $vouchers->random()->id,
                'shipping_address' => '852 Đường BCD, Quận 11, TP.HCM',
                'order_status' => 'pending',
                'payment_method' => 'COD',
                'receiver_name' => 'Trần Văn Minh',
                'receiver_phone' => '0981122334',
            ],
        ];

        // Tạo orders với total_price tạm thời = 0
        $orders = [];
        foreach ($ordersData as $orderData) {
            $order = Order::create(array_merge($orderData, ['total_price' => 0]));
            $orders[] = $order;
        }

        // Tạo order details và tính tổng cho mỗi order
        $products = Product::with('variants')->get();

        foreach ($orders as $order) {
            $totalPrice = 0;
            $numItems = rand(1, 3);

            for ($i = 0; $i < $numItems; $i++) {
                $product = $products->random();
                $variant = $product->variants->random();

                $quantity = rand(1, 3);
                $itemTotal = $variant->price * $quantity;

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'variant_id' => $variant->id,
                    'product_name' => $product->name,
                    'variant_name' => $variant->size ? "Size {$variant->size}" . ($variant->color ? " - {$variant->color}" : "") : ($variant->color ?? null),
                    'price' => $variant->price,
                    'quantity' => $quantity,
                ]);

                $totalPrice += $itemTotal;
            }

            // Áp dụng voucher nếu có
            if ($order->voucher_id) {
                $voucher = Voucher::find($order->voucher_id);
                if ($voucher) {
                    if ($voucher->discount_type === 'percent') {
                        $discount = $totalPrice * ($voucher->discount_value / 100);
                        if ($voucher->max_discount_value) {
                            $discount = min($discount, $voucher->max_discount_value);
                        }
                    } else {
                        $discount = $voucher->discount_value;
                    }
                    $totalPrice -= $discount;
                }
            }

            // Cập nhật total_price chính xác
            $order->update(['total_price' => max(0, $totalPrice)]);
        }
    }
}
