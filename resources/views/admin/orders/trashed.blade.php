@extends('layouts.admin.master')

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Đơn hàng đã xóa</h3>
                    </div>
                    <div class="col-sm-6 text-end ">
                        <form method="GET" action="{{ route('admin.orders.trashed') }}" class="d-inline-flex">
                            <input type="search" name="q" value="{{ request('q') }}"
                                class="form-control form-control-sm me-2" placeholder="Tìm mã đơn, tên người nhận, SĐT..."
                                style="min-width:250px;">
                            <select name="status" class="form-select form-select-sm me-2">
                                <option value="" {{ request('status') === null || request('status') === '' ? 'selected' : '' }}>
                                    Tất cả trạng thái</option>
                                @foreach($statuses as $key => $label)
                                    <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>{{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <button class="btn btn-sm btn-primary me-2 w-50">Tìm</button>
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-secondary w-100">Quay lại</a>
                        </form>
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
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Khách hàng</th>
                                        <th>Người nhận</th>
                                        <th>SĐT</th>
                                        <th>Trạng thái</th>
                                        <th>Tổng tiền</th>
                                        <th>Ngày xóa</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                                    class="text-decoration-none">
                                                    #{{ $order->id }}
                                                </a>
                                            </td>
                                            <td>{{ $order->user->name ?? 'N/A' }}</td>
                                            <td>{{ $order->receiver_name }}</td>
                                            <td>{{ $order->receiver_phone }}</td>
                                            <td>
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'warning',
                                                        'processing' => 'info',
                                                        'shipping' => 'primary',
                                                        'completed' => 'success',
                                                        'cancelled' => 'danger'
                                                    ];
                                                    $statusLabels = [
                                                        'pending' => 'Chờ xác nhận',
                                                        'processing' => 'Đang xử lý',
                                                        'shipping' => 'Đang giao',
                                                        'completed' => 'Hoàn thành',
                                                        'cancelled' => 'Đã hủy'
                                                    ];
                                                @endphp
                                                <span class="badge bg-{{ $statusColors[$order->order_status] ?? 'secondary' }}">
                                                    {{ $statusLabels[$order->order_status] ?? $order->order_status }}
                                                </span>
                                            </td>
                                            <td>{{ number_format($order->total_price, 0, ',', '.') }}đ</td>
                                            <td>{{ $order->deleted_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <form action="{{ route('admin.orders.restore', $order->id) }}" method="POST"
                                                    style="display:inline-block">
                                                    @csrf
                                                    @method('POST')
                                                    <button class="btn btn-sm btn-success me-1">
                                                        <i class="fas fa-undo"></i>
                                                        khôi phục
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.orders.forceDelete', $order->id) }}" method="POST"
                                                    style="display:inline-block"
                                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn đơn hàng này?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash-alt"></i>
                                                        xóa vĩnh viễn
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                <div class="text-muted">Không có đơn hàng đã xóa nào</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($orders->hasPages())
                            <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection