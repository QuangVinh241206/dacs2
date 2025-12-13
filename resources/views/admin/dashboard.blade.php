@extends('layouts.admin.master')
@section('content')
  <main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
      <!--begin::Container-->
      <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
          <div class="col-sm-6">
            <h3 class="mb-0">Dashboard</h3>
          </div>
        </div>
        <!--end::Row-->
      </div>
      <!--end::Container-->
    </div>
    <!--end::App Content Header-->
    <!--begin::App Content-->
    <div class="app-content">
      <!--begin::Container-->
      <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
          <!--begin::Col-->
          <div class="col-lg-3 col-6">
            <!--begin::Small Box Widget 1-->
            <div class="small-box text-bg-primary">
              <div class="inner">
                <h3>{{ $productCount ?? 0 }}</h3>
                <p>Sản phẩm</p>
              </div>
              <i class="small-box-icon bi bi-box-seam" aria-hidden="true"></i>
              <a href="{{ route("admin.products.index") }}"
                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                Chi tiết <i class="bi bi-link-45deg"></i>
              </a>
            </div>
            <!--end::Small Box Widget 1-->
          </div>
          <!--end::Col-->
          <div class="col-lg-3 col-6">
            <!--begin::Small Box Widget 2-->
            <div class="small-box text-bg-success">
              <div class="inner">
                <h3>{{ $categoryCount ?? 0 }}</h3>
                <p>Danh mục</p>
              </div>
              <i class="small-box-icon bi bi-tags" aria-hidden="true"></i>
              <a href="{{ route("admin.categories.index") }}"
                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                Chi tiết <i class="bi bi-link-45deg"></i>
              </a>
            </div>
            <!--end::Small Box Widget 2-->
          </div>
          <!--end::Col-->
          <div class="col-lg-3 col-6">
            <!--begin::Small Box Widget 3-->
            <div class="small-box text-bg-warning">
              <div class="inner">
                <h3>{{ $orderCount ?? 0 }}</h3>
                <p>Đơn hàng</p>
              </div>
              <i class="small-box-icon bi bi-receipt" aria-hidden="true"></i>
              <a href="{{ route("admin.orders.index") }}"
                class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                Chi tiết <i class="bi bi-link-45deg"></i>
              </a>
            </div>
            <!--end::Small Box Widget 3-->
          </div>
          <!--end::Col-->
          <div class="col-lg-3 col-6">
            <!--begin::Small Box Widget 4-->
            <div class="small-box text-bg-danger">
              <div class="inner">
                <h3>{{ $userCount ?? 0 }}</h3>
                <p>Người dùng</p>
              </div>
              <i class="small-box-icon bi bi-people" aria-hidden="true"></i>
              <a href="{{ route("admin.users.index") }}"
                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                Chi tiết <i class="bi bi-link-45deg"></i>
              </a>
            </div>
            <!--end::Small Box Widget 4-->
          </div>
          <!--end::Col-->
        </div>
        <!--end::Row-->
        <!--begin::Row-->

        <!--end::Row-->
      </div>
    </div>
    </div>
    <!-- /.Start col -->
    </div>
    <!-- /.row (main row) -->
    </div>
    <!--end::Container-->
    </div>
    <!--end::App Content-->
  </main>
  <!--end::App Main-->
@endsection