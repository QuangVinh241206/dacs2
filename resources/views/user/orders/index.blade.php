@extends('layouts.user.master')
@section('content')
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Theo dõi đơn hàng</h1>

                <form method="GET" action="{{ route('user.orders.index') }}" class="flex gap-2 items-center">
                    <label class="text-sm font-medium text-gray-700">Trạng thái</label>
                    <select name="status" class="px-3 py-2 border border-gray-300 rounded-md">
                        @foreach($statuses as $value => $label)
                            <option value="{{ $value }}" @selected(request('status', '') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button type="submit"
                        class="bg-primary text-white px-4 py-2 rounded-button hover:bg-blue-600 transition">Lọc</button>
                </form>
            </div>

            @if(session('success'))
                <div class="mb-4 p-3 rounded bg-green-50 text-green-700">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-3 rounded bg-red-50 text-red-700">{{ session('error') }}</div>
            @endif

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mã đơn</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ngày đặt</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tổng tiền</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Trạng thái</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($orders as $order)
                                @php
                                    $canCancel = in_array($order->order_status, ['pending', 'processing', 'pending_payment'], true);
                                    $canReview = $order->order_status === 'completed';

                                    $statusClass = 'bg-gray-100 text-gray-800';
                                    if (in_array($order->order_status, ['pending', 'pending_payment'], true)) {
                                        $statusClass = 'bg-yellow-100 text-yellow-800';
                                    } elseif (in_array($order->order_status, ['processing', 'shipping'], true)) {
                                        $statusClass = 'bg-blue-100 text-blue-800';
                                    } elseif (in_array($order->order_status, ['paid', 'completed'], true)) {
                                        $statusClass = 'bg-green-100 text-green-800';
                                    } elseif ($order->order_status === 'cancelled') {
                                        $statusClass = 'bg-red-100 text-red-800';
                                    }
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ optional($order->created_at)->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ number_format($order->total_price) }}₫</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                                            {{ $statuses[$order->order_status] ?? $order->order_status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right space-x-2">
                                        <a href="{{ route('user.orders.show', ['order' => $order->id]) }}"
                                            class="inline-block bg-gray-500 text-white px-3 py-2 rounded-button hover:bg-gray-600 transition">Chi
                                            tiết</a>

                                        @if($canReview)
                                            <a href="{{ route('user.orders.review', ['order' => $order->id]) }}"
                                                class="inline-block bg-primary text-white px-3 py-2 rounded-button hover:bg-blue-600 transition">Đánh
                                                giá</a>
                                        @endif

                                        @if($canCancel)
                                            <form method="POST" action="{{ route('user.orders.cancel', ['order' => $order->id]) }}"
                                                class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-block bg-red-600 text-white px-3 py-2 rounded-button hover:bg-red-700 transition"
                                                    onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')">
                                                    Hủy
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-600">Chưa có đơn hàng nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection