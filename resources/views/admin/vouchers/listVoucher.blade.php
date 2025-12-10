@extends('layouts.admin.master')

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Danh sách mã giảm giá</h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        <form method="GET" action="{{ route('admin.vouchers.index') }}" class="d-inline-flex">
                            <input type="search" name="q" value="{{ request('q') }}"
                                class="form-control form-control-sm me-2" placeholder="Tìm mã voucher"
                                style="min-width:200px;">
                            <select name="is_active" class="form-select form-select-sm me-2">
                                <option value="" {{ request('is_active') === null || request('is_active') === '' ? 'selected' : '' }}>
                                    Tất cả trạng thái</option>
                                <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Không hoạt động
                                </option>
                            </select>
                            <button class="btn btn-sm btn-primary me-2">Tìm</button>
                            <a href="{{ route('admin.vouchers.index') }}" class="btn btn-sm btn-secondary">Reset</a>
                        </form>
                        <a href="{{ route('admin.vouchers.create') }}" class="btn btn-sm btn-primary ms-2">Thêm mã mới</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Mã</th>
                                    <th>Loại</th>
                                    <th>Giá trị</th>
                                    <th>Giá trị tối thiểu</th>
                                    <th>Giảm tối đa</th>
                                    <th>Thời gian</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vouchers as $v)
                                    <tr>
                                        <td>{{ $v->id }}</td>
                                        <td>{{ $v->code }}</td>
                                        <td>{{ $v->discount_type == 'percent' ? 'Phần trăm' : 'Tiền' }}</td>
                                        <td>{{ $v->discount_value }}</td>
                                        <td>{{ $v->min_order_value ?? '-' }}</td>
                                        <td>{{ $v->max_discount_value ?? '-' }}</td>
                                        <td>{{ $v->start_date ?? '-' }} - {{ $v->end_date ?? '-' }}</td>
                                        <td>{{ $v->is_active ? 'Hoạt động' : 'Không hoạt động' }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-warning"
                                                href="{{ route('admin.vouchers.edit', $v->id) }}">Sửa</a>
                                            <form action="{{ route('admin.vouchers.destroy', $v->id) }}" method="POST"
                                                style="display:inline-block"
                                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end">
                            {{ $vouchers->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection