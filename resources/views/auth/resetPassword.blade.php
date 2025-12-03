@extends('layouts.user.master')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full mx-auto mt-3 mb-3">
        <div class="flex flex-col items-center mb-6">
            <i class="ri-user-line text-primary text-4xl mb-2"></i>
            <h2 class="text-2xl font-bold text-gray-900 mb-1">Đổi mật khẩu</h2>
        </div>
        <form method="POST" action="{{ route('auth.reset.post') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token ?? request('token') }}">
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $email ?? request('email')) }}"
                    class="w-full px-4 py-3 rounded-button border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary text-sm"
                    placeholder="Nhập email của bạn">
                @error('email')
                    <p class="text-red-500 italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="password">Mật khẩu mới</label>
                <input id="password" name="password" type="password"
                    class="w-full px-4 py-3 rounded-button border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary text-sm"
                    placeholder="Nhập mật khẩu mới">
                @error('password')
                    <p class="text-red-500 italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="password_confirmation">Xác nhận mật khẩu</label>
                <input id="password_confirmation" name="password_confirmation" type="password"
                    class="w-full px-4 py-3 rounded-button border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary text-sm"
                    placeholder="Nhập lại mật khẩu mới">
                @error('password_confirmation')
                    <p class="text-red-500 italic">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit"
                class="w-full bg-primary text-white py-3 rounded-button font-medium hover:bg-blue-600 transition">Đổi
                mật khẩu</button>
        </form>
    </div>
@endsection