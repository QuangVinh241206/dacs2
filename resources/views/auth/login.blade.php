<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Giường Đẹp</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>tailwind.config = { theme: { extend: { colors: { primary: '#3b82f6', secondary: '#f59e0b' }, borderRadius: { 'none': '0px', 'sm': '4px', DEFAULT: '8px', 'md': '12px', 'lg': '16px', 'xl': '20px', '2xl': '24px', '3xl': '32px', 'full': '9999px', 'button': '8px' } } } }</script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <link href="style.css" rel="stylesheet">
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full">
        <div class="flex flex-col items-center mb-6">
            <i class="ri-user-line text-primary text-4xl mb-2"></i>
            <h2 class="text-2xl font-bold text-gray-900 mb-1">Đăng nhập</h2>
            <p class="text-gray-500 text-sm">Chào mừng bạn quay trở lại!</p>
        </div>
        <form>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="email">Email</label>
                <input id="email" type="email" required
                    class="w-full px-4 py-3 rounded-button border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary text-sm"
                    placeholder="Nhập email của bạn">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="password">Mật khẩu</label>
                <input id="password" type="password" required
                    class="w-full px-4 py-3 rounded-button border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary text-sm"
                    placeholder="Nhập mật khẩu">
            </div>
            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center text-sm text-gray-600">
                    <input type="checkbox" class="mr-2"> Ghi nhớ đăng nhập
                </label>
                <a href="#" class="text-primary text-sm hover:underline">Quên mật khẩu?</a>
            </div>
            <button type="submit"
                class="w-full bg-primary text-white py-3 rounded-button font-medium hover:bg-blue-600 transition">Đăng
                nhập</button>
        </form>
        <div class="mt-6 text-center text-sm text-gray-600">
            Chưa có tài khoản?
            <a href="{{ route('auth.register') }}" class="text-primary hover:underline">Đăng ký ngay</a>
        </div>
    </div>
</body>

</html>