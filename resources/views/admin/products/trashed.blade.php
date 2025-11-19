@extends('layouts.admin.master')

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Sản phẩm đã xóa</h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-secondary">Tới trang danh sách</a>
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
                                    <th>Tên sản phẩm</th>
                                    <th>Danh mục</th>
                                    <th>Số biến thể</th>
                                    <th>Giá</th>
                                    <th>Xóa vào ngày</th>
                                    <th style="width:160px">Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $p)
                                    <tr>
                                        <td>{{ $p->id }}</td>
                                        <td>{{ $p->name }}</td>
                                        <td>{{ optional($p->category)->name }}</td>
                                        <td>{{ $p->variants->count() }}</td>
                                        <td>
                                            @if($p->variants->count())
                                                {{ number_format($p->variants->min('price'), 0, ',', '.') }} -
                                                {{ number_format($p->variants->max('price'), 0, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $p->updated_at }}</td>
                                        <td>
                                            <form action="{{ route('admin.products.restore', $p->id) }}" method="POST"
                                                style="display:inline-block">
                                                @csrf
                                                <button class="btn btn-sm btn-success">Khôi phục</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection