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
                            alt="{{ $product->name ?? 'Sản phẩm' }}" class="w-full h-96 object-fit-lg-scale" id="main-image">
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
                        @php
                            $avg = isset($avgRating) ? (float)$avgRating : (float)($product->reviews()->avg('rating') ?? 0);
                            $rounded = round($avg * 2) / 2; // round to 0.5
                            $full = (int) floor($rounded);
                            $half = ($rounded - $full) == 0.5 ? 1 : 0;
                            $empty = 5 - $full - $half;
                        @endphp
                        <div id="average-stars" class="flex text-yellow-400">
                            @for($i=0;$i<$full;$i++)
                                <i class="ri-star-fill"></i>
                            @endfor
                            @if($half)
                                <i class="ri-star-half-fill"></i>
                            @endif
                            @for($i=0;$i<$empty;$i++)
                                <i class="ri-star-line"></i>
                            @endfor
                        </div>
                        <span id="review-count" class="text-sm text-gray-500 ml-2">({{ isset($reviewCount) ? $reviewCount : ($product->reviews->count() ?? 0) }} đánh giá)</span>
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
                        <button id="favorite-button" data-product-id="{{ $product->id }}" data-fav-url="{{ route('user.favorites.toggle') }}" data-login-url="{{ route('auth.login') }}" class="w-12 h-12 flex items-center justify-center rounded-full border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                            @if(isset($isFavorited) && $isFavorited)
                                <i class="ri-heart-fill text-2xl text-red-500"></i>
                            @else
                                <i class="ri-heart-line text-2xl"></i>
                            @endif
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
                        <div id="reviews-list" class="space-y-6">
                            @include('user.partials.reviews_list', ['reviews' => $product->reviews])
                        </div>
                        <div class="mt-6">
                            <h4 class="text-lg font-medium text-gray-800 mb-2">Viết đánh giá</h4>
                            <form id="review-form" method="POST" action="{{ route('user.reviews.store') }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id ?? '' }}">
                                <input type="hidden" name="rating" id="rating-input" value="5">
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
                        <div class="bg-white border-2 border-gray-200 rounded-lg shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-1.5 transition  ">
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
        // Truyền dữ liệu variants và discount từ backend sang JavaScript
        window.productVariants = @json($variantsData ?? []);
        window.productDiscount = {{ (int)($product->discount_percent ?? 0) }};
    </script>
    <script src="{{ asset('js/UserProductDetail.js') }}"></script>
@endpush