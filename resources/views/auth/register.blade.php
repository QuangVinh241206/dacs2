@extends('layouts.user.master')

@section('content')
    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-auto">
        <div class="flex flex-col items-center mb-6">
            <div class="bg-primary bg-opacity-10 rounded-full p-3 mb-2">
                <i class="ri-user-add-line text-primary text-3xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-1">Đăng ký tài khoản</h2>
            <p class="text-gray-500 text-sm">Tạo tài khoản mới để mua sắm dễ dàng hơn!</p>
        </div>
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            <div class="space-y-4">
                <div class="relative">
                    <i class="ri-user-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input id="fullname" name="name" type="text" required
                        class="w-full pl-10 pr-4 py-3 rounded-button border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary text-sm"
                        placeholder="Họ và tên" value="{{ old('name') }}">
                </div>
            </div>
            <div class="space-y-4">
                <div class="relative">
                    <i class="ri-mail-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input id="email" name="email" type="email" required
                        class="w-full pl-10 pr-4 py-3 rounded-button border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary text-sm"
                        placeholder="Email" value="{{ old('email') }}">
                </div>
            </div>
            <div class="space-y-4">
                <div class="relative">
                    <i class="ri-phone-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input id="phone" name="phone" type="tel" required
                        class="w-full pl-10 pr-4 py-3 rounded-button border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary text-sm"
                        placeholder="Số điện thoại" value="{{ old('phone') }}">
                </div>
            </div>
            <div class="relative">
                <i class="ri-map-pin-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input id="address" name="address" type="text"
                    class="w-full pl-10 pr-4 py-3 rounded-button border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary text-sm"
                    placeholder="Địa chỉ (không bắt buộc)" value="{{ old('address') }}">
            </div>
            <div class="space-y-4">
                <div class="relative">
                    <i class="ri-lock-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input id="password" name="password" type="password" required
                        class="w-full pl-10 pr-4 py-3 rounded-button border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary text-sm"
                        placeholder="Mật khẩu">
                </div>
            </div>
            <div class="space-y-4">
                <div class="relative">
                    <i class="ri-lock-password-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input id="confirm-password" name="password_confirmation" type="password" required
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
@endsection