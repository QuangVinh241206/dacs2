@extends('layouts.admin.master')

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Thêm sản phẩm</h3>
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
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.products.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Tên sản phẩm</label>
                                <input id="product-name" name="name" value="{{ old('name') }}" class="form-control"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Slug</label>
                                <input id="product-slug" name="slug" value="{{ old('slug') }}" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Danh mục</label>
                                <select name="category_id" class="form-select">
                                    @foreach($categories as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Trạng thái</label>
                                <select name="status" class="form-select">
                                    <option value="1">Hoạt động</option>
                                    <option value="0">Tạm ngưng</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mô tả</label>
                                <textarea name="description" class="form-control"
                                    rows="5">{{ old('description') }}</textarea>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary">Thêm sản phẩm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        (function () {
            function slugify(text) {
                return text.toString().toLowerCase().trim()
                    .replace(/[^a-z0-9\-\s_]/g, '')
                    .replace(/[\s_]+/g, '-')
                    .replace(/\-+/g, '-')
                    .replace(/(^-|-$)/g, '');
            }

            const name = document.getElementById('product-name');
            const slug = document.getElementById('product-slug');
            if (!name || !slug) return;
            slug.dataset.manual = slug.value ? 'true' : 'false';
            name.addEventListener('input', function () {
                if (slug.dataset.manual !== 'true') {
                    slug.value = slugify(name.value);
                }
            });
            slug.addEventListener('input', function () {
                slug.dataset.manual = slug.value.length > 0 && slug.value !== slugify(name.value) ? 'true' : 'false';
            });
        })();
    </script>
@endsection