@extends('layouts.admin.master')

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Danh mục</h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary">Thêm danh mục</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th style="width:60px">#</th>
                                    <th>Tên danh mục</th>
                                    <th>Slug</th>
                                    <th>Mô tả</th>
                                    <th style="width:160px">Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $c)
                                    <tr>
                                        <td>{{ $c->id }}</td>
                                        <td>{{ $c->name }}</td>
                                        <td>{{ $c->slug }}</td>
                                        <td>{{ Str::limit($c->description, 80) }}</td>
                                        <td>
                                            <a href="{{ route('admin.categories.edit', $c->id) }}"
                                                class="btn btn-sm btn-warning">Sửa</a>
                                            <form action="{{ route('admin.categories.destroy', $c->id) }}" method="POST"
                                                style="display:inline-block" onsubmit="return confirm('Xóa danh mục này?')">
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
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection