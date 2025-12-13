<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'voucher', 'details']);

        // Search by order ID, receiver name, or phone
        if ($request->filled('q')) {
            $q = $request->get('q');
            $query->where(function ($s) use ($q) {
                $s->where('id', 'like', "%{$q}%")
                    ->orWhere('receiver_name', 'like', "%{$q}%")
                    ->orWhere('receiver_phone', 'like', "%{$q}%")
                    ->orWhereHas('user', function ($userQuery) use ($q) {
                        $userQuery->where('name', 'like', "%{$q}%")
                            ->orWhere('email', 'like', "%{$q}%");
                    });
            });
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== '') {
            $query->where('order_status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        // Get available statuses for filter dropdown
        $statuses = [
            'pending' => 'Chờ xác nhận',
            'processing' => 'Đang xử lý',
            'shipping' => 'Đang giao',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy',
            'pending_payment' => 'Chờ thanh toán',
            'paid' => 'Đã thanh toán'
        ];

        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        // Check if this is an AJAX request
        if (request()->ajax() || request()->has('ajax')) {
            $order->load(['user', 'voucher', 'details.product', 'details.variant']);

            $html = view('admin.orders.partials.modal-content', compact('order'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'order_id' => $order->id
            ]);
        }

        // Regular page load
        $order->load(['user', 'voucher', 'details.product', 'details.variant']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status via AJAX
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipping,completed,cancelled,pending_payment,paid',
        ]);

        $order->update(['order_status' => $request->status]);

        // Check if request is AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật trạng thái thành công',
                'status' => $order->order_status
            ]);
        }

        // Regular form submission - redirect back with success message
        return redirect()->back()->with('success', 'Trạng thái đơn hàng đã được cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Đơn hàng đã được xóa thành công');
    }

    /**
     * Display trashed orders.
     */
    public function trashed(Request $request)
    {
        $query = Order::onlyTrashed()->with(['user', 'voucher', 'details']);

        // Search by order ID, receiver name, or phone
        if ($request->filled('q')) {
            $q = $request->get('q');
            $query->where(function ($s) use ($q) {
                $s->where('id', 'like', "%{$q}%")
                    ->orWhere('receiver_name', 'like', "%{$q}%")
                    ->orWhere('receiver_phone', 'like', "%{$q}%")
                    ->orWhereHas('user', function ($userQuery) use ($q) {
                        $userQuery->where('name', 'like', "%{$q}%")
                            ->orWhere('email', 'like', "%{$q}%");
                    });
            });
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== '') {
            $query->where('order_status', $request->status);
        }

        $orders = $query->orderBy('deleted_at', 'desc')->paginate(20)->withQueryString();

        // Get available statuses for filter dropdown
        $statuses = [
            'pending' => 'Chờ xác nhận',
            'processing' => 'Đang xử lý',
            'shipping' => 'Đang giao',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy',
            'pending_payment' => 'Chờ thanh toán',
            'paid' => 'Đã thanh toán'
        ];

        return view('admin.orders.trashed', compact('orders', 'statuses'));
    }

    /**
     * Restore the specified trashed order.
     */
    public function restore($id)
    {
        $order = Order::onlyTrashed()->findOrFail($id);
        $order->restore();

        return redirect()->route('admin.orders.trashed')
            ->with('success', 'Đơn hàng đã được khôi phục thành công');
    }

    /**
     * Permanently delete the specified trashed order.
     */
    public function forceDelete($id)
    {
        $order = Order::onlyTrashed()->findOrFail($id);
        $order->forceDelete();

        return redirect()->route('admin.orders.trashed')
            ->with('success', 'Đơn hàng đã được xóa vĩnh viễn');
    }
}
