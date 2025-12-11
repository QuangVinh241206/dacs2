@extends('layouts.user.master')

@section('title', 'Sản phẩm yêu thích')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section w-full h-[300px] flex items-center">
        <div class="container mx-auto px-4">
            <div class="max-w-lg">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Sản phẩm yêu thích</h1>
                <p class="text-lg text-gray-700">Danh sách các sản phẩm bạn đã yêu thích</p>
            </div>
        </div>
    </section>

    <!-- Favorites Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <form method="GET" action="{{ route('user.favorites.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm sản phẩm</label>
                    <input type="text"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
                        name="q" value="{{ request('q') }}" placeholder="Nhập tên sản phẩm...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Danh mục</label>
                    <select
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
                        name="category_id">
                        <option value="">Tất cả danh mục</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sắp xếp theo</label>
                    <select
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
                        name="sort">
                        <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>
                            Mới nhất
                        </option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                            Cũ nhất
                        </option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>
                            Tên A-Z
                        </option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>
                            Tên Z-A
                        </option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>
                            Giá thấp đến cao
                        </option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>
                            Giá cao đến thấp
                        </option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="flex-1 bg-primary text-white py-2 px-4 rounded-button font-medium hover:bg-blue-600 transition">
                        Tìm kiếm
                    </button>
                    <a href="{{ route('user.favorites.index') }}"
                        class="bg-gray-500 text-white py-2 px-4 rounded-button font-medium hover:bg-gray-600 transition">
                        Xóa
                    </a>
                </div>
            </form>
        </div>

        <!-- Favorites Count -->
        @if($favorites->total() > 0)
            <div class="mb-6">
                <p class="text-gray-600">
                    <i class="ri-heart-fill text-red-500 mr-2"></i>
                    Hiển thị {{ $favorites->firstItem() }}-{{ $favorites->lastItem() }} của {{ $favorites->total() }} sản phẩm
                </p>
            </div>
        @endif

        <!-- Products Grid -->
        @if($favorites->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($favorites as $favorite)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-1.5 transition cursor-pointer product-card"
                        onclick="window.location.href='{{ route('user.productDetail', $favorite->product->slug) }}'">
                        <!-- Product Image -->
                        <div class="relative h-56 bg-gray-100 overflow-hidden">
                            @if($favorite->product->images->count() > 0)
                                <img src="{{ asset('storage/' . $favorite->product->images->first()->image_path) }}"
                                    alt="{{ $favorite->product->name }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <i class="ri-image-line text-4xl"></i>
                                </div>
                            @endif

                            <!-- Favorite Button -->
                            <button
                                class="absolute top-3 right-3 w-8 h-8 bg-white bg-opacity-80 rounded-full flex items-center justify-center text-red-500 hover:bg-red-500 hover:text-white transition favorite-btn"
                                data-product-id="{{ $favorite->product->id }}" title="Bỏ yêu thích"
                                onclick="event.stopPropagation()">
                                <i class="ri-heart-fill"></i>
                            </button>

                            <!-- Status Badge -->
                            @if($favorite->product->status == 1)
                                <span class="absolute top-3 left-3 bg-green-500 text-white text-xs px-2 py-1 rounded-full">
                                    Còn hàng
                                </span>
                            @else
                                <span class="absolute top-3 left-3 bg-gray-500 text-white text-xs px-2 py-1 rounded-full">
                                    Hết hàng
                                </span>
                            @endif
                        </div>

                        <div class="p-4">
                            <!-- Category -->
                            <p class="text-sm text-gray-500 mb-1">
                                <i class="ri-price-tag-3-line mr-1"></i>
                                {{ $favorite->product->category->name ?? 'N/A' }}
                            </p>

                            <!-- Product Name -->
                            <h3 class="font-medium text-lg mb-2 line-clamp-2">
                                <a href="{{ route('user.productDetail', $favorite->product->slug) }}"
                                    class="text-gray-900 hover:text-primary transition">
                                    {{ $favorite->product->name }}
                                </a>
                            </h3>

                            <!-- Price -->
                            <div class="mb-3">
                                @if($favorite->product->variants->count() > 0)
                                    @php
                                        $minPrice = $favorite->product->variants->min('price');
                                        $maxPrice = $favorite->product->variants->max('price');
                                    @endphp
                                    @if($minPrice == $maxPrice)
                                        <div class="text-primary font-semibold text-lg">
                                            {{ number_format($minPrice, 0, ',', '.') }}₫
                                        </div>
                                    @else
                                        <div class="text-primary font-semibold text-lg">
                                            {{ number_format($minPrice, 0, ',', '.') }}₫ -
                                            {{ number_format($maxPrice, 0, ',', '.') }}₫
                                        </div>
                                    @endif
                                @else
                                    <div class="text-gray-500">Liên hệ</div>
                                @endif
                            </div>

                            <!-- Added Date -->
                            <div class="text-xs text-gray-500">
                                <i class="ri-calendar-line mr-1"></i>
                                Thêm: {{ $favorite->created_at->format('d/m/Y') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $favorites->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="mb-6">
                    <i class="ri-heart-line text-gray-300 text-8xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Chưa có sản phẩm yêu thích</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Bạn chưa thêm sản phẩm nào vào danh sách yêu thích.<br>
                    Hãy khám phá các sản phẩm của chúng tôi!
                </p>
                <a href="{{ route('user.products') }}"
                    class="inline-flex items-center bg-primary text-white py-3 px-6 rounded-button font-medium hover:bg-blue-600 transition">
                    <i class="ri-shopping-bag-line mr-2"></i>
                    Khám phá sản phẩm
                </a>
            </div>
        @endif
        </div>
    </section>

    <!-- Favorites Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Handle favorite toggle
            document.querySelectorAll('.favorite-btn').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const productId = this.dataset.productId;

                    // Disable button during request
                    this.disabled = true;
                    this.innerHTML = '<i class="ri-loader-4-line animate-spin"></i>';

                    fetch('{{ route("user.favorites.toggle") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            product_id: productId
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'removed') {
                                // Remove from favorites - redirect to refresh page
                                window.location.reload();
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            toastr.error('Có lỗi xảy ra. Vui lòng thử lại.');
                        })
                        .finally(() => {
                            this.disabled = false;
                            this.innerHTML = '<i class="ri-heart-fill"></i>';
                        });
                });
            });

        });
    </script>
@endsection