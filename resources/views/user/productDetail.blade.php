@extends('layouts.user.master')
@section('content')
    <!-- Product Detail Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row gap-10">
                <!-- Product Images -->
                <div class="md:w-1/2">
                    <div class="bg-gray-100 rounded-lg overflow-hidden shadow-sm mb-4">
                        <img src="images/giuongbacau.png" alt="Giường gỗ sồi Bắc Âu" class="w-full h-96 object-cover object-top" id="main-image">
                    </div>
                    <div class="flex space-x-3">
                        <img src="https://readdy.ai/api/search-image?query=modern%2520wooden%2520bed%2520frame%2520with%2520headboard%2C%2520oak%2520finish%2C%2520elegant%2520design%2C%2520minimalist%2520style%2C%2520clean%2520lines%2C%2520high-quality%2520craftsmanship%2C%2520bedroom%2520furniture%2C%2520comfortable%2520sleeping%2520solution%2C%2520contemporary%2520home%2520decor%2C%2520on%2520plain%2520white%2520background&width=120&height=90&seq=bed1a&orientation=landscape" class="w-20 h-16 object-cover rounded-lg border-2 border-primary cursor-pointer thumbnail" data-src="images/giuongbacau.png">
                        <img src="https://readdy.ai/api/search-image?query=modern%2520wooden%2520bed%2520frame%2520with%2520headboard%2C%2520oak%2520finish%2C%2520elegant%2520design%2C%2520minimalist%2520style%2C%2520clean%2520lines%2C%2520high-quality%2520craftsmanship%2C%2520bedroom%2520furniture%2C%2520comfortable%2520sleeping%2520solution%2C%2520contemporary%2520home%2520decor%2C%2520on%2520plain%2520white%2520background&width=120&height=90&seq=bed1b&orientation=landscape" class="w-20 h-16 object-cover rounded-lg border-2 border-transparent hover:border-primary cursor-pointer thumbnail" data-src="https://readdy.ai/api/search-image?query=modern%2520wooden%2520bed%2520frame%2520with%2520headboard%2C%2520oak%2520finish%2C%2520elegant%2520design Nor%2520minimalist%2520style%2C%2520clean%2520lines%2C%2520high-quality%2520craftsmanship%2C%2520bedroom%2520furniture%2C%2520comfortable% observance2520sleeping%2520solution%2C%2520contemporary%2520home%2520decor%2C%2520on%2520plain%2520white%2520background&width=120&height=90&seq=bed1b&orientation=landscape">
                        <img src="https://readdy.ai/api/search-image?query=modern%2520wooden%2520bed%2520frame%2520with%2520headboard%2C%2520oak%2520finish%2C%2520elegant%2520design%2C%2520minimalist%2520style%2C%2520clean%2520lines%2C%2520high-quality%2520craftsmanship%2C%2520bedroom%2520furniture%2C%2520comfortable%2520sleeping%2520solution%2C%2520contemporary%2520home%2520decor%2C%2520on%2520plain%2520white%2520background&width=120&height=90&seq=bed1c&orientation=landscape" class="w-20 h-16 object-cover rounded-lg border-2 border-transparent hover:border-primary cursor-pointer thumbnail" data-src="https://readdy.ai/api/search-image?query=modern%2520wooden%2520bed%2520frame%2520with%2520headboard%2C%2520oak%2520finish%2C%2520elegant%2520design%2C%2520minimalist%2520style%2C%2520clean%2520lines%2C%2520high-quality%2520craftsmanship%2C%2520bedroom%2520furniture%2C%2520comfortable%2520sleeping%2520solution%2C%2520contemporary%2520home%2520decor%2C%2520on%2520plain%2520white%2520background&width=120&height=90&seq=bed1c&orientation=landscape">
                    </div>
                </div>
                <!-- Product Info -->
                <div class="md:w-1/2">
                    <h1 class="text-3xl font-bold text-gray-900 mb-3">Giường gỗ sồi Bắc Âu</h1>
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <i class="ri-star-fill"></i>
                            <i class="ri-star-fill"></i>
                            <i class="ri-star-fill"></i>
                            <i class="ri-star-fill"></i>
                            <i class="ri-star-half-fill"></i>
                        </div>
                        <span class="text-sm text-gray-500 ml-2">(28 đánh giá)</span>
                        <span class="ml-4 px-2 py-1 bg-primary text-white text-xs rounded">Mới</span>
                    </div>
                    <div class="flex items-center mb-6">
                        <span class="text-2xl font-bold text-primary mr-4">8.990.000₫</span>
                        <span class="text-lg text-gray-500 line-through">10.500.000₫</span>
                        <span class="ml-4 px-2 py-1 bg-orange-500 text-white text-xs rounded">-15%</span>
                    </div>
                    <p class="text-gray-700 mb-6">
                        Giường gỗ sồi Bắc Âu với thiết kế hiện đại, tối giản, chất liệu gỗ tự nhiên cao cấp, bền đẹp theo thời gian. Phù hợp với nhiều không gian phòng ngủ, mang lại cảm giác ấm cúng và sang trọng.
                    </p>
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-800 mb-2">Kích thước</h4>
                        <div class="flex space-x-3">
                            <button class="px-4 py-2 rounded border border-primary text-primary font-medium bg-white hover:bg-primary hover:text-white transition">1m6 x 2m</button>
                            <button class="px-4 py-2 rounded border border-gray-300 text-gray-700 font-medium bg-white hover:bg-primary hover:text-white transition">1m8 x 2m</button>
                            <button class="px-4 py-2 rounded border border-gray-300 text-gray-700 font-medium bg-white hover:bg-primary hover:text-white transition">2m x 2m2</button>
                        </div>
                    </div>
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-800 mb-2">Chất liệu</h4>
                        <span class="inline-block px-3 py-1 bg-blue-50 text-primary rounded-full text-sm font-medium mr-2 mb-2">Gỗ sồi tự nhiên</span>
                        <span class="inline-block px-3 py-1 bg-blue-50 text-primary rounded-full text-sm font-medium mr-2 mb-2">Sơn phủ PU cao cấp</span>
                    </div>
                    <div class="flex items-center space-x-4 mb-8">
                        <div class="flex items-center">
                            <button class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 text-gray-700 hover:bg-gray-100" id="decrease-quantity">-</button>
                            <input type="number" value="1" min="1" class="w-12 text-center border-none bg-transparent text-lg font-medium mx-2" id="quantity-input">
                            <button class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 text-gray-700 hover:bg-gray-100" id="increase-quantity">+</button>
                        </div>
                        <button class="bg-primary text-white px-8 py-3 rounded-button font-medium hover:bg-blue-600 transition shadow-md whitespace-nowrap flex items-center">
                            <i class="ri-shopping-cart-2-line mr-2"></i> Thêm vào giỏ hàng
                        </button>
                        <button class="w-12 h-12 flex items-center justify-center rounded-full border border-gray-300 text-gray-700 hover:bg-primary hover:text-white transition">
                            <i class="ri-heart-line text-2xl"></i>
                        </button>
                    </div>
                    <div class="flex items-center space-x-6 text-gray-600 text-sm">
                        <div class="flex items-center"><i class="ri-truck-line mr-2 text-primary"></i> Giao hàng miễn phí</div>
                        <div class="flex items-center"><i class="ri-shield-check-line mr-2 text-primary"></i> Bảo hành 5 năm</div>
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
                        <p class="text-gray-700 leading-relaxed">
                            Giường gỗ sồi Bắc Âu được chế tác từ gỗ sồi tự nhiên 100%, mang lại độ bền và vẻ đẹp vượt thời gian. Thiết kế tối giản với các đường nét tinh tế, phù hợp với phong cách nội thất hiện đại và truyền thống. Lớp sơn phủ PU cao cấp giúp bảo vệ bề mặt gỗ, chống trầy xước và tăng độ bóng. Sản phẩm không chỉ mang lại giấc ngủ thoải mái mà còn là điểm nhấn sang trọng cho phòng ngủ của bạn.
                        </p>
                        <ul class="list-disc list-inside text-gray-700 mt-4">
                            <li>Thiết kế tối giản, hiện đại</li>
                            <li>Chất liệu gỗ sồi tự nhiên cao cấp</li>
                            <li>Sơn phủ PU chống trầy, bền màu</li>
                            <li>Khung giường chắc chắn, chịu lực tốt</li>
                        </ul>
                    </div>
                    <div id="specifications" class="tab-content hidden">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Thông số kỹ thuật</h3>
                        <table class="w-full text-left text-gray-700">
                            <tbody>
                                <tr class="border-b">
                                    <td class="py-2 font-medium">Chất liệu</td>
                                    <td class="py-2">Gỗ sồi tự nhiên, sơn PU cao cấp</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2 font-medium">Kích thước</td>
                                    <td class="py-2">1m6 x 2m, 1m8 x 2m, 2m x 2m2</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2 font-medium">Trọng lượng</td>
                                    <td class="py-2">50-70kg (tùy kích thước)</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2 font-medium">Màu sắc</td>
                                    <td class="py-2">Màu gỗ tự nhiên</td>
                                </tr>
                                <tr>
                                    <td class="py-2 font-medium">Bảo hành</td>
                                    <td class="py-2">5 năm</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="reviews" class="tab-content hidden">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Đánh giá khách hàng</h3>
                        <div class="space-y-6">
                            <div class="border-b pb-4">
                                <div class="flex items-center mb-2">
                                    <div class="flex text-yellow-400">
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                    </div>
                                    <span class="ml-2 text-sm text-gray-500">Nguyễn Văn A - 10/06/2025</span>
                                </div>
                                <p class="text-gray-700">Giường rất đẹp, chất lượng gỗ tốt, lắp ráp dễ dàng. Rất hài lòng với sản phẩm!</p>
                            </div>
                            <div class="border-b pb-4">
                                <div class="flex items-center mb-2">
                                    <div class="flex text-yellow-400">
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-half-fill"></i>
                                    </div>
                                    <span class="ml-2 text-sm text-gray-500">Trần Thị B - 05/06/2025</span>
                                </div>
                                <p class="text-gray-700">Thiết kế sang trọng, nhưng giao hàng hơi chậm. Nhìn chung vẫn đáng giá.</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <h4 class="text-lg font-medium text-gray-800 mb-2">Viết đánh giá</h4>
                            <form>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Đánh giá của bạn</label>
                                    <div class="flex text-gray-300">
                                        <i class="ri-star-line hover:text-yellow-400 cursor-pointer"></i>
                                        <i class="ri-star-line hover:text-yellow-400 cursor-pointer"></i>
                                        <i class="ri-star-line hover:text-yellow-400 cursor-pointer"></i>
                                        <i class="ri-star-line hover:text-yellow-400 cursor-pointer"></i>
                                        <i class="ri-star-line hover:text-yellow-400 cursor-pointer"></i>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nhận xét</label>
                                    <textarea class="w-full p-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" rows="4" placeholder="Chia sẻ cảm nhận của bạn..."></textarea>
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
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <img src="images/giuong-ngu-go-oc-cho.png" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h4 class="text-lg font-medium text-gray-900">Giường gỗ óc chó hiện đại</h4>
                            <div class="flex items-center mb-2">
                                <span class="text-lg font-bold text-primary">9.500.000₫</span>
                                <span class="text-sm text-gray-500 line-through ml-2">11.000.000₫</span>
                            </div>
                            <button class="w-full bg-primary text-white px-4 py-2 rounded-button font-medium hover:bg-blue-600 transition">Thêm vào giỏ hàng</button>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <img src="images/giuong-ngu-go-cong-nghiep-kieu-nhat-thong-minh-cao-cap-4.jpg" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h4 class="text-lg font-medium text-gray-900">Giường gỗ thông tối giản</h4>
                            <div class="flex items-center mb-2">
                                <span class="text-lg font-bold text-primary">7.200.000₫</span>
                                <span class="text-sm text-gray-500 line-through ml-2">8.500.000₫</span>
                            </div>
                            <button class="w-full bg-primary text-white px-4 py-2 rounded-button font-medium hover:bg-blue-600 transition">Thêm vào giỏ hàng</button>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <img src="images/images.jfif" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h4 class="text-lg font-medium text-gray-900">Giường gỗ sồi cao cấp</h4>
                            <div class="flex items-center mb-2">
                                <span class="text-lg font-bold text-primary">12.990.000₫</span>
                                <span class="text-sm text-gray-500 line-through ml-2">15.000.000₫</span>
                            </div>
                            <button class="w-full bg-primary text-white px-4 py-2 rounded-button font-medium hover:bg-blue-600 transition">Thêm vào giỏ hàng</button>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <img src="images/Giuong-go-da-nang-thong-minh-GG-14-1.jpg" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h4 class="text-lg font-medium text-gray-900">Giường gỗ đa năng</h4>
                            <div class="flex items-center mb-2">
                                <span class="text-lg font-bold text-primary">10.800.000₫</span>
                                <span class="text-sm text-gray-500 line-through ml-2">12.500.000₫</span>
                            </div>
                            <button class="w-full bg-primary text-white px-4 py-2 rounded-button font-medium hover:bg-blue-600 transition">Thêm vào giỏ hàng</button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection