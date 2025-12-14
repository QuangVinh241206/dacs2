@extends('layouts.user.master')
@section('content')
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4 max-w-4xl">
            <!-- Breadcrumb -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}"
                           class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary transition-colors duration-200">
                            <i class="ri-home-line mr-1"></i>
                            Trang chủ
                        </a>
                    </li>
                    <li class="inline-flex items-center">
                        <a href="{{ route('user.orders.index') }}"
                           class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary transition-colors duration-200">
                           <i class="ri-arrow-right-s-line text-gray-400 mx-1"></i> 
                           <i class="ri-file-list-3-line mr-1"></i>
                            Theo dõi đơn hàng
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="ri-arrow-right-s-line text-gray-400 mx-1"></i>
                            <span class="text-sm font-medium text-gray-500">Đơn hàng #{{ $order->id }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Order Status -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h1 class="text-2xl font-bold text-gray-900">Đơn hàng #{{ $order->id }}</h1>
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        @if($order->order_status === 'pending' || $order->order_status === 'pending_payment') bg-yellow-100 text-yellow-800
                        @elseif($order->order_status === 'paid') bg-green-100 text-green-800
                        @elseif($order->order_status === 'cancelled') bg-red-100 text-red-800
                        @elseif($order->order_status === 'processing') bg-blue-100 text-blue-800
                        @elseif($order->order_status === 'shipping') bg-blue-100 text-blue-800
                        @elseif($order->order_status === 'completed') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800 @endif">
                        @switch($order->order_status)
                            @case('pending')
                                Chờ xác nhận
                                @break
                            @case('pending_payment')
                                Chờ thanh toán
                                @break
                            @case('paid')
                                Đã thanh toán
                                @break
                            @case('completed')
                                Hoàn thành
                                @break
                            @case('processing')
                                Đang xử lý
                                @break
                            @case('shipping')
                                Đang giao
                                @break
                            @case('cancelled')
                                Đã hủy
                                @break
                            @default
                                {{ $order->order_status }}
                        @endswitch
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Thông tin khách hàng</h3>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><strong>Họ tên:</strong> {{ $order->receiver_name }}</p>
                            <p><strong>Số điện thoại:</strong> {{ $order->receiver_phone }}</p>
                            <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Thông tin đơn hàng</h3>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><strong>Ngày đặt:</strong> {{ optional($order->created_at)->format('d/m/Y H:i') }}</p>
                            <p><strong>Phương thức thanh toán:</strong>
                                @if($order->payment_method === 'cod')
                                    Thanh toán khi nhận hàng
                                @else
                                    Chuyển khoản QR
                                @endif
                            </p>
                            @if($order->voucher)
                                <p><strong>Mã giảm giá:</strong> {{ $order->voucher->code }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Chi tiết sản phẩm</h2>
                <div class="space-y-4">
                    @php
                        $subtotal = $order->details->sum(fn($d) => (int) $d->price * (int) $d->quantity);
                        $discount = max(0, $subtotal - (int) $order->total_price);
                    @endphp
                    @foreach($order->details as $detail)
                        <div class="flex items-center space-x-4 border-b pb-4">
                            <img src="{{ asset('storage/' . ($detail->product->images->where('is_main', true)->first()->image_url ?? 'placeholder.jpg')) }}"
                                alt="{{ $detail->product->name }}" class="w-20 h-20 object-cover rounded">
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900">{{ $detail->product_name ?? $detail->product->name }}</h3>
                                @if($detail->variant_name)
                                    <p class="text-sm text-gray-600">{{ $detail->variant_name }}</p>
                                @elseif($detail->variant)
                                    <p class="text-sm text-gray-600">{{ $detail->variant->size }} - {{ $detail->variant->color }}</p>
                                @endif
                                <p class="text-sm text-gray-600">Số lượng: {{ $detail->quantity }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-900">{{ number_format($detail->price) }}₫</p>
                                <p class="text-sm text-gray-600">Tổng: {{ number_format((int)$detail->price * (int)$detail->quantity) }}₫</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 pt-4 border-t space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-medium text-gray-700">Tạm tính:</span>
                        <span class="text-lg text-gray-900">{{ number_format($subtotal) }}₫</span>
                    </div>
                    @if($discount > 0)
                        <div class="flex justify-between items-center text-green-600">
                            <span class="text-lg font-medium">Giảm giá:</span>
                            <span class="text-lg">-{{ number_format($discount) }}₫</span>
                        </div>
                    @endif
                    <div class="flex justify-between items-center border-t pt-2">
                        <span class="text-xl font-bold text-gray-700">Tổng tiền:</span>
                        <span class="text-2xl font-bold text-primary">{{ number_format($order->total_price) }}₫</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-center space-x-4">
                <a href="{{ route('user.products') }}"
                   class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                    Tiếp tục mua sắm
                </a>
            </div>
        </div>
    </section>
@endsection