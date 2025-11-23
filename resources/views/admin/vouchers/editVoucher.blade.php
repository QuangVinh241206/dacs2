@extends('layouts.admin.master')

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Sửa mã giảm giá</h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        <a href="{{ route('admin.vouchers.index') }}" class="btn btn-sm btn-secondary">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.vouchers.update', $voucher->id) }}" method="POST" class="row g-3">
                            @csrf
                            @method('PUT')
                            <div class="col-md-4">
                                <label class="form-label">Mã</label>
                                <input name="code" class="form-control" value="{{ old('code', $voucher->code) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Loại</label>
                                <select name="discount_type" class="form-select">
                                    <option value="percent" {{ $voucher->discount_type == 'percent' ? 'selected' : '' }}>Phần
                                        trăm</option>
                                    <option value="fixed" {{ $voucher->discount_type == 'fixed' ? 'selected' : '' }}>Tiền
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Giá trị</label>
                                <input name="discount_value" type="number" class="form-control"
                                    value="{{ old('discount_value', $voucher->discount_value) }}" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Giá trị đơn tối thiểu</label>
                                <input name="min_order_value" type="number" class="form-control"
                                    value="{{ old('min_order_value', $voucher->min_order_value) }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Giảm tối đa</label>
                                <input name="max_discount_value" type="number" class="form-control"
                                    value="{{ old('max_discount_value', $voucher->max_discount_value) }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Ngày bắt đầu</label>
                                <input name="start_date" type="date" class="form-control"
                                    value="{{ old('start_date', $voucher->start_date) }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Ngày kết thúc</label>
                                <input name="end_date" type="date" class="form-control"
                                    value="{{ old('end_date', $voucher->end_date) }}">
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ $voucher->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Kích hoạt</label>
                                </div>
                            </div>

                            <div class="col-12 text-end">
                                <button class="btn btn-primary">Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection