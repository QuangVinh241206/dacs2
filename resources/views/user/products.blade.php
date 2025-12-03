@extends('layouts.user.master')

@section('content')
    <section class="container mx-auto py-8">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Sidebar Filters (same style as homepage) -->
            <aside class="w-full md:w-1/4">
                <form method="GET" action="{{ route('user.products') }}" id="filterForm" class="bg-white rounded-lg shadow-sm p-6 sticky top-24">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Bộ lọc sản phẩm</h3>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-700 mb-2">Tìm kiếm</label>
                        <input name="q" class="w-full px-3 py-2 border rounded-md" placeholder="Tìm kiếm tên hoặc mô tả" value="{{ request('q') }}">
                    </div>

                    <div class="mb-4">
                        <h4 class="font-medium text-gray-800 mb-2">Danh mục</h4>
                        <select name="category" class="w-full form-select border rounded-md px-3 py-2">
                            <option value="">Tất cả danh mục</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <h4 class="font-medium text-gray-800 mb-2">Khoảng giá</h4>
                        <input type="range" min="1000000" max="20000000" value="{{ request('price_max', 10000000) }}" class="w-full mb-2" id="priceRange">
                        <div class="flex justify-between text-sm text-gray-500 mb-2">
                            <span>1.000.000₫</span>
                            <span id="priceValue">{{ number_format(request('price_max', 10000000),0,',','.') }}₫</span>
                            <span>20.000.000₫</span>
                        </div>
                        <input type="hidden" name="price_max" id="priceMaxInput" value="{{ request('price_max') }}">
                        <div class="mt-2">
                            <label class="block text-sm text-gray-700 mb-2">Giá từ</label>
                            <input name="price_min" type="number" class="w-full px-3 py-2 border rounded-md" placeholder="Giá từ" value="{{ request('price_min') }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <h4 class="font-medium text-gray-800 mb-2">Kích thước</h4>
                        <div class="space-y-2 max-h-40 overflow-y-auto">
                            @foreach($sizes as $size)
                                <label class="flex items-center text-gray-700">
                                    <input type="checkbox" name="sizes[]" value="{{ $size }}" class="mr-2" {{ (is_array(request('sizes')) && in_array($size, request('sizes'))) ? 'checked' : '' }}>
                                    <span>{{ $size }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-4">
                        <h4 class="font-medium text-gray-800 mb-2">Chất liệu</h4>
                        <div class="space-y-2 max-h-40 overflow-y-auto">
                            @foreach($materials as $m)
                                <label class="flex items-center text-gray-700">
                                    <input type="checkbox" name="materials[]" value="{{ $m }}" class="mr-2" {{ (is_array(request('materials')) && in_array($m, request('materials'))) ? 'checked' : '' }}>
                                    <span>{{ $m }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="w-full bg-primary text-white py-2 rounded-button font-medium hover:bg-blue-600 transition">Áp dụng</button>
                    </div>
                </form>
            </aside>

            <!-- Products Grid -->
            <div class="w-full md:w-3/4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-1.5 transition  ">
                    <a href="{{ route('user.productDetail',$product->slug) }}">
                        <div class="h-56 bg-gray-100">
                            @if($product->images->count())
                                <img src="{{ asset('storage/' . $product->images->where('is_main', true)->first()->image_url) }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">No image</div>
                            @endif
                        </div>
                    </a>
                    <div class="p-4">
                        <h3 class="font-medium text-lg"><a href="{{ route('user.productDetail',$product->slug) }}">{{ $product->name }}</a>
                        </h3>
                        <p class="text-sm text-gray-500 mb-2">{{ optional($product->category)->name }}</p>
                        <div class="flex items-center justify-between">
                            <div class="text-primary font-semibold">
                                @if($product->variants->count())
                                    {{ number_format($product->variants->min('price'), 0, ',', '.') }}đ -
                                    {{ number_format($product->variants->max('price'), 0, ',', '.') }}đ
                                @else
                                    -
                                @endif
                            </div>
                            
                        </div>
                    </div>
                </div>
            @endforeach
                </div>

                <div class="mt-3">
                    {{ $products->appends(request()->query())->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </section>

    <script>
        // sync price range slider with hidden input and display
        document.addEventListener('DOMContentLoaded', function () {
            const priceRange = document.getElementById('priceRange');
            const priceValue = document.getElementById('priceValue');
            const priceMaxInput = document.getElementById('priceMaxInput');

            if (priceRange && priceValue && priceMaxInput) {
                function formatV(n) {
                    return new Intl.NumberFormat('vi-VN').format(n) + '₫';
                }

                priceRange.addEventListener('input', function () {
                    priceValue.textContent = formatV(this.value);
                    priceMaxInput.value = this.value;
                });
            }
        });
    </script>
@endsection