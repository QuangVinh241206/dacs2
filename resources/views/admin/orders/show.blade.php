@extends('layouts.admin.master')

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Chi tiết đơn hàng #{{ $order->id }}</h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại danh sách
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Top Row: Order Information and Status Update -->
                <div class="row mb-4">
                    <!-- Order Information -->
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Thông tin đơn hàng</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Thông tin khách hàng</h6>
                                        <p><strong>Tên:</strong> {{ $order->user->name ?? 'N/A' }}</p>
                                        <p><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
                                        <p><strong>SĐT:</strong> {{ $order->user->phone ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Thông tin người nhận</h6>
                                        <p><strong>Tên:</strong> {{ $order->receiver_name }}</p>
                                        <p><strong>SĐT:</strong> {{ $order->receiver_phone }}</p>
                                        <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Ngày đặt:</strong>
                                            {{ $order->order_date ? $order->order_date->format('d/m/Y H:i') : 'N/A' }}</p>
                                        <p><strong>Phương thức thanh toán:</strong>
                                            {{ $order->payment_method === 'COD' ? 'Thanh toán khi nhận hàng' : ($order->payment_method === 'bank_transfer' ? 'Chuyển khoản' : 'Ví điện tử') }}
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Trạng thái:</strong>
                                            <span class="badge
                                                                                                    @if($order->order_status === 'pending') bg-warning
                                                                                                    @elseif($order->order_status === 'processing') bg-info
                                                                                                    @elseif($order->order_status === 'shipping') bg-primary
                                                                                                    @elseif($order->order_status === 'completed') bg-success
                                                                                                    @else bg-danger
                                                                                                    @endif">
                                                @if($order->order_status === 'pending') Chờ xác nhận
                                                @elseif($order->order_status === 'processing') Đang xử lý
                                                @elseif($order->order_status === 'shipping') Đang giao
                                                @elseif($order->order_status === 'completed') Hoàn thành
                                                @elseif($order->order_status === 'cancelled') Đã hủy
                                                @elseif($order->order_status === 'pending_payment') chờ thanh toán
                                                @endif
                                            </span>
                                        </p>
                                        @if($order->voucher)
                                            <p><strong>Voucher:</strong> {{ $order->voucher->code }}
                                                ({{ $order->voucher->discount_type === 'percent' ? $order->voucher->discount_value . '%' : number_format($order->voucher->discount_value) . 'đ' }})
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Status Update -->
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Cập nhật trạng thái</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Trạng thái hiện tại</label>
                                    <div>
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
                                        <span class="badge bg-{{ $statusColors[$order->order_status] ?? 'secondary' }} fs-6">
                                            {{ $statusLabels[$order->order_status] ?? $order->order_status }}
                                        </span>
                                    </div>
                                </div>

                                <form id="statusForm" action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="mb-3">
                                        <label class="form-label">Trạng thái đơn hàng</label>
                                        <select name="status" class="form-select" id="statusSelect">
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
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-save"></i> Cập nhật trạng thái
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Row: Order Details and Actions -->
                <div class="row">
                    <!-- Order Details -->
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Chi tiết sản phẩm</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>Sản phẩm</th>
                                                <th>Biến thể</th>
                                                <th>Đơn giá</th>
                                                <th>Số lượng</th>
                                                <th>Thành tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->details as $detail)
                                                <tr>
                                                    <td>
                                                        <div>{{ $detail->product_name }}</div>
                                                        <small class="text-muted">ID: {{ $detail->product_id }}</small>
                                                    </td>
                                                    <td>{{ $detail->variant_name ?? 'N/A' }}</td>
                                                    <td>{{ number_format($detail->price) }}đ</td>
                                                    <td>{{ $detail->quantity }}</td>
                                                    <td>{{ number_format($detail->price * $detail->quantity) }}đ</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4" class="text-end">Tổng cộng:</th>
                                                <th>{{ number_format($order->total_price) }}đ</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Actions -->
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Hành động</h5>
                            </div>
                            <div class="card-body">
                                <button class="btn btn-info w-100 mb-3" onclick="printOrder()">
                                    <i class="fas fa-print"></i> In đơn hàng
                                </button>
                                <form method="POST" action="{{ route('admin.orders.destroy', $order) }}"
                                    onsubmit="return confirm('Bạn có chắc muốn xóa đơn hàng này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="fas fa-trash"></i> Xóa đơn hàng
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                    

                    
                </div>
            </div>
        </div>
    </main>
@endsection

<script>
    // Order data for printing
    const orderData = {
        id: {{ $order->id }},
        orderDate: '{{ $order->order_date ? $order->order_date->format('d/m/Y H:i') : 'N/A' }}',
        customerName: '{{ $order->user->name ?? 'N/A' }}',
        customerEmail: '{{ $order->user->email ?? 'N/A' }}',
        customerPhone: '{{ $order->user->phone ?? 'N/A' }}',
        receiverName: '{{ $order->receiver_name }}',
        receiverPhone: '{{ $order->receiver_phone }}',
        shippingAddress: '{{ $order->shipping_address }}',
        paymentMethod: '{{ $order->payment_method === 'COD' ? 'Thanh toán khi nhận hàng' : ($order->payment_method === 'bank_transfer' ? 'Chuyển khoản' : 'Ví điện tử') }}',
        status: '{{ $order->order_status === 'pending' ? 'Chờ xác nhận' : ($order->order_status === 'processing' ? 'Đang xử lý' : ($order->order_status === 'shipping' ? 'Đang giao' : ($order->order_status === 'completed' ? 'Hoàn thành' : 'Đã hủy'))) }}',
        voucher: '{{ $order->voucher ? $order->voucher->code . ' (' . ($order->voucher->discount_type === 'percent' ? $order->voucher->discount_value . '%' : number_format($order->voucher->discount_value) . 'đ') . ')' : '' }}',
        totalPrice: '{{ number_format($order->total_price) }}',
        details: [
            @foreach($order->details as $detail)
                            {
                    productName: '{{ $detail->product_name }}',
                    variantName: '{{ $detail->variant_name ?? 'N/A' }}',
                    price: '{{ number_format($detail->price) }}',
                    quantity: {{ $detail->quantity }},
                    total: '{{ number_format($detail->price * $detail->quantity) }}'
                }{{ !$loop->last ? ',' : '' }}
            @endforeach
        ]
    };

    $(document).ready(function () {
        // Configure Toastr
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        $('#statusForm').submit(function (e) {
            e.preventDefault();

            const formData = $(this).serialize();

            $.ajax({
                url: '{{ route("admin.orders.updateStatus", $order) }}',
                method: 'PATCH',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        // Update badge
                        const statusSelect = $('#statusSelect');
                        const badge = $('.badge');
                        const newStatus = response.status;

                        badge.removeClass('bg-warning bg-info bg-primary bg-success bg-danger');

                        switch (newStatus) {
                            case 'pending':
                                badge.addClass('bg-warning').text('Chờ xác nhận');
                                break;
                            case 'processing':
                                badge.addClass('bg-info').text('Đang xử lý');
                                break;
                            case 'shipping':
                                badge.addClass('bg-primary').text('Đang giao');
                                break;
                            case 'completed':
                                badge.addClass('bg-success').text('Hoàn thành');
                                break;
                            case 'cancelled':
                                badge.addClass('bg-danger').text('Đã hủy');
                                break;
                        }

                        // Show success message with Toastr
                        toastr.success(response.message || 'Cập nhật trạng thái thành công');
                    }
                },
                error: function (xhr) {
                    const errorMessage = xhr.responseJSON?.message || 'Có lỗi xảy ra khi cập nhật trạng thái';
                    toastr.error(errorMessage);
                }
            });
        });
    });

    function printOrder() {
        // Create print content element
        const printElement = document.createElement('div');
        printElement.style.position = 'absolute';
        printElement.style.left = '-9999px';
        printElement.style.top = '-9999px';
        printElement.style.width = '800px';
        printElement.style.background = 'white';
        printElement.style.padding = '20px';
        printElement.style.fontFamily = 'Arial, sans-serif';
        printElement.style.lineHeight = '1.6';
        printElement.innerHTML = `
            <div style="text-align: center; border-bottom: 2px solid #000; padding-bottom: 20px; margin-bottom: 30px;">
                <h1 style="margin: 0; font-size: 24px;">ĐƠN HÀNG</h1>
                <p style="margin: 5px 0; font-size: 14px;">Mã đơn hàng: ${orderData.id}</p>
                <p style="margin: 5px 0; font-size: 14px;">Ngày đặt: ${orderData.orderDate}</p>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <h3 style="margin-bottom: 10px; font-size: 16px; border-bottom: 1px solid #ccc; padding-bottom: 5px;">Thông tin khách hàng</h3>
                    <div style="margin-bottom: 8px;"><strong>Tên:</strong> ${orderData.customerName}</div>
                    <div style="margin-bottom: 8px;"><strong>Email:</strong> ${orderData.customerEmail}</div>
                    <div style="margin-bottom: 8px;"><strong>SĐT:</strong> ${orderData.customerPhone}</div>
                </div>
                <div>
                    <h3 style="margin-bottom: 10px; font-size: 16px; border-bottom: 1px solid #ccc; padding-bottom: 5px;">Thông tin người nhận</h3>
                    <div style="margin-bottom: 8px;"><strong>Tên:</strong> ${orderData.receiverName}</div>
                    <div style="margin-bottom: 8px;"><strong>SĐT:</strong> ${orderData.receiverPhone}</div>
                    <div style="margin-bottom: 8px;"><strong>Địa chỉ:</strong> ${orderData.shippingAddress}</div>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <h3 style="margin-bottom: 10px; font-size: 16px; border-bottom: 1px solid #ccc; padding-bottom: 5px;">Chi tiết đơn hàng</h3>
                <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                    <thead>
                        <tr>
                            <th style="border: 1px solid #ddd; padding: 8px; text-align: left; background-color: #f5f5f5; font-weight: bold;">Sản phẩm</th>
                            <th style="border: 1px solid #ddd; padding: 8px; text-align: left; background-color: #f5f5f5; font-weight: bold;">Biến thể</th>
                            <th style="border: 1px solid #ddd; padding: 8px; text-align: left; background-color: #f5f5f5; font-weight: bold;">Đơn giá</th>
                            <th style="border: 1px solid #ddd; padding: 8px; text-align: left; background-color: #f5f5f5; font-weight: bold;">Số lượng</th>
                            <th style="border: 1px solid #ddd; padding: 8px; text-align: left; background-color: #f5f5f5; font-weight: bold;">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${orderData.details.map(detail => `
                            <tr>
                                <td style="border: 1px solid #ddd; padding: 8px;">${detail.productName}</td>
                                <td style="border: 1px solid #ddd; padding: 8px;">${detail.variantName}</td>
                                <td style="border: 1px solid #ddd; padding: 8px;">${detail.price}đ</td>
                                <td style="border: 1px solid #ddd; padding: 8px;">${detail.quantity}</td>
                                <td style="border: 1px solid #ddd; padding: 8px;">${detail.total}đ</td>
                            </tr>
                        `).join('')}
                    </tbody>
                    <tfoot>
                        <tr style="background-color: #f9f9f9; font-weight: bold;">
                            <td colspan="4" style="border: 1px solid #ddd; padding: 8px; text-align: right;">Tổng cộng:</td>
                            <td style="border: 1px solid #ddd; padding: 8px;">${orderData.totalPrice}đ</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="margin-bottom: 8px;"><strong>Phương thức thanh toán:</strong> ${orderData.paymentMethod}</div>
                <div style="margin-bottom: 8px;"><strong>Trạng thái:</strong> ${orderData.status}</div>
                ${orderData.voucher ? `<div style="margin-bottom: 8px;"><strong>Voucher:</strong> ${orderData.voucher}</div>` : ''}
            </div>

            <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #ccc;">
                <p>Cảm ơn quý khách đã mua hàng!</p>
                <p>Ngày in: ${new Date().toLocaleDateString('vi-VN')}</p>
            </div>
        `;

        document.body.appendChild(printElement);

        // Use html2canvas and jsPDF to create PDF
        html2canvas(printElement, {
            scale: 2,
            useCORS: true,
            allowTaint: true
        }).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF('p', 'mm', 'a4');

            const imgWidth = 210; // A4 width in mm
            const pageHeight = 295; // A4 height in mm
            const imgHeight = (canvas.height * imgWidth) / canvas.width;
            let heightLeft = imgHeight;

            let position = 0;

            pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;

            while (heightLeft >= 0) {
                position = heightLeft - imgHeight;
                pdf.addPage();
                pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;
            }

            // Download PDF
            pdf.save(`don-hang-${orderData.id}.pdf`);

            // Remove temporary element
            document.body.removeChild(printElement);

            // Show success message
            toastr.success('PDF đã được tải xuống thành công!');
        }).catch(error => {
            console.error('Error generating PDF:', error);
            toastr.error('Có lỗi xảy ra khi tạo PDF');
            document.body.removeChild(printElement);
        });
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

    // Initialize select background on page load
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('statusSelect');
        if (statusSelect) {
            updateSelectBackground(statusSelect);

            // Update background when select value changes
            statusSelect.addEventListener('change', function() {
                updateSelectBackground(this);
            });
        }
    });
</script>