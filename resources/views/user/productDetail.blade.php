@extends('layouts.user.master')
@section('content')
@php use Illuminate\Support\Str; @endphp
    <!-- Product Detail Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row gap-10">
                <!-- Product Images -->
                <div class="md:w-1/2">
                    <div class="bg-gray-100 rounded-lg overflow-hidden shadow-sm mb-4">
                        <img src="{{ isset($mainImage->image_url) ? asset('storage/'.$mainImage->image_url ) : '#' }}"
                            alt="{{ $product->name ?? 'Sản phẩm' }}" class="w-full h-96 object-cover object-top" id="main-image">
                    </div>
                    <div class="flex space-x-3">
                        @if(isset($thumbnails) && $thumbnails->count())
                                @php
                                    // Ensure the main image is first in thumbnails
                                    $orderedThumbnails = $thumbnails;
                                    if(isset($mainImage)) {
                                        $orderedThumbnails = $thumbnails->sortByDesc(function($t) use ($mainImage) {
                                            return ($t->id == $mainImage->id) ? 1 : 0;
                                        })->values();
                                    }
                                @endphp
                                @foreach($orderedThumbnails as $thumb)
                                    <img src="{{  isset($thumb->image_url) ? asset('storage/'.$thumb->image_url ) : '#' }}"
                                        class="w-20 h-16 object-cover rounded-lg border-2 {{ (isset($mainImage) && $mainImage->id == $thumb->id) ? 'border-primary' : 'border-transparent hover:border-primary' }} cursor-pointer thumbnail"
                                        data-src="{{ isset($thumb->image_url) ? asset('storage/'.$thumb->image_url ) : '#'  }}">
                                @endforeach
                        @else
                            <img src="{{ asset('images/giuongbacau.png') }}" class="w-20 h-16 object-cover rounded-lg border-2 border-primary">
                        @endif
                    </div>
                </div>
                <!-- Product Info -->
                <div class="md:w-1/2">
                    <h1 class="text-3xl font-bold text-gray-900 mb-3">{{ $product->name ?? 'Sản phẩm' }}</h1>
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <i class="ri-star-fill"></i>
                            <i class="ri-star-fill"></i>
                            <i class="ri-star-fill"></i>
                            <i class="ri-star-fill"></i>
                            <i class="ri-star-half-fill"></i>
                        </div>
                        <span class="text-sm text-gray-500 ml-2">({{ isset($reviewCount) ? $reviewCount : ($product->reviews->count() ?? 0) }} đánh giá)</span>
                        <span class="ml-4 px-2 py-1 bg-primary text-white text-xs rounded">{{ $product->status == 1 ? 'Còn hàng' : 'Ngừng bán' }}</span>
                    </div>
                    <div class="flex items-center mb-6">
                        <div>
                            <span id="price-display" class="text-2xl font-bold text-primary mr-4">{{ number_format($product->variants->first()->price ?? 0,0,',','.') }}₫</span>
                            <div id="original-price" class="text-lg text-gray-500 line-through">@if($product->discount_percent){{ number_format($product->variants->first()->price ?? 0,0,',','.') }}₫@endif</div>
                        </div>
                        @if($product->discount_percent)
                            <span class="ml-4 px-2 py-1 bg-orange-500 text-white text-xs rounded">-{{ $product->discount_percent }}%</span>
                        @endif
                    </div>
                    
                    <p class="text-gray-700 mb-6">
                        {{ Str::limit($product->description, 150, '...') }}
                    </p>
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-800 mb-2">Kích thước</h4>
                        <div class="flex space-x-3">
                            @php
                                $sizes = $product->variants->pluck('size')->filter()->unique()->values();
                            @endphp
                            @if($sizes->count())
                                @foreach($sizes as $s)
                                    <button data-size="{{ $s }}" class="px-4 py-2 rounded border border-gray-300 text-gray-700 font-medium bg-white hover:bg-primary hover:text-white transition size-button">{{ $s }}</button>
                                @endforeach
                            @else
                                <span class="text-gray-600">Kích thước: Không có</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-6" id="color-selection-container">
                        <h4 class="font-medium text-gray-800 mb-2">Màu sắc</h4>
                        <div class="flex space-x-3" id="color-buttons-container">
                            {{-- Các nút màu sẽ được chèn bởi JavaScript --}}
                        </div>
                    </div>
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-800 mb-2">Chất liệu</h4>
                        @if($product->material)
                            <span class="inline-block px-3 py-1 bg-blue-50 text-primary rounded-full text-sm font-medium mr-2 mb-2">{{ $product->material }}</span>
                        @else
                            <span class="text-gray-600">Không có thông tin chất liệu</span>
                        @endif
                    </div>
                    <div class="flex items-center space-x-4 mb-8">
                        <div class="flex items-center">
                            <button class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 text-gray-700 hover:bg-gray-100" id="decrease-quantity">-</button>
                            <input type="number" value="1" min="1" class="w-12 text-center border-none bg-transparent text-lg font-medium mx-2" id="quantity-input">
                            <button class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 text-gray-700 hover:bg-gray-100" id="increase-quantity">+</button>
                        </div>
                        <button id="add-to-cart" class="bg-primary text-white px-8 py-3 rounded-button font-medium hover:bg-blue-600 transition shadow-md whitespace-nowrap flex items-center"
                            data-variant-id="{{ $product->variants->first()->id ?? '' }}">
                            <i class="ri-shopping-cart-2-line mr-2"></i> Thêm vào giỏ hàng
                        </button>
                        <button class="w-12 h-12 flex items-center justify-center rounded-full border border-gray-300 text-gray-700 hover:bg-primary hover:text-white transition">
                            <i class="ri-heart-line text-2xl"></i>
                        </button>
                    </div>
                    <div class="flex items-center space-x-6 text-gray-600 text-sm">
                        <div class="flex items-center"><i class="ri-truck-line mr-2 text-primary"></i> Giao hàng miễn phí</div>
                        <div class="flex items-center"><i class="ri-shield-check-line mr-2 text-primary"></i> Bảo hành {{ $product->warranty }}</div>
                        <div class="flex items-center"><i class="ri-exchange-line mr-2 text-primary"></i> Đổi trả 30 ngày</div>
                    </div>
                </div>
            </div>

            <!-- Product Description Tabs -->
            <div class="mt-12">
                <div class="border-b border-gray-200">
                    <nav class="flex space-x-8" aria-label="Tabs">
                        <button class="tab-button text-gray-500 hover:text-primary py-4 px-1 border-b-2 border-transparent font-medium text-sm active" data-tab="description">Mô tả sản phẩm</button>
                        <button class="tab-button text-gray-500 hover:text-primary py-4 px-1 border-b-2 border-transparent font-medium text-sm" data-tab="specifications">Thông số kỹ thuật</button>
                        <button class="tab-button text-gray-500 hover:text-primary py-4 px-1 border-b-2 border-transparent font-medium text-sm" data-tab="reviews">Đánh giá</button>
                    </nav>
                </div>
                <div class="mt-6">
                    <div id="description" class="tab-content">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Mô tả sản phẩm</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $product->description ?? 'Chưa có mô tả.' }}</p>
                    </div>
                    <div id="specifications" class="tab-content hidden">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Thông số kỹ thuật</h3>
                        <table class="w-full text-left text-gray-700">
                            <tbody>
                                <tr class="border-b">
                                    <td class="py-2 font-medium">Chất liệu</td>
                                    <td class="py-2">{{ $product->material ?? '—' }}</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2 font-medium">Kích thước</td>
                                    <td class="py-2">@if($sizes->count()) {{ implode(', ', $sizes->toArray()) }} @else — @endif</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2 font-medium">Tải trọng</td>
                                    <td class="py-2">{{ $product->weight_capacity ?? '—' }}</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2 font-medium">Màu sắc</td>
                                    @php
                                        $colors = $product->variants->pluck('color')->filter()->unique()->values()

                                    @endphp
                                    <td class="py-2">{{ implode(',', $colors->toArray()) }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium">Bảo hành</td>
                                    <td class="py-2">{{ $product->warranty ?? '—' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="reviews" class="tab-content hidden">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Đánh giá khách hàng</h3>
                        <div class="space-y-6">
                            @foreach($product->reviews as $review)
                                <div class="border-b pb-4">
                                    <div class="flex items-center mb-2">
                                        <div class="flex text-yellow-400">
                                            @for($i=0;$i<5;$i++)
                                                @if($i < $review->rating)
                                                    <i class="ri-star-fill"></i>
                                                @else
                                                    <i class="ri-star-line"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="ml-2 text-sm text-gray-500">{{ $review->user->name ?? 'Khách' }} - {{ (\Carbon\Carbon::parse($review->created_at))->format('d/m/Y') }}</span>
                                    </div>
                                    <p class="text-gray-700">{{ $review->comment }}</p>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6">
                            <h4 class="text-lg font-medium text-gray-800 mb-2">Viết đánh giá</h4>
                            <form method="POST" action="#">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id ?? '' }}">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Đánh giá của bạn</label>
                                    <div class="flex text-gray-300 rating-input">
                                        @for($i=1;$i<=5;$i++)
                                            <button type="button" data-value="{{ $i }}" class="ri-star-line hover:text-yellow-400 cursor-pointer rating-star"></button>
                                        @endfor
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nhận xét</label>
                                    <textarea name="comment" class="w-full p-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" rows="4" placeholder="Chia sẻ cảm nhận của bạn..."></textarea>
                                </div>
                                <button type="submit" class="bg-primary text-white px-6 py-2 rounded-button font-medium hover:bg-blue-600 transition">Gửi đánh giá</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products Section -->
            <section class="py-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Sản phẩm liên quan</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($related as $r)
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <img src="{{ ($r->images->first()) ? (Str::startsWith($r->images->first()->image_url, ['http','//']) ? $r->images->first()->image_url : asset('storage/' . ltrim($r->images->first()->image_url, '/'))) : asset('images/placeholder.png') }}" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h4 class="text-lg font-medium text-gray-900">{{ $r->name }}</h4>
                                <div class="flex items-center mb-2">
                                    @php $minp = $r->variants->min('price'); $maxp = $r->variants->max('price'); @endphp
                                    @if($minp && $maxp && $minp != $maxp)
                                        <span class="text-lg font-bold text-primary">{{ number_format($minp,0,',','.') }}₫</span>
                                    @else
                                        <span class="text-lg font-bold text-primary">{{ number_format($minp ?: $maxp ?: 0,0,',','.') }}₫</span>
                                    @endif
                                </div>
                                <a href="{{ route('user.productDetail', $r->slug) }}" class="w-full inline-block bg-primary text-white px-4 py-2 rounded-button font-medium hover:bg-blue-600 transition text-center">Xem chi tiết</a>
                            </div>        
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        (function(){
            // Dữ liệu variants từ backend
            var variants = @json($product->variants ?? []); 

            var discount = {{ (int)($product->discount_percent ?? 0) }};

            var priceEl = document.getElementById('price-display');
            var origEl = document.getElementById('original-price');
            var addBtn = document.getElementById('add-to-cart');
            var colorContainer = document.getElementById('color-buttons-container');
            var sizeButtons = document.querySelectorAll('.size-button');

            var selectedSize = null;
            var selectedColor = null;

            function formatVnd(n){
                return new Intl.NumberFormat('vi-VN').format(Math.round(n)) + '₫';
            }

            // 1. Tìm biến thể khớp với SIZE và COLOR (An toàn với null/rỗng)
            function findVariant(size, color){
                if(!variants) return null;
                var targetSize = size === null ? '' : String(size);
                var targetColor = color === null ? '' : String(color);
                
                for(var i=0;i<variants.length;i++){
                    var vSize = variants[i].size === null ? '' : String(variants[i].size);
                    var vColor = variants[i].color === null ? '' : String(variants[i].color);

                    if(vSize === targetSize && vColor === targetColor) {
                        return variants[i];
                    }
                }
                return null;
            }

            // 2. Cập nhật Giá và Variant ID
            function updatePriceAndVariant(v){
                if(!v || (v.stock && v.stock <= 0)){
                    priceEl.textContent = 'Hết hàng';
                    origEl.textContent = '';
                    origEl.classList.add('hidden');
                    addBtn.setAttribute('data-variant-id', '');
                    addBtn.disabled = true;
                    addBtn.innerHTML = '<i class="ri-shopping-cart-2-line mr-2"></i> Hết hàng';
                    return;
                }

                var price = v.price;
                if(discount && discount > 0){
                    var discounted = Math.round(price * (1 - discount/100));
                    priceEl.textContent = formatVnd(discounted);
                    origEl.textContent = formatVnd(price);
                    origEl.classList.remove('hidden');
                } else {
                    priceEl.textContent = formatVnd(price);
                    origEl.textContent = '';
                    origEl.classList.add('hidden');
                }

                if(addBtn) addBtn.setAttribute('data-variant-id', v.id);
                addBtn.disabled = false;
                addBtn.innerHTML = '<i class="ri-shopping-cart-2-line mr-2"></i> Thêm vào giỏ hàng';
            }

            // 3. Xử lý khi chọn Kích thước
            function handleSizeSelect(sizeButton){
                // Cập nhật trạng thái nút Kích thước
                sizeButtons.forEach(function(b){ 
                    b.classList.remove('bg-primary','text-white'); 
                    b.classList.add('bg-white','text-gray-700'); 
                });
                sizeButton.classList.remove('bg-white','text-gray-700');
                sizeButton.classList.add('bg-primary','text-white');

                selectedSize = sizeButton.getAttribute('data-size');
                selectedColor = null; // Reset Màu khi Kích thước thay đổi
                renderColorButtons(selectedSize);
            }

            // 4. Hiển thị các nút Màu sắc có sẵn cho Kích thước đã chọn (DÙNG TEXT BUTTON)
            function renderColorButtons(size){
                colorContainer.innerHTML = ''; // Xóa các nút cũ

                var compareSize = size === null ? '' : String(size);
                var availableColors = [];

                variants.forEach(function(v){
                    var vSize = v.size === null ? '' : String(v.size);
                    
                    if(vSize === compareSize && v.color && availableColors.indexOf(v.color) === -1){
                        availableColors.push(v.color);
                    }
                });

                if(availableColors.length === 0){
                    colorContainer.innerHTML = '<span class="text-gray-600">Không có tùy chọn màu sắc.</span>';
                    // Cập nhật giá dựa trên Size và Color rỗng
                    var v = findVariant(size, null); 
                    updatePriceAndVariant(v);
                    return;
                }

                // Tạo nút màu dưới dạng text button
                availableColors.forEach(function(color){
                    var btn = document.createElement('button');
                    btn.setAttribute('type', 'button');
                    btn.setAttribute('data-color', color);
                    btn.title = color;

                    // Sử dụng class của nút kích thước
                    btn.className = 'color-button px-4 py-2 rounded border border-gray-300 text-gray-700 font-medium bg-white hover:bg-primary hover:text-white transition';
                    btn.textContent = color; // Chèn tên màu vào

                    // Xử lý khi chọn Màu sắc
                    btn.addEventListener('click', function(){
                        // Bỏ chọn tất cả nút màu khác
                        document.querySelectorAll('.color-button').forEach(function(c){ 
                            c.classList.remove('bg-primary','text-white'); 
                            c.classList.add('bg-white','text-gray-700');
                        });
                        
                        // Chọn nút hiện tại
                        btn.classList.remove('bg-white','text-gray-700');
                        btn.classList.add('bg-primary','text-white');

                        selectedColor = btn.getAttribute('data-color');

                        // Tìm và cập nhật biến thể cuối cùng
                        var finalVariant = findVariant(selectedSize, selectedColor);
                        updatePriceAndVariant(finalVariant);
                    });
                    colorContainer.appendChild(btn);
                });

                // Tự động chọn màu đầu tiên và cập nhật giá
                var firstColorButton = document.querySelector('.color-button');
                if(firstColorButton){
                    firstColorButton.click(); // Giả lập click để chọn và cập nhật giá/id
                }
            }

            // 5. Khởi tạo Kích thước và Màu sắc
            if(sizeButtons.length){
                sizeButtons.forEach(function(btn){
                    btn.addEventListener('click', function(){
                        handleSizeSelect(this);
                    });
                });

                // Tự động chọn Kích thước đầu tiên khi tải trang
                sizeButtons[0].click();
            } else if(variants.length) {
                // Nếu không có nút kích thước, chỉ hiển thị màu sắc nếu có
                selectedSize = null;
                renderColorButtons(selectedSize);
            }

            // ... Các logic khác (Thumbnail, Tabs) giữ nguyên ...
            var thumbnails = document.querySelectorAll('.thumbnail');
            var mainImage = document.getElementById('main-image');
            if(thumbnails && thumbnails.length){
                thumbnails.forEach(function(t){
                    t.addEventListener('click', function(){
                        var src = t.getAttribute('data-src') || t.getAttribute('src');
                        if(src && mainImage) mainImage.setAttribute('src', src);
                        thumbnails.forEach(function(x){ x.classList.remove('border-primary'); x.classList.add('border-transparent'); });
                        t.classList.remove('border-transparent');
                        t.classList.add('border-primary');
                    });
                });
            }

            var tabButtons = document.querySelectorAll('.tab-button');
            var tabContents = document.querySelectorAll('.tab-content');
            if(tabButtons.length){
                tabButtons.forEach(function(btn){
                    btn.addEventListener('click', function(){
                        var target = btn.getAttribute('data-tab');

                        tabButtons.forEach(function(b){
                            b.classList.remove('active', 'border-primary');
                            b.classList.add('text-gray-500', 'border-transparent');
                            b.setAttribute('aria-selected', 'false');
                        });
                        btn.classList.add('active', 'border-primary');
                        btn.classList.remove('text-gray-500', 'border-transparent');
                        btn.setAttribute('aria-selected', 'true');

                        tabContents.forEach(function(c){ c.classList.add('hidden'); c.setAttribute('aria-hidden', 'true'); });
                        var targetEl = document.getElementById(target);
                        if(targetEl){ targetEl.classList.remove('hidden'); targetEl.setAttribute('aria-hidden', 'false'); }
                    });
                });

                var activeBtn = document.querySelector('.tab-button.active') || tabButtons[0];
                if(activeBtn){
                    var initial = activeBtn.getAttribute('data-tab');
                    tabContents.forEach(function(c){ c.classList.add('hidden'); c.setAttribute('aria-hidden', 'true'); });
                    var el = document.getElementById(initial);
                    if(el){ el.classList.remove('hidden'); el.setAttribute('aria-hidden', 'false'); }
                    tabButtons.forEach(function(b){ b.classList.remove('active', 'border-primary'); b.classList.add('text-gray-500', 'border-transparent'); b.setAttribute('aria-selected', 'false'); });
                    activeBtn.classList.add('active', 'border-primary'); activeBtn.classList.remove('text-gray-500', 'border-transparent'); activeBtn.setAttribute('aria-selected','true');
                }
            }
        })();
    </script>
@endpush