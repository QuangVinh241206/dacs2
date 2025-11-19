<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giường Đẹp - Nội Thất Phòng Ngủ Cao Cấp</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>tailwind.config = { theme: { extend: { colors: { primary: '#3b82f6', secondary: '#f59e0b' }, borderRadius: { 'none': '0px', 'sm': '4px', DEFAULT: '8px', 'md': '12px', 'lg': '16px', 'xl': '20px', '2xl': '24px', '3xl': '32px', 'full': '9999px', 'button': '8px' } } } }</script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <script src="{{ asset('js/homepage.js') }}"></script>
</head>

<body class="bg-gray-50">
    <!-- Header -->
    @include('layouts.user.header')

    @yield('content')

    <!-- Footer -->
    @include('layouts.user.footer')

    <!-- Back to Top Button -->
    <button id="backToTop"
        class="fixed bottom-6 right-6 w-12 h-12 bg-primary text-white rounded-full shadow-lg flex items-center justify-center opacity-0 invisible transition-all duration-300">
        <i class="ri-arrow-up-line ri-lg"></i>
    </button>

    <!-- Chat Support Button -->
    <button id="chatButton"
        class="fixed bottom-6 left-6 w-14 h-14 bg-primary text-white rounded-full shadow-lg flex items-center justify-center">
        <i class="ri-customer-service-2-line ri-lg"></i>
    </button>

    <!-- Chat Box -->
    <div id="chatBox"
        class="fixed bottom-24 left-6 w-80 bg-white rounded-lg shadow-xl overflow-hidden opacity-0 invisible transition-all duration-300 transform translate-y-4">
        <div class="bg-primary text-white p-4 flex justify-between items-center">
            <div class="flex items-center">
                <div class="w-8 h-8 flex items-center justify-center bg-white rounded-full text-primary mr-3">
                    <i class="ri-customer-service-2-line"></i>
                </div>
                <div>
                    <h3 class="font-medium">Hỗ trợ trực tuyến</h3>
                    <p class="text-xs opacity-80">Chúng tôi luôn sẵn sàng hỗ trợ bạn</p>
                </div>
            </div>
            <button id="closeChatBox" class="text-white hover:text-gray-200">
                <i class="ri-close-line"></i>
            </button>
        </div>
        <div class="p-4 h-80 overflow-y-auto bg-gray-50" id="chatMessages">
            <div class="flex mb-4">
                <div
                    class="w-8 h-8 flex items-center justify-center bg-primary rounded-full text-white mr-2 flex-shrink-0">
                    <i class="ri-customer-service-2-line"></i>
                </div>
                <div class="bg-white p-3 rounded-lg shadow-sm max-w-[80%]">
                    <p class="text-gray-700 text-sm">Xin chào! Tôi có thể giúp gì cho bạn về các sản phẩm giường ngủ?
                    </p>
                    <span class="text-xs text-gray-500 mt-1 block">10:30</span>
                </div>
            </div>
        </div>
        <div class="p-3 border-t">
            <div class="flex">
                <input type="text" id="chatInput" placeholder="Nhập tin nhắn..."
                    class="flex-1 px-3 py-2 rounded-l-button border-none focus:outline-none focus:ring-2 focus:ring-primary bg-gray-50 text-sm">
                <button id="sendMessage"
                    class="bg-primary text-white px-4 py-2 rounded-r-button hover:bg-blue-600 transition whitespace-nowrap">
                    <i class="ri-send-plane-fill"></i>
                </button>
            </div>
        </div>
    </div>


</body>

</html>