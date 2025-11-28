@extends('layouts.user.master')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full mx-auto mt-3 mb-3">
        <div class="flex flex-col items-center mb-6">
            <i class="ri-user-line text-primary text-4xl mb-2"></i>
            <h2 class="text-2xl font-bold text-gray-900 mb-1">Đăng nhập</h2>
            <p class="text-gray-500 text-sm">Chào mừng bạn quay trở lại!</p>
        </div>
        <form method="POST" action="{{ route('auth.login.post') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="email">Email</label>
                <input id="email" name="email" type="email"
                    class="w-full px-4 py-3 rounded-button border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary text-sm"
                    placeholder="Nhập email của bạn" value="{{ old('email') }}">
                @error('email')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="password">Mật khẩu</label>
                <input id="password" name="password" type="password"
                    class="w-full px-4 py-3 rounded-button border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary text-sm"
                    placeholder="Nhập mật khẩu">
                @error('password')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center justify-between mb-6">
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
@endsection