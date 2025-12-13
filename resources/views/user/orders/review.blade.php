@extends('layouts.user.master')
@section('content')
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4 max-w-4xl">
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('user.orders.index') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary transition-colors duration-200">
                            <i class="ri-file-list-3-line mr-1"></i>
                            Theo dõi đơn hàng
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="ri-arrow-right-s-line text-gray-400 mx-1"></i>
                            <span class="text-sm font-medium text-gray-500">Đánh giá đơn #{{ $order->id }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            @if(session('success'))
                <div class="mb-4 p-3 rounded bg-green-50 text-green-700">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-3 rounded bg-red-50 text-red-700">{{ session('error') }}</div>
            @endif

            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900">Đánh giá sản phẩm</h1>
                    <a href="{{ route('user.orders.show', ['order' => $order->id]) }}"
                        class="text-primary hover:text-blue-700">Xem chi tiết đơn</a>
                </div>
                <p class="text-gray-600 mt-2">Chỉ các đơn hàng trạng thái <span class="font-medium">Hoàn thành</span> mới
                    được đánh giá.</p>
            </div>

            <div class="space-y-6">
                @foreach($order->details as $detail)
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('storage/' . ($detail->product->images->where('is_main', true)->first()->image_url ?? 'placeholder.jpg')) }}"
                                class="w-20 h-20 object-cover rounded"
                                alt="{{ $detail->product_name ?? $detail->product->name }}">
                            <div class="flex-1">
                                <div class="font-semibold text-gray-900">{{ $detail->product_name ?? $detail->product->name }}
                                </div>
                                @if($detail->variant_name)
                                    <div class="text-sm text-gray-600">{{ $detail->variant_name }}</div>
                                @endif
                            </div>
                            <a href="{{ route('user.productDetail', $detail->product->slug) }}"
                                class="text-primary hover:text-blue-700">Xem sản phẩm</a>
                        </div>

                        <form method="POST" action="{{ route('user.reviews.store') }}" class="mt-4">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <input type="hidden" name="product_id" value="{{ $detail->product_id }}">
                            <input type="hidden" name="rating" value="5" data-rating-input="{{ $detail->product_id }}">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Số sao</label>
                                    <div class="flex items-center gap-1" data-rating-group="{{ $detail->product_id }}"
                                        aria-label="Chọn số sao">
                                        @for($i = 1; $i <= 5; $i++)
                                            <button type="button"
                                                class="rating-star ri-star-fill text-2xl text-yellow-400 hover:text-yellow-400 transition"
                                                data-rating-value="{{ $i }}" data-rating-group="{{ $detail->product_id }}"
                                                aria-label="{{ $i }} sao"></button>
                                        @endfor
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">Bấm vào sao để chọn (mặc định 5 sao).</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nhận xét</label>
                                    <input type="text" name="comment" class="w-full px-3 py-2 border border-gray-300 rounded-md"
                                        placeholder="Chia sẻ cảm nhận của bạn (tuỳ chọn)">
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit"
                                    class="bg-primary text-white px-5 py-2 rounded-button hover:bg-blue-600 transition">Gửi đánh
                                    giá</button>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            (function () {
                function setRating(group, rating) {
                    const stars = document.querySelectorAll('[data-rating-group="' + group + '"][data-rating-value]');
                    const input = document.querySelector('[data-rating-input="' + group + '"]');
                    if (!input) return;
                    input.value = String(rating);

                    stars.forEach(function (btn) {
                        const v = Number(btn.getAttribute('data-rating-value'));
                        if (v <= rating) {
                            btn.classList.remove('ri-star-line', 'text-gray-300');
                            btn.classList.add('ri-star-fill', 'text-yellow-400');
                        } else {
                            btn.classList.remove('ri-star-fill', 'text-yellow-400');
                            btn.classList.add('ri-star-line', 'text-gray-300');
                        }
                    });
                }

                document.addEventListener('click', function (e) {
                    const target = e.target;
                    if (!(target instanceof HTMLElement)) return;
                    if (!target.classList.contains('rating-star')) return;

                    const group = target.getAttribute('data-rating-group');
                    const value = Number(target.getAttribute('data-rating-value'));
                    if (!group || !value) return;

                    setRating(group, value);
                });

                // Initialize all groups to 5 stars
                const inputs = document.querySelectorAll('[data-rating-input]');
                inputs.forEach(function (input) {
                    const group = input.getAttribute('data-rating-input');
                    if (group) setRating(group, 5);
                });
            })();
        </script>
    @endpush
@endsection