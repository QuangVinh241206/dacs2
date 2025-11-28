<header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <!-- Logo + Categories button -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}" class="text-2xl font-['Pacifico'] text-primary">logo</a>

                @php
                    $navCategories = \App\Models\Category::withCount('products')->orderBy('name')->get();
                @endphp

                <div x-data="{ open: false }" class="relative hidden md:block">
                    <button @click="open = !open"
                        class="px-3 py-2 rounded-md font-medium hover:text-primary flex items-center space-x-2">
                        <span>Danh mục</span>
                        <i class="ri-arrow-down-s-line"></i>
                    </button>

                    <div x-show="open" @click.outside="open = false" x-cloak
                        class="absolute left-0 mt-2 w-56 bg-white shadow-lg rounded-md py-2 z-50">
                        <ul>
                            @foreach($navCategories as $cat)
                                <li>
                                    <a href="{{ route('user.products', ['category_id' => $cat->id]) }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        {{ $cat->name }}
                                        <span class="text-xs text-gray-400">({{ $cat->products_count }})</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Navigation -->
            <nav class="hidden md:flex space-x-8">
                <a href="{{ route('home') }}"
                    class=" font-medium hover:text-primary transition {{ Request()->is('/') ? 'text-primary' : 'text-gray-800' }}">Trang
                    chủ</a>
                <a href="{{ route('user.products') }}"
                    class="font-medium hover:text-primary transition {{ Request()->is('user/products*') ? 'text-primary' : 'text-gray-800' }}">Sản
                    phẩm</a>
                <a href="{{ route('user.about') }}"
                    class="font-medium hover:text-primary transition {{ Request()->is('user/about') ? 'text-primary' : 'text-gray-800' }}">Về
                    chúng tôi</a>
                <a href="{{ route('user.contact') }}"
                    class="font-medium hover:text-primary transition {{ Request()->is('user/contact') ? 'text-primary' : 'text-gray-800' }}">Liên
                    hệ</a>
            </nav>

            <!-- Search, Cart, Account -->
            <div class="flex items-center space-x-4">
                <div class="relative hidden md:block">
                    <form action="{{ route('user.products') }}" method="GET" class="relative">
                        <input name="q" type="text" placeholder="Tìm kiếm sản phẩm..."
                            class="pl-10 pr-10 py-2 w-64 rounded-full border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm">
                        <button type="submit"
                            class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 flex items-center justify-center text-gray-400">
                            <i class="ri-search-line"></i>
                        </button>
                    </form>
                </div>

                <div
                    class="relative w-10 h-10 flex items-center justify-center text-gray-700 hover:text-primary cursor-pointer">
                    <i class="ri-shopping-cart-2-line ri-lg"></i>
                    <span
                        class="absolute -top-1 -right-1 bg-primary text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">3</span>
                </div>

                <div class="relative flex items-center text-gray-700 cursor-pointer" x-data="{ open: false }">

                    @auth
                        <!-- Nút hiển thị icon + tên (nằm hàng ngang) -->
                        <div @click="open = !open" class="flex items-center space-x-2 hover:text-primary">
                            <i class="ri-user-line ri-lg"></i>
                            <span class="text-sm font-medium whitespace-nowrap">
                                {{ auth()->user()->name }}
                            </span>
                        </div>

                        <!-- Dropdown Menu -->
                        <ul x-show="open" @click.outside="open = false"
                            class="absolute top-full right-0 mt-2 w-auto bg-white shadow-lg rounded-md py-2 z-50">

                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                                    <i class="ri-info-card-line ri-lg"></i>
                                    Thông tin tài khoản
                                </a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                                    <i class="ri-heart-line ri-lg"></i>
                                    Sản phẩm yêu thích
                                </a>
                            </li>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                                    <i class="ri-file-list-line ri-lg"></i>
                                    Theo dõi đơn hàng
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('auth.logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="block px-4 py-2 hover:bg-gray-100">
                                    <i class="ri-logout-box-r-line ri-lg"></i>
                                    Đăng xuất
                                </a>
                            </li>

                            <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </ul>


                    @else
                        <!-- Khi chưa đăng nhập -->
                        <a href="{{ route('auth.login') }}" class="flex items-center space-x-2 hover:text-primary">
                            <i class="ri-user-line ri-lg"></i>
                            <span class="text-sm">Đăng nhập</span>
                        </a>
                    @endauth
                </div>



                <div class="hidden md:flex items-center">
                    <div class="w-8 h-8 flex items-center justify-center text-primary mr-1">
                        <i class="ri-phone-line ri-lg"></i>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Hỗ trợ 24/7</div>
                        <div class="text-sm font-medium">0123 456 789</div>
                    </div>
                </div>

                <button class="md:hidden w-10 h-10 flex items-center justify-center text-gray-700"
                    id="mobile-menu-button">
                    <i class="ri-menu-line ri-lg"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-4 space-y-1">
                <a href="#"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-800 hover:bg-gray-100">Trang
                    chủ</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-800 hover:bg-gray-100">Sản
                    phẩm</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-800 hover:bg-gray-100">Về
                    chúng tôi</a>
                <a href="#"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-800 hover:bg-gray-100">Liên hệ</a>
            </div>
            <div class="px-2 pt-2 pb-4">
                <form action="{{ route('user.products') }}" method="GET">
                    <div class="relative">
                        <input name="q" type="text" placeholder="Tìm kiếm sản phẩm..."
                            class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm">
                        <button type="submit"
                            class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 flex items-center justify-center text-gray-400">
                            <i class="ri-search-line"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="px-2 pt-2 pb-4 border-t">
                @php $mobileCats = \App\Models\Category::withCount('products')->orderBy('name')->get(); @endphp
                <div class="text-sm font-medium mb-2">Danh mục</div>
                <div class="grid grid-cols-1 gap-1">
                    @foreach($mobileCats as $cat)
                        <a href="{{ route('user.products', ['category_id' => $cat->id]) }}"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-800 hover:bg-gray-100">{{ $cat->name }}
                            <span class="text-xs text-gray-400">({{ $cat->products_count }})</span></a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</header>