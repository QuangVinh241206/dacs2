<header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-2xl font-['Pacifico'] text-primary">logo</a>
            </div>

            <!-- Main Navigation -->
            <nav class="hidden md:flex space-x-8">
                <a href="{{ route('home') }}"
                    class=" font-medium hover:text-primary transition {{ Request()->is('/') ? 'text-primary' : 'text-gray-800' }}">Trang
                    chủ</a>
                <a href="{{ route('user.productDetail') }}"
                    class="font-medium hover:text-primary transition {{ Request()->is('user/product_detail') ? 'text-primary' : 'text-gray-800' }}">Sản
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
                    <input type="text" placeholder="Tìm kiếm sản phẩm..."
                        class="pl-10 pr-4 py-2 w-64 rounded-full border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm">
                    <div
                        class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 flex items-center justify-center text-gray-400">
                        <i class="ri-search-line"></i>
                    </div>
                </div>

                <div
                    class="relative w-10 h-10 flex items-center justify-center text-gray-700 hover:text-primary cursor-pointer">
                    <i class="ri-shopping-cart-2-line ri-lg"></i>
                    <span
                        class="absolute -top-1 -right-1 bg-primary text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">3</span>
                </div>

                <div class="w-10 h-10 flex items-center justify-center text-gray-700 hover:text-primary cursor-pointer">
                    <a href="{{ route('auth.login') }}" class="flex items-center justify-center w-full h-full"
                        target="_blank">
                        <i class="ri-user-line ri-lg"></i>
                    </a>
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
                <div class="relative">
                    <input type="text" placeholder="Tìm kiếm sản phẩm..."
                        class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm">
                    <div
                        class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 flex items-center justify-center text-gray-400">
                        <i class="ri-search-line"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>