<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <!--begin::Brand Image-->
            <img src="{{ asset('storage/logo/admin.png') }}" alt="AdminLTE Logo" class="brand-image shadow" />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">Quản trị viên</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item menu-open">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link active">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-table"></i>
                        <p>
                            Sản phẩm
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.products.index') }}"
                                class="nav-link {{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
                                <i
                                    class="nav-icon bi {{ request()->routeIs('admin.products.index') ? 'bi-circle-fill' : 'bi-circle' }}"></i>
                                <p>Danh sách sản phẩm</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.products.create') }}"
                                class="nav-link {{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
                                <i
                                    class="nav-icon bi {{ request()->routeIs('admin.products.create') ? 'bi-circle-fill' : 'bi-circle' }}"></i>
                                <p>Thêm sản phẩm</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.products.trashed') }}"
                                class="nav-link {{ request()->routeIs('admin.products.trashed') ? 'active' : '' }}">
                                <i
                                    class="nav-icon bi {{ request()->routeIs('admin.products.trashed') ? 'bi-circle-fill' : 'bi-circle' }}"></i>
                                <p>Sản phẩm đã xóa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.categories.index') }}"
                                class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                                <i
                                    class="nav-icon bi {{ request()->routeIs('admin.categories.*') ? 'bi-circle-fill' : 'bi-circle' }}"></i>
                                <p>Danh mục</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.orders.index') }}"
                        class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-box-seam-fill"></i>
                        <p>
                            Đơn hàng
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-person-fill-gear"></i>
                        <p>
                            Tài khoản
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}"
                                class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                                <i
                                    class="nav-icon bi {{ request()->routeIs('admin.users.index') ? 'bi-circle-fill' : 'bi-circle' }}"></i>
                                <p>Danh sách người dùng</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users.trashed') }}"
                                class="nav-link {{ request()->routeIs('admin.users.trashed') ? 'active' : '' }}">
                                <i
                                    class="nav-icon bi {{ request()->routeIs('admin.users.trashed') ? 'bi-circle-fill' : 'bi-circle' }}"></i>
                                <p>Tài khoản đã xóa</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.vouchers.index') }}"
                        class="nav-link {{ request()->routeIs('admin.vouchers.*') ? 'active' : '' }}">
                        <i class="bi bi-gift-fill"></i>
                        <p>
                            Mã giảm giá
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-pencil-square"></i>
                        <p>
                            Đánh giá
                        </p>
                    </a>
                </li>

            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
<!--end::Sidebar-->