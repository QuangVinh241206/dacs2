<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckOrderTotals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-order-totals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kiểm tra tính chính xác của tổng giá trong đơn hàng';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orders = \App\Models\Order::with('details')->get();
        $allMatch = true;

        $this->info('Kiểm tra tổng giá đơn hàng...');
        $this->table(
            ['Order ID', 'Stored Total', 'Calculated Total', 'Match'],
            $orders->map(function ($order) use (&$allMatch) {
                $calculated = $order->details->sum(function ($detail) {
                    return $detail->price * $detail->quantity;
                });

                // Áp dụng voucher nếu có
                if ($order->voucher_id) {
                    $voucher = \App\Models\Voucher::find($order->voucher_id);
                    if ($voucher) {
                        if ($voucher->discount_type === 'percent') {
                            $discount = $calculated * ($voucher->discount_value / 100);
                            if ($voucher->max_discount_value) {
                                $discount = min($discount, $voucher->max_discount_value);
                            }
                        } else {
                            $discount = $voucher->discount_value;
                        }
                        $calculated -= $discount;
                    }
                }

                $calculated = max(0, $calculated);
                $match = $order->total_price == $calculated;
                $allMatch = $allMatch && $match;

                return [
                    $order->id,
                    number_format($order->total_price),
                    number_format($calculated),
                    $match ? '✓' : '✗'
                ];
            })
        );

        if ($allMatch) {
            $this->info('✅ Tất cả đơn hàng có tổng giá chính xác!');
        } else {
            $this->error('❌ Một số đơn hàng có tổng giá không chính xác!');
        }

        return $allMatch ? 0 : 1;
    }
}
