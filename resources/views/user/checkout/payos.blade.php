@extends('layouts.user.master')
@section('content')
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4 max-w-3xl">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Thanh toán QR</h1>
                <p class="text-gray-600 mb-6">Đơn hàng #{{ $order->id }} • Số tiền: <span
                        class="font-semibold">{{ number_format($order->total_price) }}₫</span></p>

                @if(!$qrCode && !$checkoutUrl)
                    <div class="text-red-600">Không nhận được thông tin QR. Vui lòng thử lại hoặc chọn COD.</div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                        <div>
                            <div class="font-medium text-gray-800 mb-2">Quét mã QR để thanh toán</div>
                            <div id="qrcode" class="p-4 border rounded-lg inline-block bg-white"></div>
                            @if($qrCode)
                                <div class="mt-3 text-sm text-gray-500 break-all">{{ $qrCode }}</div>
                            @endif
                        </div>
                        <div class="space-y-3">
                            <div class="font-medium text-gray-800">Hoặc mở trang thanh toán</div>
                            @if($checkoutUrl)
                                <a href="{{ $checkoutUrl }}" target="_blank" rel="noopener"
                                    class="inline-block bg-primary text-white px-4 py-2 rounded-button hover:bg-blue-600 transition">
                                    Mở trang thanh toán
                                </a>
                            @endif
                            <div class="text-sm text-gray-600">
                                Sau khi thanh toán thành công, hệ thống sẽ tự chuyển sang trang đặt hàng thành công.
                            </div>
                            <a href="{{ route('user.payos.cancel', ['order' => $order->id]) }}"
                                class="inline-block text-red-600 hover:text-red-800">
                                Hủy thanh toán
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
        <script>
            (function () {
                const qrText = @json($qrCode);
                if (qrText) {
                    new QRCode(document.getElementById('qrcode'), {
                        text: qrText,
                        width: 220,
                        height: 220,
                        correctLevel: QRCode.CorrectLevel.M
                    });
                }

                function pollStatus() {
                    fetch('{{ route('user.checkout.status', ['order' => $order->id]) }}', {
                        headers: { 'Accept': 'application/json' },
                        credentials: 'same-origin'
                    })
                        .then(r => r.json())
                        .then(data => {
                            if (data && data.order_status === 'paid') {
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