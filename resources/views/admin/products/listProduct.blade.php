@extends('layouts.admin.master')

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Danh sách sản phẩm</h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-secondary">Refresh</a>
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
                    <div class="card-header">
                        <form method="GET" action="{{ route('admin.products.index') }}" class="row g-2">
                            <div class="col-md-4">
                                <input type="text" name="q" class="form-control" placeholder="Tìm kiếm tên hoặc mô tả"
                                    value="{{ request('q') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="category_id" class="form-select">
                                    <option value="">Tất cả danh mục</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="price_min" class="form-control" placeholder="Giá từ"
                                    value="{{ request('price_min') }}" min="0">
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="price_max" class="form-control" placeholder="Đến"
                                    value="{{ request('price_max') }}" min="0">
                            </div>
                            <div class="col-md-1 text-end">
                                <button class="btn btn-primary">Lọc</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th style="width:60px">#</th>
                                    <th>Ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Danh mục</th>
                                    <th>Số biến thể</th>
                                    <th>Giá</th>
                                    <th>Trạng thái</th>
                                    <th style="width:200px">Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $p)
                                    <tr>
                                        <td>{{ $p->id }}</td>
                                        <td><a href="{{ route('admin.products.show', $p->id) }}">{{ $p->name }}</a></td>
                                        <td><img src="{{ asset('storage/' . ($p->images->where('is_main', true)->first()->image_url ?? '')) }}"
                                                alt="{{ $p->name }}" style="max-width: 100px;"></td>
                                        <td>{{ optional($p->category)->name }}</td>
                                        <td>{{ $p->variants->count() }}</td>
                                        <td>
                                            @if($p->variants->count())
                                                {{ number_format($p->variants->min('price'), 0, ',', '.') }}đ -
                                                {{ number_format($p->variants->max('price'), 0, ',', '.') }}đ
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $p->status == 1 ? 'Hoạt động' : 'Tạm ngưng' }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-primary"
                                                href="{{ route('admin.products.show', $p->id) }}">Xem</a>
                                            <a class="btn btn-sm btn-warning"
                                                href="{{ route('admin.products.edit', $p->id) }}">Sửa</a>
                                            <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST"
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
                            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection