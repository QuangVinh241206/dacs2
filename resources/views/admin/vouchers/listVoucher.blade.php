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
                        <a href="{{ route('admin.vouchers.create') }}" class="btn btn-sm btn-primary">Thêm mã mới</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
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
                            {{ $vouchers->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection