@extends('layouts.user.master')
@section('content')
    <!-- Hero Section -->
    <section class="hero-section w-full h-[500px] flex items-center">
        <div class="container mx-auto px-4">
            <div class="max-w-lg">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Nâng tầm không gian nghỉ ngơi của bạn</h1>
                <p class="text-lg text-gray-700 mb-8">Khám phá bộ sưu tập giường ngủ cao cấp với thiết kế hiện đại, chất
                    liệu bền bỉ và giá cả hợp lý.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('user.products') }}"
                        class="bg-primary text-white px-6 py-3 rounded-button font-medium hover:bg-blue-600 transition shadow-md whitespace-nowrap">Mua ngay</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Danh mục sản phẩm</h2>
                <p class="text-gray-600">Lựa chọn đa dạng phù hợp với mọi phong cách và không gian</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @php
                    $icons = ['ri-home-line', 'ri-layout-2-line', 'ri-settings-line', 'ri-hotel-bed-line'];
                @endphp
                @foreach($topCategories as $index => $cat)
                    <a href="{{ route('user.products', ['category_id' => $cat->id]) }}" class="block">
                        <div class="bg-gray-50 rounded-lg p-6 text-center hover:shadow-md transition">
                            <div
                                class="w-16 h-16 mx-auto mb-4 flex items-center justify-center bg-blue-50 rounded-full text-primary">
                                <i class="{{ $icons[$index % count($icons)] }} ri-2x"></i>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-1">{{ $cat->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $cat->products_count }} sản phẩm</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Discounts Row -->
    <section class="pt-5 pb-6 m-5 rounded-2xl bg-yellow-300">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Sản phẩm đang giảm giá</h2>
                    <p class="text-gray-600 text-sm">Chọn lựa những sản phẩm có khuyến mãi tốt nhất</p>
                </div>
            </div>

            <div class="relative">
                {{-- Hidden source with full set (15) --}}
                <div id="discount-source" class="hidden">
                    @include('user.partials.products_row', ['products' => $discounts])
                </div>

                {{-- Visible container: will be rendered via JS (show 5 per page) --}}
                <div id="discounts-row" class="overflow-hidden transition-all duration-300">
                    @include('user.partials.products_row', ['products' => $discounts->take(5)])
                </div>

                <button id="discount-prev" aria-label="Previous discounts"
                    class="absolute left-2 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full flex items-center justify-center bg-white shadow-md hover:bg-gray-100 z-10 pointer-events-auto">
                    <i class="ri-arrow-left-s-line"></i>
                </button>
                <button id="discount-next" aria-label="Next discounts"
                    class="absolute right-2 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full flex items-center justify-center bg-white shadow-md hover:bg-gray-100 z-10 pointer-events-auto">
                    <i class="ri-arrow-right-s-line"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- New arrivals Row -->
    <section class="pt-5 pb-6 m-5 rounded-2xl bg-cyan-200">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Sản phẩm mới</h2>
                    <p class="text-gray-600 text-sm">Sản phẩm mới nhất vừa về kho</p>
                </div>
            </div>

            <div class="relative">
                {{-- Hidden source with full set (15) --}}
                <div id="new-source" class="hidden">
                    @include('user.partials.products_row', ['products' => $newArrivals])
                </div>

                {{-- Visible container: will be rendered via JS (show 5 per page) --}}
                <div id="new-row" class="overflow-hidden transition-all duration-300">
                    @include('user.partials.products_row', ['products' => $newArrivals->take(5)])
                </div>

                <button id="new-prev" aria-label="Previous new arrivals"
                    class="absolute left-2 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full flex items-center justify-center bg-white shadow-md hover:bg-gray-100 z-10 pointer-events-auto">
                    <i class="ri-arrow-left-s-line"></i>
                </button>
                <button id="new-next" aria-label="Next new arrivals"
                    class="absolute right-2 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full flex items-center justify-center bg-white shadow-md hover:bg-gray-100 z-10 pointer-events-auto">
                    <i class="ri-arrow-right-s-line"></i>
                </button>
            </div>
        </div>
    </section>





    <!-- Features Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 flex items-center justify-center bg-blue-50 rounded-full text-primary mb-4">
                        <i class="ri-truck-line ri-2x"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Giao hàng miễn phí</h3>
                    <p class="text-gray-600 text-sm">Miễn phí giao hàng cho đơn hàng từ 5 triệu đồng trong phạm vi 30km</p>
                </div>

                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 flex items-center justify-center bg-blue-50 rounded-full text-primary mb-4">
                        <i class="ri-shield-check-line ri-2x"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Bảo hành 5 năm</h3>
                    <p class="text-gray-600 text-sm">Cam kết bảo hành chính hãng lên đến 5 năm cho mọi sản phẩm</p>
                </div>

                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 flex items-center justify-center bg-blue-50 rounded-full text-primary mb-4">
                        <i class="ri-exchange-line ri-2x"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Đổi trả 30 ngày</h3>
                    <p class="text-gray-600 text-sm">Chính sách đổi trả linh hoạt trong vòng 30 ngày nếu không hài lòng</p>
                </div>

                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 flex items-center justify-center bg-blue-50 rounded-full text-primary mb-4">
                        <i class="ri-customer-service-2-line ri-2x"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Hỗ trợ 24/7</h3>
                    <p class="text-gray-600 text-sm">Đội ngũ tư vấn viên luôn sẵn sàng hỗ trợ bạn mọi lúc mọi nơi</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Khách hàng nói gì về chúng tôi</h2>
                <p class="text-gray-600">Những đánh giá chân thực từ khách hàng đã mua sản phẩm</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex text-yellow-400 mb-4">
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                    </div>
                    <p class="text-gray-700 mb-6">"Tôi rất hài lòng với chiếc giường gỗ sồi mà tôi đã mua. Chất lượng vượt
                        xa mong đợi, gỗ rất chắc chắn và thiết kế rất đẹp. Nhân viên giao hàng cũng rất chuyên nghiệp và lắp
                        đặt cẩn thận."</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 mr-4">
                            <i class="ri-user-line ri-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Nguyễn Thanh Tùng</h4>
                            <p class="text-sm text-gray-500">Hà Nội</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex text-yellow-400 mb-4">
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-half-fill"></i>
                    </div>
                    <p class="text-gray-700 mb-6">"Giường tầng cho con tôi rất chắc chắn và an toàn. Các góc cạnh được bo
                        tròn cẩn thận, thang leo lên xuống cũng rất vững. Các con tôi rất thích và tôi cũng yên tâm về độ an
                        toàn. Sẽ giới thiệu cho bạn bè."</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 mr-4">
                            <i class="ri-user-line ri-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Trần Minh Hương</h4>
                            <p class="text-sm text-gray-500">TP. Hồ Chí Minh</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex text-yellow-400 mb-4">
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-line"></i>
                    </div>
                    <p class="text-gray-700 mb-6">"Giường thông minh kết hợp bàn làm việc là một lựa chọn tuyệt vời cho căn
                        hộ nhỏ của tôi. Tiết kiệm không gian đáng kể và chất lượng rất tốt. Cơ chế gập mở hoạt động trơn
                        tru. Rất đáng đồng tiền bát gạo."</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 mr-4">
                            <i class="ri-user-line ri-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Lê Văn Hoàng</h4>
                            <p class="text-sm text-gray-500">Đà Nẵng</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection

