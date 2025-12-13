<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['details.product.images', 'details.variant', 'voucher'])
            ->where('user_id', Auth::id());

        if ($request->filled('status') && $request->status !== '') {
            $query->where('order_status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        $statuses = [
            '' => 'Tất cả',
            'pending' => 'Chờ xác nhận',
            'processing' => 'Đang xử lý',
            'shipping' => 'Đang giao',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy',
            'pending_payment' => 'Chờ thanh toán',
            'paid' => 'Đã thanh toán',
        ];

        return view('user.orders.index', compact('orders', 'statuses'));
    }

    public function show($id)
    {
        $order = Order::with(['details.product.images', 'details.variant'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('user.orders.show', compact('order'));
    }

    public function cancel(Request $request, $order)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($order);

        $cancellable = in_array($order->order_status, ['pending', 'processing', 'pending_payment'], true);
        if (!$cancellable) {
            return redirect()->route('user.orders.index')->with('error', 'Đơn hàng không thể hủy ở trạng thái hiện tại.');
        }

        $order->update(['order_status' => 'cancelled']);

        return redirect()->route('user.orders.index')->with('success', 'Đã hủy đơn hàng thành công.');
    }

    public function review($order)
    {
        $order = Order::with(['details.product.images', 'details.variant'])
            ->where('user_id', Auth::id())
            ->findOrFail($order);

        if ($order->order_status !== 'completed') {
            return redirect()->route('user.orders.show', ['order' => $order->id])
                ->with('error', 'Chỉ có thể đánh giá khi đơn hàng đã hoàn thành.');
        }

        return view('user.orders.review', compact('order'));
    }
}