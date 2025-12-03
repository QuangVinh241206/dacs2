@extends('layouts.admin.master')

@section('content')
    <div class="container-fluid p-4">
        <div class="mb-4">
            <h4>Chỉnh sửa người dùng</h4>
            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-secondary">« Quay lại</a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Tên</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Vai trò</label>
                <select name="role" class="form-select">
                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="active" {{ old('status', $user->status ?? 'active') == 'active' ? 'selected' : '' }}>Hoạt
                        động</option>
                    <option value="locked" {{ old('status', $user->status ?? 'active') == 'locked' ? 'selected' : '' }}>Bị
                        khóa</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Mật khẩu mới (để trống nếu không đổi)</label>
                <input type="password" name="password" class="form-control" autocomplete="new-password">
            </div>

            <div class="mb-3">
                <label class="form-label">Xác nhận mật khẩu</label>
                <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
            </div>

            <div>
                <button class="btn btn-primary">Lưu</button>
            </div>
        </form>
    </div>
@endsection