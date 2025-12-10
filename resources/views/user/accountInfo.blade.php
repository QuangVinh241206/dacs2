@extends('layouts.user.master')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">Thông tin tài khoản</h1>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Thông tin cá nhân -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Thông tin cá nhân</h2>

                    <form id="accountForm" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Họ tên</label>
                            <input type="text" id="name" name="name" value="{{ $user->name }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <div class="text-red-500 text-sm mt-1 error-name"></div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" id="email" name="email" value="{{ $user->email }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <div class="text-red-500 text-sm mt-1 error-email"></div>
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
                            <input type="text" id="phone" name="phone" value="{{ $user->phone }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <div class="text-red-500 text-sm mt-1 error-phone"></div>
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ</label>
                            <textarea id="address" name="address" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ $user->address }}</textarea>
                            <div class="text-red-500 text-sm mt-1 error-address"></div>
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                            Cập nhật thông tin
                        </button>
                    </form>
                </div>

                <!-- Đổi mật khẩu -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Đổi mật khẩu</h2>

                    <form id="passwordForm" class="space-y-4">
                        @csrf

                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu hiện
                                tại</label>
                            <input type="password" id="current_password" name="current_password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <div class="text-red-500 text-sm mt-1 error-current_password"></div>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu mới</label>
                            <input type="password" id="password" name="password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <div class="text-red-500 text-sm mt-1 error-password"></div>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Xác nhận
                                mật khẩu mới</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <div class="text-red-500 text-sm mt-1 error-password_confirmation"></div>
                        </div>

                        <button type="submit"
                            class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-200">
                            Đổi mật khẩu
                        </button>
                    </form>
                </div>
            </div>

            <!-- Thông tin bổ sung -->
            <div class="mt-8 bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">Thông tin bổ sung</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <span class="block text-sm font-medium text-gray-700">Ngày tạo tài khoản</span>
                        <span class="text-gray-600">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-700">Cập nhật lần cuối</span>
                        <span class="text-gray-600">{{ $user->updated_at->format('d/m/Y H:i') }}</span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-700">Trạng thái</span>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                            {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $user->status === 'active' ? 'Hoạt động' : 'Không hoạt động' }}
                        </span>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-700">Vai trò</span>
                        <span class="text-gray-600">{{ $user->role === 'admin' ? 'Quản trị viên' : 'Người dùng' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Form cập nhật thông tin tài khoản
            const accountForm = document.getElementById('accountForm');
            accountForm.addEventListener('submit', function (e) {
                e.preventDefault();

                // Clear previous errors
                document.querySelectorAll('.error-name, .error-email, .error-phone, .error-address').forEach(el => el.textContent = '');

                const formData = new FormData(accountForm);

                fetch('{{ route("user.account.update") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            showToast('success', data.message);
                        } else {
                            // Show validation errors
                            Object.keys(data.errors).forEach(field => {
                                const errorElement = document.querySelector('.error-' + field);
                                if (errorElement) {
                                    errorElement.textContent = data.errors[field][0];
                                }
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('error', 'Có lỗi xảy ra, vui lòng thử lại!');
                    });
            });

            // Form đổi mật khẩu
            const passwordForm = document.getElementById('passwordForm');
            passwordForm.addEventListener('submit', function (e) {
                e.preventDefault();

                // Clear previous errors
                document.querySelectorAll('.error-current_password, .error-password, .error-password_confirmation').forEach(el => el.textContent = '');

                const formData = new FormData(passwordForm);

                fetch('{{ route("user.account.changePassword") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message and reset form
                            showToast('success', data.message);
                            passwordForm.reset();
                        } else {
                            // Show validation errors
                            Object.keys(data.errors).forEach(field => {
                                const errorElement = document.querySelector('.error-' + field);
                                if (errorElement) {
                                    errorElement.textContent = data.errors[field][0];
                                }
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('error', 'Có lỗi xảy ra, vui lòng thử lại!');
                    });
            });
        });

        // Toast notification function
        function showToast(type, message) {
            // Create toast element
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 px-6 py-3 rounded-md text-white z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'
                }`;
            toast.textContent = message;

            // Add to page
            document.body.appendChild(toast);

            // Remove after 3 seconds
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
    </script>
@endsection