@push('scripts')
    <script>
        (function () {
            // Client-side pager: uses the hidden full source (15 items) and shows 5 per page
            function clientPager(sectionId, sourceId, prevId, nextId) {
                var container = document.getElementById(sectionId);
                var source = document.getElementById(sourceId);
                var prev = document.getElementById(prevId);
                var next = document.getElementById(nextId);
                var perPage = 5;

                if (!container || !source) return;

                // product wrappers live inside the source's flex container
                var flex = source.querySelector(':scope > .flex') || source.querySelector('.flex');
                var wrappers = flex ? Array.from(flex.children) : [];
                var total = wrappers.length;
                var totalPages = Math.max(1, Math.ceil(total / perPage));
                var page = 1;

                function renderPage(p) {
                    var start = (p - 1) * perPage;
                    var end = start + perPage;

                    // fade out
                    container.classList.add('opacity-0', '-translate-x-2');

                    setTimeout(function () {
                        // build new flex row
                        var newFlex = document.createElement('div');
                        newFlex.className = 'flex items-center justify-center gap-4 overflow-hidden';

                        for (var i = start; i < end && i < total; i++) {
                            newFlex.appendChild(wrappers[i].cloneNode(true));
                        }

                        container.innerHTML = '';
                        container.appendChild(newFlex);

                        // fade in
                        container.classList.remove('opacity-0', '-translate-x-2');

                        // hide buttons when not applicable
                        if (prev) prev.style.display = (p <= 1 ? 'none' : 'flex');
                        if (next) next.style.display = (p >= totalPages ? 'none' : 'flex');
                    }, 220);
                }

                if (prev) prev.addEventListener('click', function (e) { e && e.preventDefault(); if (page > 1) { page--; renderPage(page); } });
                if (next) next.addEventListener('click', function (e) { e && e.preventDefault(); if (page < totalPages) { page++; renderPage(page); } });

                // initial render
                renderPage(1);
            }

            clientPager('discounts-row', 'discount-source', 'discount-prev', 'discount-next');
            clientPager('new-row', 'new-source', 'new-prev', 'new-next');
        })();
    </script>
@endpush