<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Voucher;

use App\Services\PayOSService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        $selectedDetailIds = $request->input('selected_items', []);

        if (empty($selectedDetailIds)) {
            return redirect()->route('user.cart.index')->with('error', 'Vui lòng chọn sản phẩm để thanh toán.');
        }

        $user = Auth::user();
        $cart = $user->cart;

        if (!$cart) {
            return redirect()->route('user.cart.index')->with('error', 'Giỏ hàng trống.');
        }

        $items = $cart->items()->with('product', 'variant')->whereIn('id', $selectedDetailIds)->get();

        if ($items->isEmpty()) {
            return redirect()->route('user.cart.index')->with('error', 'Không tìm thấy sản phẩm đã chọn.');
        }

        return view('user.checkout', compact('items'));
    }

    public function validateVoucher(Request $request)
    {
        $request->validate([
            'selected_items' => ['required', 'array', 'min:1'],
            'selected_items.*' => ['integer'],
            'voucher_code' => ['nullable', 'string'],
        ]);

        $user = Auth::user();
        $cart = $user->cart;

        if (!$cart) {
            return response()->json([
                'ok' => false,
                'message' => 'Giỏ hàng trống.',
            ], 400);
        }

        $items = $cart->items()->with('product', 'variant')->whereIn('id', $request->input('selected_items'))->get();

        if ($items->isEmpty()) {
            return response()->json([
                'ok' => false,
                'message' => 'Không tìm thấy sản phẩm đã chọn.',
            ], 400);
        }

        $subtotal = $items->sum(function ($item) {
            $price = $item->variant ? $item->variant->price : $item->product->price;
            return (int) $price * (int) $item->quantity;
        });

        $voucherCode = trim((string) $request->input('voucher_code'));
        $discount = 0;
        $message = null;

        if ($voucherCode !== '') {
            $voucher = Voucher::where('code', $voucherCode)->first();

            if (!$voucher) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Mã giảm giá không tồn tại.',
                    'subtotal' => $subtotal,
                    'discount' => 0,
                    'total' => $subtotal,
                ], 200);
            }

            $today = now()->toDateString();
            if (!$voucher->is_active || $today < $voucher->start_date || $today > $voucher->end_date) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Mã giảm giá không còn hiệu lực.',
                    'subtotal' => $subtotal,
                    'discount' => 0,
                    'total' => $subtotal,
                ], 200);
            }

            if ($voucher->min_order_value && $subtotal < (int) $voucher->min_order_value) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Đơn hàng chưa đạt giá trị tối thiểu để áp dụng mã.',
                    'subtotal' => $subtotal,
                    'discount' => 0,
                    'total' => $subtotal,
                ], 200);
            }

            if ($voucher->discount_type === 'percent') {
                $discount = (int) floor($subtotal * ((int) $voucher->discount_value) / 100);
                if ($voucher->max_discount_value) {
                    $discount = min($discount, (int) $voucher->max_discount_value);
                }
            } elseif ($voucher->discount_type === 'fixed') {
                $discount = (int) $voucher->discount_value;
            }

            $discount = max(0, min($discount, $subtotal));
            $message = 'Áp dụng mã giảm giá thành công.';
        }

        return response()->json([
            'ok' => true,
            'message' => $message,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => max(0, $subtotal - $discount),
        ]);
    }

    public function store(Request $request, PayOSService $payos)
    {
        $validated = $request->validate([
            'selected_items' => ['required', 'array', 'min:1'],
            'selected_items.*' => ['integer'],
            'voucher_code' => ['nullable', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:1000'],
            'payment_method' => ['required', 'in:cod,bank_transfer'],
        ]);

        $user = Auth::user();
        $cart = $user->cart;

        if (!$cart) {
            return redirect()->route('user.cart.index')->with('error', 'Giỏ hàng trống.');
        }

        $items = $cart->items()->with('product', 'variant')->whereIn('id', $validated['selected_items'])->get();

        if ($items->isEmpty()) {
            return redirect()->route('user.cart.index')->with('error', 'Không tìm thấy sản phẩm đã chọn.');
        }

        $subtotal = $items->sum(function ($item) {
            $price = $item->variant ? $item->variant->price : $item->product->price;
            return (int) $price * (int) $item->quantity;
        });

        $voucherId = null;
        $discount = 0;
        $voucherCode = trim((string) ($validated['voucher_code'] ?? ''));
        if ($voucherCode !== '') {
            $voucher = Voucher::where('code', $voucherCode)->first();
            if ($voucher) {
                $today = now()->toDateString();
                $isValid = $voucher->is_active
                    && $today >= $voucher->start_date
                    && $today <= $voucher->end_date
                    && (!$voucher->min_order_value || $subtotal >= (int) $voucher->min_order_value);

                if ($isValid) {
                    $voucherId = $voucher->id;
                    if ($voucher->discount_type === 'percent') {
                        $discount = (int) floor($subtotal * ((int) $voucher->discount_value) / 100);
                        if ($voucher->max_discount_value) {
                            $discount = min($discount, (int) $voucher->max_discount_value);
                        }
                    } elseif ($voucher->discount_type === 'fixed') {
                        $discount = (int) $voucher->discount_value;
                    }
                }
            }
        }
        $discount = max(0, min($discount, $subtotal));
        $total = max(0, $subtotal - $discount);

        try {
            $result = DB::transaction(function () use ($validated, $user, $items, $voucherId, $total) {
                $order = Order::create([
                    'user_id' => $user->id,
                    'order_date' => now(),
                    'total_price' => $total,
                    'voucher_id' => $voucherId,
                    'shipping_address' => $validated['address'],
                    'order_status' => $validated['payment_method'] === 'qr' ? 'pending_payment' : 'pending',
                    'payment_method' => $validated['payment_method'],
                    'receiver_name' => $validated['name'],
                    'receiver_phone' => $validated['phone'],
                ]);

                foreach ($items as $item) {
                    $variantName = $item->variant
                        ? trim(($item->variant->size ?? '') . ' - ' . ($item->variant->color ?? ''), ' -')
                        : null;

                    $price = (int) ($item->variant ? $item->variant->price : $item->product->price);

                    $variantId = $item->variant_id;
                    if (!$variantId) {
                        $variantId = $item->product?->variants()?->value('id');
                    }
                    if (!$variantId) {
                        throw new \RuntimeException('Sản phẩm chưa có biến thể để tạo đơn hàng.');
                    }

                    OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'variant_id' => $variantId,
                        'product_name' => $item->product->name,
                        'variant_name' => $variantName,
                        'price' => $price,
                        'quantity' => (int) $item->quantity,
                    ]);
                    if ($item->variant) {
                        $item->variant->decrementStock((int) $item->quantity);
                    }

                }

                $cartDetailIds = $items->pluck('id')->all();
                $user->cart->items()->whereIn('id', $cartDetailIds)->delete();

                return $order;
            });
        } catch (\Throwable $e) {
            Log::error('Checkout store failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
            return redirect()->route('user.cart.index')->with('error', 'Đặt hàng thất bại. Vui lòng thử lại.');
        }

        $order = $result;

        if ($validated['payment_method'] === 'cod') {
            return redirect()->route('user.checkout.success', ['order' => $order->id]);
        }

        try {
            $returnUrl = route('user.payos.return', ['order' => $order->id]);
            $cancelUrl = route('user.payos.cancel', ['order' => $order->id]);
            $payment = $payos->createPaymentRequest(
                orderCode: (int) $order->id,
                amount: (int) $order->total_price,
                description: 'Thanh toan don hang #' . $order->id,
                returnUrl: $returnUrl,
                cancelUrl: $cancelUrl,
                buyerName: $order->receiver_name
            );

            $checkoutUrl = $payment['checkoutUrl'] ?? null;
            if (is_string($checkoutUrl) && $checkoutUrl !== '') {
                return redirect()->away($checkoutUrl);
            }

            // Fallback (if PayOS doesn't return checkoutUrl for some reason)
            return view('user.checkout.payos', [
                'order' => $order,
                'qrCode' => $payment['qrCode'] ?? null,
                'checkoutUrl' => null,
            ]);
        } catch (\Throwable $e) {
            Log::error('PayOS create payment request failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);
            $order->update(['order_status' => 'payment_failed']);
            return redirect()->route('user.checkout.success', ['order' => $order->id])
                ->with('error', 'Không thể tạo thanh toán QR. Bạn có thể chọn COD.');
        }
    }

    public function success(Request $request, $order)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($order);
        return view('user.checkout.success', compact('order'));
    }

    public function status($order)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($order);
        return response()->json([
            'ok' => true,
            'order_status' => $order->order_status,
            'payment_method' => $order->payment_method,
        ]);
    }

    public function payosReturn(Request $request, PayOSService $payos, $order)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($order);

        if ($order->order_status !== 'paid') {
            // If webhook isn't configured or arrives late, confirm directly with PayOS here.
            try {
                $info = $payos->getPaymentRequest((int) $order->id);
                if ($payos->isPaidResponse($info)) {
                    $order->update(['order_status' => 'paid']);
                }
            } catch (\Throwable $e) {
                Log::warning('PayOS return check failed', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        if ($order->order_status === 'paid') {
            return redirect()->route('user.checkout.success', ['order' => $order->id]);
        }

        return redirect()->route('user.checkout.success', ['order' => $order->id])
            ->with('info', 'Đang chờ xác nhận thanh toán. Nếu bạn đã thanh toán, vui lòng đợi trong giây lát.');
    }

    public function payosCancel(Request $request, $order)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($order);
        $isQr = $order->payment_method === 'qr';
        $isUnpaid = !in_array($order->order_status, ['paid', 'completed'], true);
        if ($isQr && $isUnpaid) {
            $order->update(['order_status' => 'cancelled']);
        }
        return redirect()->route('user.checkout.success', ['order' => $order->id])
            ->with('error', 'Bạn đã hủy thanh toán QR.');
    }

    public function payosWebhook(Request $request)
    {
        // Best-effort verification (PayOS docs vary by integration); keep logs to help debug.
        $checksumKey = config('payos.checksum_key');
        $raw = $request->getContent();
        $signature = (string) ($request->input('signature') ?? $request->header('x-signature') ?? '');

        if ($checksumKey && $signature) {
            $computed = hash_hmac('sha256', $raw, $checksumKey);
            if (!hash_equals($computed, $signature)) {
                Log::warning('PayOS webhook signature mismatch', [
                    'signature' => $signature,
                    'computed' => $computed,
                ]);
            }
        }

        $data = $request->input('data', []);
        $orderCode = $data['orderCode']
            ?? $data['order_code']
            ?? $request->input('orderCode')
            ?? $request->input('order_code');

        $status = $data['status']
            ?? $data['paymentStatus']
            ?? $data['transactionStatus']
            ?? $request->input('status')
            ?? $request->input('paymentStatus')
            ?? $request->input('transactionStatus');

        $code = $data['code'] ?? $request->input('code');

        Log::info('PayOS webhook received', [
            'orderCode' => $orderCode,
            'status' => $status,
            'code' => $code,
        ]);

        $orderCodeInt = (int) $orderCode;
        if ($orderCodeInt <= 0) {
            return response()->json(['ok' => false], 400);
        }

        $order = Order::find($orderCodeInt);
        if (!$order) {
            return response()->json(['ok' => false], 404);
        }

        // Normalize status
        $normalized = is_string($status) ? strtolower(trim($status)) : null;
        $isPaid = in_array($normalized, ['paid', 'success', 'succeeded', '00', '2', 'completed'], true);
        if (is_string($code) && trim($code) === '00') {
            $isPaid = true;
        }
        if (is_bool($status) && $status === true) {
            $isPaid = true;
        }

        if ($isPaid) {
            $order->update(['order_status' => 'paid']);
        }

        return response()->json(['ok' => true]);
    }

}