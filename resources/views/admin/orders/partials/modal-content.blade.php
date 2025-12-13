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
        <p><strong>Ngày đặt:</strong> {{ $order->order_date ? $order->order_date->format('d/m/Y H:i') : 'N/A' }}</p>
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
                @elseif($order->order_status === 'paid') bg-success
                @elseif($order->order_status === 'pending_payment') bg-secondary
                @else bg-danger
                @endif">
                @if($order->order_status === 'pending') Chờ xác nhận
                @elseif($order->order_status === 'processing') Đang xử lý
                @elseif($order->order_status === 'shipping') Đang giao
                @elseif($order->order_status === 'completed') Hoàn thành
                @elseif($order->order_status === 'cancelled') Đã hủy
                @elseif($order->order_status === 'pending_payment') Chờ thanh toán
                @elseif($order->order_status === 'paid') Đã thanh toán
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

<hr>

<h6>Chi tiết sản phẩm</h6>
<div class="table-responsive">
    <table class="table table-sm">
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
                    <td>{{ $detail->product_name }}</td>
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