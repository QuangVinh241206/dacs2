@extends('layouts.user.master')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full mx-auto mt-3 mb-3">
        <div class="flex flex-col items-center mb-6">
            <i class="ri-user-line text-primary text-4xl mb-2"></i>
            <h2 class="text-2xl font-bold text-gray-900 mb-1">Quên mật khẩu</h2>
        </div>
        <form method="POST" action="{{ route('forgot.post') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="email">Nhập email của bạn</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}"
                    class="w-full px-4 py-3 rounded-button border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary text-sm"
                    placeholder="Nhập email của bạn">
                @error('email')
                    <p class="text-red-500 italic">{{ $message }}</p>
                @enderror
                @if(session('status'))
                    <p class="text-green-600 mt-2 italic">{{ session('status') }}</p>
                @endif
            </div>
            <button type="submit"
                class="w-full bg-primary text-white py-3 rounded-button font-medium hover:bg-blue-600 transition">Gửi
                yêu cầu</button>
        </form>
    </div>
@endsection