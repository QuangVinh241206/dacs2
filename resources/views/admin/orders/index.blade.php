@extends('layouts.admin.master')

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Quản lý đơn hàng</h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        <form method="GET" action="{{ route('admin.orders.index') }}" class="d-inline-flex">
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
                            <button class="btn btn-sm btn-primary">Tìm</button>
                        </form>
                        <a href="{{ route('admin.orders.trashed') }}" class="btn btn-sm btn-warning ms-2">
                            <i class="fas fa-trash"></i> Đã xóa
                        </a>
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
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày đặt</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                        <tr class="order-row" data-order-id="{{ $order->id }}" style="cursor: pointer;">
                                            <td>#{{ $order->id }}</td>
                                            <td>
                                                <div>{{ $order->user->name ?? 'N/A' }}</div>
                                                <small class="text-muted">{{ $order->user->email ?? '' }}</small>
                                            </td>
                                            <td>{{ $order->receiver_name }}</td>
                                            <td>{{ $order->receiver_phone }}</td>
                                            <td>{{ number_format($order->total_price) }}đ</td>
                                            <td>
                                            
                                                
                                                    
                                                    <select class="form-select form-select-sm status-select" 
                                                        data-order-id="{{ $order->id }}" style="min-width: 140px;">
                                                        <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}
                                                            style="color: #856404; background-color: #fff3cd;">⏳ Chờ xác nhận</option>
                                                        <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}
                                                            style="color: #0c5460; background-color: #d1ecf1;">🔄 Đang xử lý</option>
                                                        <option value="shipping" {{ $order->order_status === 'shipping' ? 'selected' : '' }}
                                                            style="color: #004085; background-color: #cce5ff;">🚚 Đang giao</option>
                                                        <option value="completed" {{ $order->order_status === 'completed' ? 'selected' : '' }}
                                                            style="color: #155724; background-color: #d4edda;">✅ Hoàn thành</option>
                                                        <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}
                                                            style="color: #721c24; background-color: #f8d7da;">❌ Đã hủy</option>
                                                    </select>
                                                
                                            </td>
                                            <td>{{ $order->order_date ? $order->order_date->format('d/m/Y H:i') : 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> Xem
                                                </a>
                                                <form method="POST" action="{{ route('admin.orders.destroy', $order) }}"
                                                    style="display: inline;"
                                                    onsubmit="return confirm('Bạn có chắc muốn xóa đơn hàng này?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i> Xóa
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                <div class="text-muted">Không có đơn hàng nào</div>
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

            <!-- Modal for order details -->
            <div class="modal fade" id="orderDetailModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Chi tiết đơn hàng #<span id="modalOrderId"></span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body" id="orderDetailContent">
                            <!-- Order details will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

            <script>
                $(document).ready(function () {
                    // Handle status change
                    $('.status-select').change(function () {
                        const orderId = $(this).data('order-id');
                        const newStatus = $(this).val();

                        $.ajax({
                            url: `/admin/orders/${orderId}/status`,
                            method: 'PATCH',
                            data: {
                                status: newStatus,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                if (response.success) {
                                    // Show success message
                                    showAlert('success', response.message);
                                }
                            },
                            error: function (xhr) {
                                // Revert the select
                                location.reload();
                                showAlert('error', 'Có lỗi xảy ra khi cập nhật trạng thái');
                            }
                        });
                    });

                    // Handle view order details - temporarily disabled, using direct link instead

                    $('.view-order, .order-row').click(function (e) {
                        console.log('View order clicked', e.target);
                        // Don't trigger if clicking on select or buttons
                        if ($(e.target).is('select, button, .btn, .fas')) {
                            return;
                        }

                        const orderId = $(this).data('order-id') || $(this).closest('tr').data('order-id');
                        console.log('Order ID:', orderId);

                        // Load order details via AJAX
                        $.get(`/admin/orders/${orderId}`, { ajax: 1 })
                            .done(function (response) {
                                console.log('AJAX response:', response);
                                if (response.success) {
                                    $('#orderDetailContent').html(response.html);
                                    $('#modalOrderId').text(response.order_id);
                                    $('#orderDetailModal').modal('show');
                                } else {
                                    showAlert('error', 'Không thể tải chi tiết đơn hàng');
                                }
                            })
                            .fail(function (xhr) {
                                console.log('AJAX error:', xhr);
                                let message = 'Không thể tải chi tiết đơn hàng';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    message = xhr.responseJSON.message;
                                }
                                showAlert('error', message);
                            });
                    });

                });

                function showAlert(type, message) {
                    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                    const alertHtml = `
                                                <div class="alert ${alertClass} alert-dismissible fade show position-fixed" role="alert"
                                                     style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                                                    ${message}
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                                </div>
                                            `;
                    $('body').append(alertHtml);

                    // Auto remove after 3 seconds
                    setTimeout(() => {
                        $('.alert').fadeOut();
                    }, 3000);
                }

                // Function to update select background color based on selected value
                function updateSelectBackground(selectElement) {
                    const value = selectElement.value;
                    const colors = {
                        'pending': '#fff3cd',
                        'processing': '#d1ecf1',
                        'shipping': '#cce5ff',
                        'completed': '#d4edda',
                        'cancelled': '#f8d7da'
                    };
                    selectElement.style.backgroundColor = colors[value] || '#ffffff';
                }

                // Initialize select backgrounds on page load
                $(document).ready(function() {
                    $('.status-select').each(function() {
                        updateSelectBackground(this);
                    });

                    // Update background when select value changes
                    $('.status-select').change(function() {
                        updateSelectBackground(this);
                    });
                });
            </script>
@endsection