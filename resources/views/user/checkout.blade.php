@extends('layouts.user.master')
@section('content')
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="relative mb-8">
                <h1 class="text-3xl font-bold text-gray-900 text-center">Thông tin đơn hàng</h1>
                <a href="{{ route('user.cart.index') }}"
                    class="absolute left-0 top-1/2 transform -translate-y-1/2 text-blue-600 hover:text-blue-800">
                    <i class="ri-arrow-left-line text-2xl"></i>
                </a>
            </div>

            <!-- Selected Products -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Sản phẩm đã chọn</h2>
                <div class="space-y-4">
                    @foreach($items as $item)
                        <div class="flex items-center space-x-4 border-b pb-4">
                            <img src="{{asset('storage/' . ($item->product->images->where('is_main', true)->first()->image_url ?? 'https://via.placeholder.com/80')) }}"
                                alt="{{ $item->product->name }}" class="w-20 h-20 object-cover rounded">
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900">{{ $item->product->name }}</h3>
                                @if($item->variant)
                                    <p class="text-sm text-gray-600">{{ $item->variant->size }} - {{ $item->variant->color }}</p>
                                @endif
                                <p class="text-sm text-gray-600">Số lượng: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-900">
                                    {{ number_format($item->variant ? $item->variant->price : $item->product->price) }}₫
                                </p>
                                <p class="text-sm text-gray-600">Tổng:
                                    {{ number_format(($item->variant ? $item->variant->price : $item->product->price) * $item->quantity) }}₫
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 pt-4 ">
                    <!-- Voucher Code -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Mã giảm giá</label>
                        <div class="flex">
                            <input type="text" id="voucher_code"
                                class="flex-1 px-3 py-2 border border-gray-300 rounded-l-md" placeholder="Nhập mã giảm giá">
                            <button type="button" id="apply_voucher"
                                class="bg-primary text-white px-4 py-2 rounded-r-md hover:bg-blue-600 transition">Áp
                                dụng</button>
                        </div>
                    </div>
                    @php
                        $subtotal = $items->sum(function ($item) {
                            return ($item->variant ? $item->variant->price : $item->product->price) * $item->quantity;
                        });
                    @endphp
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-medium text-gray-700">Tạm tính:</span>
                            <span id="subtotal-price"
                                class="text-lg font-semibold text-gray-900">{{ number_format($subtotal) }}₫</span>
                        </div>
                        <div class="flex justify-between items-center text-green-600">
                            <span class="text-lg font-medium">Giảm giá:</span>
                            <span id="discount-price" class="text-lg font-semibold">-0₫</span>
                        </div>
                        <div class="flex justify-between items-center border-t pt-2">
                            <span class="text-lg font-medium text-gray-700">Tổng tiền:</span>
                            <span id="total-price"
                                class="text-2xl font-bold text-primary">{{ number_format($subtotal) }}₫</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <form id="checkout-form" action="{{ route('user.checkout.store') }}" method="POST">
                    @csrf
                    <!-- Hidden input for selected items -->
                    @foreach($items as $item)
                        <input type="hidden" name="selected_items[]" value="{{ $item->id }}">
                    @endforeach
                    <!-- Hidden input for voucher code -->
                    <input type="hidden" name="voucher_code" id="hidden_voucher_code" value="">
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Họ và tên</label>
                        <input type="text" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Số điện thoại</label>
                        <input type="tel" name="phone" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Địa chỉ</label>
                        <textarea name="address" class="w-full px-3 py-2 border border-gray-300 rounded-md" rows="3"
                            required></textarea>
                    </div>

                    <!-- Phương thức thanh toán -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-4">Phương thức thanh toán</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="payment-method-card cursor-pointer" data-method="cod">
                                <input type="radio" id="cod" name="payment_method" value="cod" class="hidden peer" required>
                                <div
                                    class="border-2 border-gray-300 rounded-lg p-4 hover:border-blue-500 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition flex items-center">

                                    <div>
                                        <div class="font-medium text-gray-900 flex items-center">
                                            <i class="ri-cash-line mr-2"></i>
                                            Thanh toán khi nhận hàng
                                        </div>
                                        <div class="text-sm text-gray-600">Thanh toán bằng tiền mặt khi nhận hàng</div>
                                    </div>
                                </div>
                            </div>
                            <div class="payment-method-card cursor-pointer" data-method="bank_transfer">
                                <input type="radio" id="bank_transfer" name="payment_method" value="bank_transfer" class="hidden peer">
                                <div
                                    class="border-2 border-gray-300 rounded-lg p-4 hover:border-blue-500 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition flex items-center">

                                    <div>
                                        <div class="font-medium text-gray-900 flex items-center">
                                            <i class="ri-qr-code-line mr-2"></i>
                                            Chuyển khoản QR
                                        </div>
                                        <div class="text-sm text-gray-600">Quét mã QR để thanh toán</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit"
                            class="bg-primary text-white px-8 py-3 rounded-button font-medium hover:bg-blue-600 transition">Đặt
                            hàng</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            $(document).ready(function () {
                function formatVnd(number) {
                    try {
                        return new Intl.NumberFormat('vi-VN').format(number) + '₫';
                    } catch (e) {
                        return number + '₫';
                    }
                }

                function getSelectedItems() {
                    return $('input[name="selected_items[]"]').map(function () { return $(this).val(); }).get();
                }

                function applyVoucherCode(voucherCode) {
                    const selectedItems = getSelectedItems();
                    if (!selectedItems.length) {
                        toastr.error('Vui lòng chọn sản phẩm để thanh toán!');
                        return;
                    }

                    $.ajax({
                        url: '{{ route('user.checkout.voucher.validate') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            voucher_code: voucherCode,
                            selected_items: selectedItems,
                        },
                        success: function (res) {
                            const subtotal = res.subtotal ?? 0;
                            const discount = res.discount ?? 0;
                            const total = res.total ?? subtotal;

                            $('#subtotal-price').text(formatVnd(subtotal));
                            $('#discount-price').text('-' + formatVnd(discount));
                            $('#total-price').text(formatVnd(total));

                            if (res.ok && voucherCode) {
                                $('#hidden_voucher_code').val(voucherCode);
                                toastr.success(res.message || ('Đã áp dụng mã giảm giá: ' + voucherCode));
                            } else {
                                $('#hidden_voucher_code').val('');
                                if (voucherCode) {
                                    toastr.error(res.message || 'Không áp dụng được mã giảm giá.');
                                }
                            }
                        },
                        error: function () {
                            toastr.error('Không thể kiểm tra mã giảm giá. Vui lòng thử lại.');
                        }
                    });
                }

                // Ensure payment method selection works
                $('.payment-method-card').click(function () {
                    let method = $(this).data('method');
                    $('input[name="payment_method"]').prop('checked', false);
                    $('#' + method).prop('checked', true).trigger('change');
                });

                // Handle voucher application
                $('#apply_voucher').click(function () {
                    const voucherCode = $('#voucher_code').val().trim();
                    if (!voucherCode) {
                        toastr.error('Vui lòng nhập mã giảm giá!');
                        return;
                    }

                    applyVoucherCode(voucherCode);
                });

                // Allow pressing Enter in voucher input
                $('#voucher_code').keypress(function (e) {
                    if (e.which === 13) {
                        e.preventDefault();
                        $('#apply_voucher').click();
                    }
                });

                // Form validation before submit
                $('#checkout-form').submit(function (e) {
                    const name = $('input[name="name"]').val().trim();
                    const phone = $('input[name="phone"]').val().trim();
                    const address = $('textarea[name="address"]').val().trim();
                    const paymentMethod = $('input[name="payment_method"]:checked').val();

                    if (!name) {
                        e.preventDefault();
                        toastr.error('Vui lòng nhập họ và tên!');
                        $('input[name="name"]').focus();
                        return false;
                    }

                    if (!phone) {
                        e.preventDefault();
                        toastr.error('Vui lòng nhập số điện thoại!');
                        $('input[name="phone"]').focus();
                        return false;
                    }

                    if (!address) {
                        e.preventDefault();
                        toastr.error('Vui lòng nhập địa chỉ!');
                        $('textarea[name="address"]').focus();
                        return false;
                    }

                    if (!paymentMethod) {
                        e.preventDefault();
                        toastr.error('Vui lòng chọn phương thức thanh toán!');
                        return false;
                    }

                    // Show loading state
                    const submitBtn = $(this).find('button[type="submit"]');
                    submitBtn.prop('disabled', true).text('Đang xử lý...');
                });
            });
        </script>

    @endpush
@endsection