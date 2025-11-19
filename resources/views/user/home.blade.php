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
                    <button
                        class="bg-primary text-white px-6 py-3 rounded-button font-medium hover:bg-blue-600 transition shadow-md whitespace-nowrap">Mua
                        ngay</button>
                    <button
                        class="bg-white text-gray-800 px-6 py-3 rounded-button font-medium border border-gray-300 hover:bg-gray-50 transition whitespace-nowrap">Xem
                        bộ sưu tập</button>
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
                <div class="bg-gray-50 rounded-lg p-6 text-center hover:shadow-md transition cursor-pointer">
                    <div
                        class="w-16 h-16 mx-auto mb-4 flex items-center justify-center bg-blue-50 rounded-full text-primary">
                        <i class="ri-home-line ri-2x"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Giường gỗ</h3>
                    <p class="text-sm text-gray-500">28 sản phẩm</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-6 text-center hover:shadow-md transition cursor-pointer">
                    <div
                        class="w-16 h-16 mx-auto mb-4 flex items-center justify-center bg-blue-50 rounded-full text-primary">
                        <i class="ri-layout-2-line ri-2x"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Giường tầng</h3>
                    <p class="text-sm text-gray-500">16 sản phẩm</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-6 text-center hover:shadow-md transition cursor-pointer">
                    <div
                        class="w-16 h-16 mx-auto mb-4 flex items-center justify-center bg-blue-50 rounded-full text-primary">
                        <i class="ri-settings-line ri-2x"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Giường thông minh</h3>
                    <p class="text-sm text-gray-500">12 sản phẩm</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-6 text-center hover:shadow-md transition cursor-pointer">
                    <div
                        class="w-16 h-16 mx-auto mb-4 flex items-center justify-center bg-blue-50 rounded-full text-primary">
                        <i class="ri-hotel-bed-line ri-2x"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Giường đôi</h3>
                    <p class="text-sm text-gray-500">22 sản phẩm</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Products Section -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Sidebar Filters -->
                <div class="w-full md:w-1/4">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-24">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Bộ lọc sản phẩm</h3>

                        <!-- Price Range Filter -->
                        <div class="mb-6">
                            <h4 class="font-medium text-gray-800 mb-3">Khoảng giá</h4>
                            <input type="range" min="1000000" max="20000000" value="10000000"
                                class="price-range-slider mb-2" id="priceRange">
                            <div class="flex justify-between text-sm text-gray-500">
                                <span>1.000.000₫</span>
                                <span id="priceValue">10.000.000₫</span>
                                <span>20.000.000₫</span>
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div class="mb-6">
                            <h4 class="font-medium text-gray-800 mb-3">Loại giường</h4>
                            <div class="space-y-2">
                                <label class="custom-checkbox block text-gray-700">Giường gỗ
                                    <input type="checkbox" checked>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="custom-checkbox block text-gray-700">Giường sắt
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="custom-checkbox block text-gray-700">Giường tầng
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="custom-checkbox block text-gray-700">Giường thông minh
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="custom-checkbox block text-gray-700">Giường đôi
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>

                        <!-- Size Filter -->
                        <div class="mb-6">
                            <h4 class="font-medium text-gray-800 mb-3">Kích thước</h4>
                            <div class="space-y-2">
                                <label class="custom-checkbox block text-gray-700">1m2 x 2m
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="custom-checkbox block text-gray-700">1m6 x 2m
                                    <input type="checkbox" checked>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="custom-checkbox block text-gray-700">1m8 x 2m
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="custom-checkbox block text-gray-700">2m x 2m2
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>

                        <!-- Material Filter -->
                        <div class="mb-6">
                            <h4 class="font-medium text-gray-800 mb-3">Chất liệu</h4>
                            <div class="space-y-2">
                                <label class="custom-checkbox block text-gray-700">Gỗ sồi
                                    <input type="checkbox" checked>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="custom-checkbox block text-gray-700">Gỗ óc chó
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="custom-checkbox block text-gray-700">Gỗ thông
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="custom-checkbox block text-gray-700">Sắt
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="custom-checkbox block text-gray-700">Inox
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>

                        <button
                            class="w-full bg-primary text-white py-2 rounded-button font-medium hover:bg-blue-600 transition whitespace-nowrap">Áp
                            dụng</button>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="w-full md:w-3/4">
                    <!-- Sort and Filter Bar -->
                    <div class="bg-white rounded-lg shadow-sm p-4 mb-6 flex flex-wrap items-center justify-between">
                        <div class="flex items-center space-x-2 mb-2 md:mb-0">
                            <span class="text-gray-600">Sắp xếp theo:</span>
                            <select
                                class="border border-gray-200 rounded py-1 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent pr-8">
                                <option>Phổ biến nhất</option>
                                <option>Giá: Thấp đến cao</option>
                                <option>Giá: Cao đến thấp</option>
                                <option>Mới nhất</option>
                            </select>
                        </div>

                        <div class="flex items-center">
                            <span class="text-gray-600 mr-2">Hiển thị:</span>
                            <div class="flex border border-gray-200 rounded overflow-hidden">
                                <button class="px-3 py-1 bg-primary text-white">
                                    <i class="ri-layout-grid-line"></i>
                                </button>
                                <button class="px-3 py-1 bg-white text-gray-600 hover:bg-gray-50">
                                    <i class="ri-list-check"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Products -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Product 1 -->
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden product-card group">
                            <div class="relative">
                                <img src="https://readdy.ai/api/search-image?query=modern%2520wooden%2520bed%2520frame%2520with%2520headboard%2C%2520oak%2520finish%2C%2520elegant%2520design%2C%2520minimalist%2520style%2C%2520clean%2520lines%2C%2520high-quality%2520craftsmanship%2C%2520bedroom%2520furniture%2C%2520comfortable%2520sleeping%2520solution%2C%2520contemporary%2520home%2520decor%2C%2520on%2520plain%2520white%2520background&width=400&height=300&seq=bed1&orientation=landscape"
                                    alt="Giường gỗ sồi Bắc Âu" class="w-full h-64 object-cover object-top">
                                <div class="absolute top-3 left-3">
                                    <span class="bg-primary text-white text-xs px-2 py-1 rounded">Mới</span>
                                </div>
                                <div class="absolute top-3 right-3 flex space-x-2">
                                    <button
                                        class="w-8 h-8 flex items-center justify-center bg-white rounded-full shadow-md text-gray-600 hover:text-primary transition">
                                        <i class="ri-heart-line"></i>
                                    </button>
                                </div>
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 transition-opacity duration-300 group-hover:opacity-100 quick-view">
                                    <button
                                        class="bg-white text-gray-900 px-4 py-2 rounded-button font-medium hover:bg-gray-100 transition whitespace-nowrap">Xem
                                        nhanh</button>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 mb-1">Giường gỗ sồi Bắc Âu</h3>
                                <div class="flex items-center mb-2">
                                    <div class="flex text-yellow-400">
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-half-fill"></i>
                                    </div>
                                    <span class="text-xs text-gray-500 ml-2">(28 đánh giá)</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-lg font-bold text-gray-900">8.990.000₫</span>
                                        <span class="text-sm text-gray-500 line-through ml-2">10.500.000₫</span>
                                    </div>
                                    <button
                                        class="w-10 h-10 flex items-center justify-center bg-primary text-white rounded-full hover:bg-blue-600 transition">
                                        <i class="ri-shopping-cart-2-line"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Product 2 -->
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden product-card group">
                            <div class="relative">
                                <img src="https://readdy.ai/api/search-image?query=modern%2520wooden%2520platform%2520bed%2520with%2520storage%2520drawers%2C%2520walnut%2520finish%2C%2520contemporary%2520design%2C%2520practical%2520bedroom%2520furniture%2C%2520space-saving%2520solution%2C%2520high-quality%2520materials%2C%2520stylish%2520home%2520decor%2C%2520comfortable%2520sleeping%2520arrangement%2C%2520on%2520plain%2520white%2520background&width=400&height=300&seq=bed2&orientation=landscape"
                                    alt="Giường gỗ có ngăn kéo" class="w-full h-64 object-cover object-top">
                                <div class="absolute top-3 left-3">
                                    <span class="bg-orange-500 text-white text-xs px-2 py-1 rounded">-15%</span>
                                </div>
                                <div class="absolute top-3 right-3 flex space-x-2">
                                    <button
                                        class="w-8 h-8 flex items-center justify-center bg-white rounded-full shadow-md text-gray-600 hover:text-primary transition">
                                        <i class="ri-heart-line"></i>
                                    </button>
                                </div>
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 transition-opacity duration-300 group-hover:opacity-100 quick-view">
                                    <button
                                        class="bg-white text-gray-900 px-4 py-2 rounded-button font-medium hover:bg-gray-100 transition whitespace-nowrap">Xem
                                        nhanh</button>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 mb-1">Giường gỗ óc chó có ngăn kéo</h3>
                                <div class="flex items-center mb-2">
                                    <div class="flex text-yellow-400">
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-line"></i>
                                    </div>
                                    <span class="text-xs text-gray-500 ml-2">(16 đánh giá)</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-lg font-bold text-gray-900">12.750.000₫</span>
                                        <span class="text-sm text-gray-500 line-through ml-2">15.000.000₫</span>
                                    </div>
                                    <button
                                        class="w-10 h-10 flex items-center justify-center bg-primary text-white rounded-full hover:bg-blue-600 transition">
                                        <i class="ri-shopping-cart-2-line"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Product 3 -->
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden product-card group">
                            <div class="relative">
                                <img src="https://readdy.ai/api/search-image?query=modern%2520bunk%2520bed%2520with%2520ladder%2C%2520white%2520metal%2520frame%2C%2520space-saving%2520design%2C%2520children%2527s%2520bedroom%2520furniture%2C%2520sturdy%2520construction%2C%2520safety%2520rails%2C%2520contemporary%2520style%2C%2520practical%2520sleeping%2520solution%2C%2520on%2520plain%2520white%2520background&width=400&height=300&seq=bed3&orientation=landscape"
                                    alt="Giường tầng trẻ em" class="w-full h-64 object-cover object-top">
                                <div class="absolute top-3 right-3 flex space-x-2">
                                    <button
                                        class="w-8 h-8 flex items-center justify-center bg-white rounded-full shadow-md text-gray-600 hover:text-primary transition">
                                        <i class="ri-heart-line"></i>
                                    </button>
                                </div>
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 transition-opacity duration-300 group-hover:opacity-100 quick-view">
                                    <button
                                        class="bg-white text-gray-900 px-4 py-2 rounded-button font-medium hover:bg-gray-100 transition whitespace-nowrap">Xem
                                        nhanh</button>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 mb-1">Giường tầng trẻ em hiện đại</h3>
                                <div class="flex items-center mb-2">
                                    <div class="flex text-yellow-400">
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                    </div>
                                    <span class="text-xs text-gray-500 ml-2">(42 đánh giá)</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-lg font-bold text-gray-900">7.490.000₫</span>
                                    </div>
                                    <button
                                        class="w-10 h-10 flex items-center justify-center bg-primary text-white rounded-full hover:bg-blue-600 transition">
                                        <i class="ri-shopping-cart-2-line"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Product 4 -->
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden product-card group">
                            <div class="relative">
                                <img src="https://readdy.ai/api/search-image?query=luxury%2520upholstered%2520bed%2520with%2520tufted%2520headboard%2C%2520gray%2520velvet%2520fabric%2C%2520elegant%2520bedroom%2520furniture%2C%2520modern%2520design%2C%2520comfortable%2520sleeping%2520solution%2C%2520premium%2520quality%2C%2520sophisticated%2520home%2520decor%2C%2520stylish%2520interior%2C%2520on%2520plain%2520white%2520background&width=400&height=300&seq=bed4&orientation=landscape"
                                    alt="Giường bọc nỉ cao cấp" class="w-full h-64 object-cover object-top">
                                <div class="absolute top-3 left-3">
                                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded">Hot</span>
                                </div>
                                <div class="absolute top-3 right-3 flex space-x-2">
                                    <button
                                        class="w-8 h-8 flex items-center justify-center bg-white rounded-full shadow-md text-gray-600 hover:text-primary transition">
                                        <i class="ri-heart-line"></i>
                                    </button>
                                </div>
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 transition-opacity duration-300 group-hover:opacity-100 quick-view">
                                    <button
                                        class="bg-white text-gray-900 px-4 py-2 rounded-button font-medium hover:bg-gray-100 transition whitespace-nowrap">Xem
                                        nhanh</button>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 mb-1">Giường bọc nỉ cao cấp</h3>
                                <div class="flex items-center mb-2">
                                    <!--ngôi sao -->
                                    <div class="flex text-yellow-400">
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-half-fill"></i>
                                    </div>
                                    <span class="text-xs text-gray-500 ml-2">(36 đánh giá)</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-lg font-bold text-gray-900">14.900.000₫</span>
                                        <span class="text-sm text-gray-500 line-through ml-2">16.500.000₫</span>
                                    </div>
                                    <button
                                        class="w-10 h-10 flex items-center justify-center bg-primary text-white rounded-full hover:bg-blue-600 transition">
                                        <i class="ri-shopping-cart-2-line"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Product 5 -->
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden product-card group">
                            <div class="relative">
                                <img src="https://readdy.ai/api/search-image?query=modern%2520murphy%2520bed%2520with%2520desk%2C%2520space-saving%2520furniture%2C%2520folding%2520wall%2520bed%2C%2520compact%2520solution%2520for%2520small%2520apartments%2C%2520multifunctional%2520design%2C%2520contemporary%2520style%2C%2520practical%2520home%2520office%2520combination%2C%2520on%2520plain%2520white%2520background&width=400&height=300&seq=bed5&orientation=landscape"
                                    alt="Giường gấp thông minh" class="w-full h-64 object-cover object-top">
                                <div class="absolute top-3 right-3 flex space-x-2">
                                    <button
                                        class="w-8 h-8 flex items-center justify-center bg-white rounded-full shadow-md text-gray-600 hover:text-primary transition">
                                        <i class="ri-heart-line"></i>
                                    </button>
                                </div>
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 transition-opacity duration-300 group-hover:opacity-100 quick-view">
                                    <button
                                        class="bg-white text-gray-900 px-4 py-2 rounded-button font-medium hover:bg-gray-100 transition whitespace-nowrap">Xem
                                        nhanh</button>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 mb-1">Giường gấp thông minh kết hợp bàn làm việc</h3>
                                <div class="flex items-center mb-2">
                                    <div class="flex text-yellow-400">
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-line"></i>
                                    </div>
                                    <span class="text-xs text-gray-500 ml-2">(19 đánh giá)</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-lg font-bold text-gray-900">18.500.000₫</span>
                                    </div>
                                    <button
                                        class="w-10 h-10 flex items-center justify-center bg-primary text-white rounded-full hover:bg-blue-600 transition">
                                        <i class="ri-shopping-cart-2-line"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Product 6 -->
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden product-card group">
                            <div class="relative">
                                <img src="https://readdy.ai/api/search-image?query=rustic%2520wooden%2520bed%2520frame%2C%2520natural%2520wood%2520finish%2C%2520handcrafted%2520design%2C%2520solid%2520timber%2520construction%2C%2520farmhouse%2520style%2520bedroom%2520furniture%2C%2520warm%2520aesthetic%2C%2520durable%2520quality%2C%2520traditional%2520craftsmanship%2C%2520on%2520plain%2520white%2520background&width=400&height=300&seq=bed6&orientation=landscape"
                                    alt="Giường gỗ tự nhiên" class="w-full h-64 object-cover object-top">
                                <div class="absolute top-3 left-3">
                                    <span class="bg-green-500 text-white text-xs px-2 py-1 rounded">Eco</span>
                                </div>
                                <div class="absolute top-3 right-3 flex space-x-2">
                                    <button
                                        class="w-8 h-8 flex items-center justify-center bg-white rounded-full shadow-md text-gray-600 hover:text-primary transition">
                                        <i class="ri-heart-line"></i>
                                    </button>
                                </div>
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 transition-opacity duration-300 group-hover:opacity-100 quick-view">
                                    <button
                                        class="bg-white text-gray-900 px-4 py-2 rounded-button font-medium hover:bg-gray-100 transition whitespace-nowrap">Xem
                                        nhanh</button>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 mb-1">Giường gỗ tự nhiên phong cách rustic</h3>
                                <div class="flex items-center mb-2">
                                    <div class="flex text-yellow-400">
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-half-fill"></i>
                                    </div>
                                    <span class="text-xs text-gray-500 ml-2">(24 đánh giá)</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-lg font-bold text-gray-900">9.750.000₫</span>
                                        <span class="text-sm text-gray-500 line-through ml-2">11.200.000₫</span>
                                    </div>
                                    <button
                                        class="w-10 h-10 flex items-center justify-center bg-primary text-white rounded-full hover:bg-blue-600 transition">
                                        <i class="ri-shopping-cart-2-line"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-10 flex justify-center">
                        <nav class="flex items-center space-x-2">
                            <a href="#"
                                class="w-10 h-10 flex items-center justify-center rounded-full border border-gray-300 text-gray-600 hover:bg-gray-50">
                                <i class="ri-arrow-left-s-line"></i>
                            </a>
                            <a href="#"
                                class="w-10 h-10 flex items-center justify-center rounded-full bg-primary text-white">1</a>
                            <a href="#"
                                class="w-10 h-10 flex items-center justify-center rounded-full border border-gray-300 text-gray-600 hover:bg-gray-50">2</a>
                            <a href="#"
                                class="w-10 h-10 flex items-center justify-center rounded-full border border-gray-300 text-gray-600 hover:bg-gray-50">3</a>
                            <span class="w-10 h-10 flex items-center justify-center text-gray-600">...</span>
                            <a href="#"
                                class="w-10 h-10 flex items-center justify-center rounded-full border border-gray-300 text-gray-600 hover:bg-gray-50">8</a>
                            <a href="#"
                                class="w-10 h-10 flex items-center justify-center rounded-full border border-gray-300 text-gray-600 hover:bg-gray-50">
                                <i class="ri-arrow-right-s-line"></i>
                            </a>
                        </nav>
                    </div>
                </div>
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

    <!-- Newsletter Section -->
    <section class="py-12 bg-primary bg-opacity-5">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Đăng ký nhận thông tin</h2>
                <p class="text-gray-600 mb-6">Nhận thông báo về sản phẩm mới và ưu đãi đặc biệt</p>
                <div class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                    <input type="email" placeholder="Nhập email của bạn"
                        class="flex-1 px-4 py-3 rounded-button border-none focus:outline-none focus:ring-2 focus:ring-primary shadow-sm text-sm">
                    <button
                        class="bg-primary text-white px-6 py-3 rounded-button font-medium hover:bg-blue-600 transition shadow-md whitespace-nowrap">Đăng
                        ký</button>
                </div>
            </div>
        </div>
    </section>
@endsection