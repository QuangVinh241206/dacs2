<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - Giường Đẹp</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <link href="style.css" rel="stylesheet">
    <script>  tailwind.config = { theme: { extend: { colors: { primary: '#3b82f6', secondary: '#f59e0b' }, borderRadius: { 'button': '8px' } } } }</script>
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full">
        <div class="flex flex-col items-center mb-6">
            <div class="bg-primary bg-opacity-10 rounded-full p-3 mb-2">
                <i class="ri-user-add-line text-primary text-3xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-1">Đăng ký tài khoản</h2>
            <p class="text-gray-500 text-sm">Tạo tài khoản mới để mua sắm dễ dàng hơn!</p>
        </div>
        <form class="space-y-4">
            <div class="space-y-4">
                <div class="relative">
                    <i class="ri-user-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input id="fullname" type="text" required
                        class="w-full pl-10 pr-4 py-3 rounded-button border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary text-sm"
                        placeholder="Họ và tên">
                </div>
            </div>
            <div class="space-y-4">
                <div class="relative">
                    <i class="ri-mail-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input id="email" type="email" required
                        class="w-full pl-10 pr-4 py-3 rounded-button border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary text-sm"
                        placeholder="Email">
                </div>
            </div>
            <div class="space-y-4">
                <div class="relative">
                    <i class="ri-phone-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input id="phone" type="tel" required
                        class="w-full pl-10 pr-4 py-3 rounded-button border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary text-sm"
                        placeholder="Số điện thoại">
                </div>
            </div>
            <div class="relative">
                <i class="ri-map-pin-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input id="address" type="text"
                    class="w-full pl-10 pr-4 py-3 rounded-button border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary text-sm"
                    placeholder="Địa chỉ (không bắt buộc)">
            </div>
            <div class="space-y-4">
                <div class="relative">
                    <i class="ri-lock-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input id="password" type="password" required
                        class="w-full pl-10 pr-4 py-3 rounded-button border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary text-sm"
                        placeholder="Mật khẩu">
                </div>
            </div>
            <div class="space-y-4">
                <div class="relative">
                    <i class="ri-lock-password-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input id="confirm-password" type="password" required
                        class="w-full pl-10 pr-4 py-3 rounded-button border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary text-sm"
                        placeholder="Nhập lại mật khẩu">
                </div>
            </div>
            <button type="submit"
                class="w-full bg-primary text-white py-3 rounded-button font-medium hover:bg-blue-600 transition">Đăng
                ký</button>
        </form>
        <div class="mt-6 text-center text-sm text-gray-600">
            Đã có tài khoản?
            <a href="{{ route('auth.login') }}" class="text-primary hover:underline">Đăng nhập</a>
        </div>
    </div>
</body>

</html>