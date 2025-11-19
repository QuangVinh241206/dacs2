@extends('layouts.admin.master')

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Sửa danh mục</h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-secondary">Quay lại</a>
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
                        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Tên danh mục</label>
                                <input name="name" value="{{ old('name', $category->name) }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Slug</label>
                                <input name="slug" value="{{ old('slug', $category->slug) }}" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mô tả</label>
                                <textarea name="description" class="form-control"
                                    rows="4">{{ old('description', $category->description) }}</textarea>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary">Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection