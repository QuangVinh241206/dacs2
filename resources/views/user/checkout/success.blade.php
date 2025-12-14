@extends('layouts.user.master')
@section('content')
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4 max-w-3xl">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Đặt hàng thành công</h1>

                @if(session('error'))
                    <div class="mb-4 p-3 rounded bg-red-50 text-red-700">{{ session('error') }}</div>
                @endif
                @if(session('info'))
                    <div class="mb-4 p-3 rounded bg-blue-50 text-blue-700">{{ session('info') }}</div>
                @endif

                <div class="text-gray-700 space-y-2">
                    <div>Đơn hàng: <span class="font-semibold">#{{ $order->id }}</span></div>
                    <div>Tổng tiền: <span class="font-semibold">{{ number_format($order->total_price) }}₫</span></div>
                    <div>Phương thức thanh toán:
                        <span class="font-semibold">
                            @if($order->payment_method === 'cod')
                                Thanh toán khi nhận hàng
                            @else
                                Chuyển khoản QR
                            @endif
                        </span>
                    </div>
                    <div>Trạng thái: <span id="order-status" class="font-semibold">{{ $order->order_status == 'pending' ? 'Chờ xác nhận' : $order->order_status }}</span></div>
                </div>

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('user.orders.show', ['order' => $order->id]) }}"
                        class="bg-primary text-white px-5 py-2 rounded-button hover:bg-blue-600 transition">
                        Xem chi tiết đơn
                    </a>
                    <a href="{{ route('user.products') }}"
                        class="bg-gray-500 text-white px-5 py-2 rounded-button hover:bg-gray-600 transition">
                        Tiếp tục mua sắm
                    </a>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            (function () {
                const paymentMethod = @json($order->payment_method);
                const currentStatus = @json($order->order_status);
                if (paymentMethod !== 'qr' || currentStatus === 'paid') return;

                function pollStatus() {
                    fetch('{{ route('user.checkout.status', ['order' => $order->id]) }}', {
                        headers: { 'Accept': 'application/json' },
                        credentials: 'same-origin'
                    })
                        .then(r => r.json())
                        .then(data => {
                            if (!data || !data.order_status) return;
                            document.getElementById('order-status').textContent = data.order_status;
                            if (data.order_status === 'paid') {
                                // Refresh to clear "đang chờ" messages and show final status.
                                window.location.href = '{{ route('user.checkout.success', ['order' => $order->id]) }}';
                            }
                        })
                        .catch(() => { });
                }

                setInterval(pollStatus, 3000);
            })();
        </script>
    @endpush
@endsection