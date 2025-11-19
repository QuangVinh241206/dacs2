@extends('layouts.admin.master')

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Sản phẩm: {{ $product->name }}</h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-secondary">Quay lại danh
                            sách</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card mb-4">
                    <div class="card-body">
                        <p><strong>Slug:</strong><br>{{ $product->slug }}</p>
                        <p><strong>Danh mục:</strong> {{ optional($product->category)->name }}</p>
                        <p><strong>Mô tả:</strong><br>{{ $product->description }}</p>
                    </div>
                </div>

                <h5>Ảnh sản phẩm</h5>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row g-2">
                            @foreach($product->images as $img)
                                <div class="col-md-3">
                                    <div class="card">
                                        <img src="{{ asset('storage/'.$img->image_url) }}" class="card-img-top" style="height:180px;object-fit:cover">
                                        <div class="card-body p-2">
                                            @if($img->is_main)
                                                <span class="badge bg-success">Ảnh chính</span>
                                            @else
                                                <form action="{{ route('admin.products.images.setMain', [$product->id, $img->id]) }}" method="POST" style="display:inline-block">
                                                    @csrf
                                                    <button class="btn btn-sm btn-outline-primary">Đặt ảnh chính</button>
                                                </form>
                                            @endif

                                            <form action="{{ route('admin.products.images.destroy', [$product->id, $img->id]) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa ảnh này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">Xóa</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <hr>
                        <form action="{{ route('admin.products.images.upload', $product->id) }}" method="POST" enctype="multipart/form-data" class="row g-2">
                            @csrf
                            <div class="col-md-6">
                                <input type="file" name="image" class="form-control" accept="image/*" required>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-success">Tải lên</button>
                            </div>
                        </form>
                    </div>
                </div>

                <h5>Các biến thể</h5>
                <div class="card">
                    <div class="card-body p-0">
                        <table class="table table-sm table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kích thước</th>
                                    <th>Màu sắc</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>SKU</th>
                                    <th style="width:200px">Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product->variants as $v)
                                    <tr>
                                        <td>{{ $v->id }}</td>
                                        <td>{{ $v->size }}</td>
                                        <td>{{ $v->color }}</td>
                                        <td>{{ number_format($v->price, 0, ',', '.') }}</td>
                                        <td>{{ $v->stock }}</td>
                                        <td>{{ $v->sku }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#editVariantModal{{ $v->id }}">Sửa</button>
                                            <form
                                                action="{{ route('admin.products.variants.destroy', [$product->id, $v->id]) }}"
                                                method="POST" style="display:inline-block"
                                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Variant Modal -->
                                    <div class="modal fade" id="editVariantModal{{ $v->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form
                                                    action="{{ route('admin.products.variants.update', [$product->id, $v->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">SỬa biến thể #{{ $v->id }}</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-2">
                                                            <label class="form-label">Kích thước</label>
                                                            <input name="size" class="form-control" value="{{ $v->size }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="form-label">Màu sắc</label>
                                                            <input name="color" class="form-control" value="{{ $v->color }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="form-label">Giá</label>
                                                            <input name="price" class="form-control" value="{{ $v->price }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="form-label">Số lượng</label>
                                                            <input name="stock" class="form-control" value="{{ $v->stock }}">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="form-label">SKU</label>
                                                            <input name="sku" class="form-control" value="{{ $v->sku }}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Hủy</button>
                                                        <button class="btn btn-primary">Lưu</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <h5 class="mt-4">Thêm biến thể mới</h5>
                <form action="{{ route('admin.products.variants.store', $product->id) }}" method="POST"
                    class="row g-2 mb-4">
                    @csrf
                    <div class="col-md-2">
                        <input name="size" class="form-control" placeholder="Kích thước">
                    </div>
                    <div class="col-md-2">
                        <input name="color" class="form-control" placeholder="Mau sắc">
                    </div>
                    <div class="col-md-2">
                        <input name="price" class="form-control" placeholder="Giá" required>
                    </div>
                    <div class="col-md-2">
                        <input name="stock" class="form-control" placeholder="Số lượng" required>
                    </div>
                    <div class="col-md-2">
                        <input name="sku" class="form-control" placeholder="SKU">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-success w-100">Thêm biến thể</button>
                    </div>
                </form>

            </div>
        </div>
    </main>
@endsection