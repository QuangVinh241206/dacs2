@extends('layouts.user.master')
@section('content')
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="relative mb-8">
                <h1 class="text-3xl font-bold text-gray-900 text-center">Giỏ hàng của bạn</h1>
                <a href="{{ route('home') }}"
                    class="absolute left-0 top-1/2 transform -translate-y-1/2 text-blue-600 hover:text-blue-800">
                    <i class="ri-arrow-left-line text-2xl"></i>
                </a>
            </div>
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if($items->isEmpty())
                <div class="text-center py-12">
                    <i class="ri-shopping-cart-2-line text-6xl text-gray-300 mb-4"></i>
                    <h2 class="text-xl font-medium text-gray-600 mb-4">Giỏ hàng trống</h2>
                    <a href="{{ route('user.products') }}"
                        class="bg-primary text-white px-6 py-3 rounded-button font-medium hover:bg-blue-600 transition">Tiếp tục
                        mua sắm</a>
                </div>
            @else
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <!-- Select All Checkbox -->
                    <div class="flex items-center mb-4">
                        <input type="checkbox" id="select-all" class="w-4 h-4 rounded-full mr-3">
                        <label for="select-all" class="text-gray-700 font-medium">Chọn tất cả</label>
                    </div> <!-- Cart Items -->
                    <div id="cart-items" class="space-y-4">
                        @foreach($items as $item)
                            <div class="relative bg-gray-50 rounded-lg p-4 border border-gray-200 cart-item"
                                data-detail-id="{{ $item->id }}" data-stock="{{ $item->variant->stock }}">
                                <!-- Checkbox top-left -->
                                <input type="checkbox" class="absolute top-3 left-3 w-4 h-4 rounded-full item-checkbox"
                                    data-price="{{ $item->variant->price * (1 - ($item->product->discount_percent ?? 0) / 100) * $item->quantity }}"
                                    data-unit-price="{{ $item->variant->price * (1 - ($item->product->discount_percent ?? 0) / 100) }}">

                                <!-- Delete button top-right -->
                                <button class="absolute top-3 right-3 text-red-500 hover:text-red-700 delete-item"
                                    data-detail-id="{{ $item->id }}">
                                    <i class="ri-delete-bin-line text-xl"></i>
                                </button>

                                <div class="flex items-center space-x-4">
                                    <!-- Product Image -->
                                    <div class="w-20 h-20 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                                        @if($item->product->images->first())
                                            <img src="{{ asset('storage/' . $item->product->images->where('is_main', true)->first()->image_url) }}"
                                                alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">No image</div>
                                        @endif
                                    </div>

                                    <!-- Product Info -->
                                    <div class="flex-1">
                                        <h3 class="text-lg font-medium text-gray-900">{{ $item->product->name }}</h3>
                                        <p class="text-sm text-gray-600 mb-1">Biến thể: {{ $item->variant->size ?? 'N/A' }} -
                                            {{ $item->variant->color ?? 'N/A' }}
                                        </p>
                                        <div class="flex items-center space-x-2">
                                            <span
                                                class="text-lg font-bold text-primary">{{ number_format($item->variant->price * (1 - ($item->product->discount_percent ?? 0) / 100), 0, ',', '.') }}₫</span>
                                            @if($item->product->discount_percent)
                                                <span
                                                    class="text-sm text-gray-500 line-through">{{ number_format($item->variant->price, 0, ',', '.') }}₫</span>
                                                <span class="text-sm text-orange-500">-{{ $item->product->discount_percent }}%</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Quantity Controls -->
                                    <div class="flex items-center space-x-2">
                                        <button
                                            class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 text-gray-700 hover:bg-gray-100 decrease-qty"
                                            data-detail-id="{{ $item->id }}">-</button>
                                        <input type="number" value="{{ $item->quantity }}" min="1" max="{{ $item->variant->stock }}"
                                            class="w-12 text-center border border-gray-300 rounded qty-input"
                                            data-detail-id="{{ $item->id }}">
                                        <button
                                            class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 text-gray-700 hover:bg-gray-100 increase-qty"
                                            data-detail-id="{{ $item->id }}">+</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Total and Checkout -->
                <form id="checkout-form" action="{{ route('user.cart.checkout') }}" method="POST">
                    @csrf
                    <div id="selected-items-container"></div>
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-lg font-medium text-gray-700">Tổng tiền:</span>
                            <span id="total-price" class="text-2xl font-bold text-primary">0₫</span>
                        </div>
                        <div class="text-center">
                            <button type="submit" id="checkout-btn"
                                class="bg-primary text-white px-8 py-3 rounded-button font-medium hover:bg-blue-600 transition disabled:bg-gray-400"
                                disabled>Mua ngay</button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </section>

    @push('scripts')
        <script>
            $(document).ready(function () {
                // CSRF setup
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // Update total price and selected items
                function updateTotal() {
                    let total = 0;
                    let selectedItems = [];
                    $('.item-checkbox:checked').each(function () {
                        total += parseFloat($(this).data('price')) || 0;
                        selectedItems.push($(this).closest('.cart-item').attr('data-detail-id'));
                    });
                    $('#total-price').text(new Intl.NumberFormat('vi-VN').format(Math.round(total)) + '₫');
                    $('#checkout-btn').prop('disabled', total === 0);

                    // Update hidden inputs
                    $('#selected-items-container').empty();
                    selectedItems.forEach(function (id) {
                        $('#selected-items-container').append('<input type="hidden" name="selected_items[]" value="' + id + '">');
                    });
                }

                // Select all
                $('#select-all').change(function () {
                    $('.item-checkbox').prop('checked', $(this).is(':checked'));
                    updateTotal();
                });

                // Individual checkbox
                $(document).on('change', '.item-checkbox', function () {
                    let allChecked = $('.item-checkbox:checked').length === $('.item-checkbox').length;
                    $('#select-all').prop('checked', allChecked);
                    updateTotal();
                });

                // Increase quantity
                $(document).on('click', '.increase-qty', function () {
                    let detailId = $(this).data('detail-id');
                    let qtyInput = $(`.qty-input[data-detail-id="${detailId}"]`);
                    let item = $(`.cart-item[data-detail-id="${detailId}"]`);
                    let stock = parseInt(item.data('stock'));
                    let currentQty = parseInt(qtyInput.val());
                    let newQty = currentQty + 1;
                    if (newQty > stock) {
                        toastr.error('Chỉ còn ' + stock + ' sản phẩm trong kho.');
                        return;
                    }
                    qtyInput.val(newQty);
                    updateQuantity(detailId, newQty);
                });

                // Decrease quantity
                $(document).on('click', '.decrease-qty', function () {
                    let detailId = $(this).data('detail-id');
                    let qtyInput = $(`.qty-input[data-detail-id="${detailId}"]`);
                    let newQty = parseInt(qtyInput.val()) - 1;
                    if (newQty >= 1) {
                        qtyInput.val(newQty);
                        updateQuantity(detailId, newQty);
                    }
                });

                // Quantity input change
                $(document).on('change', '.qty-input', function () {
                    let detailId = $(this).data('detail-id');
                    let item = $(`.cart-item[data-detail-id="${detailId}"]`);
                    let stock = parseInt(item.data('stock'));
                    let newQty = parseInt($(this).val());
                    if (newQty > stock) {
                        toastr.options = { "positionClass": "toast-top-left" };
                        toastr.error('Số lượng không được vượt quá ' + stock + ' sản phẩm.');
                        $(this).val(stock);
                        newQty = stock;
                    } else if (newQty < 1) {
                        $(this).val(1);
                        newQty = 1;
                    }
                    updateQuantity(detailId, newQty);
                });

                // Update quantity via AJAX
                function updateQuantity(detailId, quantity) {
                    $.post('{{ route("user.cart.update") }}', {
                        detail_id: detailId,
                        quantity: quantity
                    }).done(function (res) {
                        if (res.success) {
                            // Update the data-price for the item
                            let item = $(`.cart-item[data-detail-id="${detailId}"]`);
                            let checkbox = item.find('.item-checkbox');
                            let unitPrice = parseFloat(checkbox.data('unit-price'));
                            checkbox.data('price', unitPrice * quantity);
                            updateTotal();
                        } else {
                            alert(res.message || 'Lỗi cập nhật số lượng');
                        }
                    }).fail(function (xhr) {
                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            let errors = Object.values(xhr.responseJSON.errors).flat().join('\n');
                            alert('Lỗi dữ liệu: ' + errors);
                        } else if (xhr.status === 403) {
                            alert('Bạn không có quyền cập nhật sản phẩm này');
                        } else {
                            alert('Lỗi kết nối khi cập nhật số lượng');
                        }
                    });
                }

                // Delete item
                $(document).on('click', '.delete-item', function () {
                    let detailId = $(this).data('detail-id');
                    $.ajax({
                        url: '{{ route("user.cart.destroy", ":detail") }}'.replace(':detail', detailId),
                        method: 'DELETE'
                    }).done(function (res) {
                        if (res.success) {
                            $(`.cart-item[data-detail-id="${detailId}"]`).remove();
                            updateTotal();
                            if ($('.cart-item').length === 0) {
                                location.reload();
                            }
                        } else {
                            alert(res.message || 'Lỗi xóa sản phẩm');
                        }
                    }).fail(function (xhr) {
                        if (xhr.status === 403) {
                            alert('Bạn không có quyền xóa sản phẩm này');
                        } else {
                            alert('Lỗi kết nối khi xóa sản phẩm');
                        }
                    });
                });

                // Form submit for checkout - ensure selected items are updated
                $('#checkout-form').submit(function () {
                    updateTotal();
                });

                // Initial total
                updateTotal();
            });
        </script>
    @endpush
@endsection