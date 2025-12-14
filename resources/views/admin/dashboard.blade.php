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

        <div class="row g-3">
          <div class="col-12 d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Thống kê</h5>
            <div class="d-flex align-items-center gap-2">
              <div id="dashboard-filters" class="d-flex align-items-center gap-2">
                <select id="dashboard-month" class="form-select form-select-sm" style="width: auto"></select>
                <select id="dashboard-year" class="form-select form-select-sm" style="width: auto"></select>
              </div>
              <div class="btn-group btn-group-sm" role="group" aria-label="Chọn khoảng thời gian">
                <button type="button" class="btn btn-outline-primary" data-dashboard-period="week">Tuần</button>
                <button type="button" class="btn btn-outline-primary active" data-dashboard-period="month">Tháng</button>
                <button type="button" class="btn btn-outline-primary" data-dashboard-period="year">Năm</button>
              </div>
            </div>
          </div>

          <div class="col-12 col-xl-7">
            <div class="card">
              <div class="card-header">
                <div class="card-title mb-0">Doanh thu</div>
              </div>
              <div class="card-body">
                <div id="admin-revenue-chart"></div>
              </div>
            </div>
          </div>

          <div class="col-12 col-xl-5">
            <div class="card">
              <div class="card-header">
                <div class="card-title mb-0">Số lượng người dùng mới</div>
              </div>
              <div class="card-body">
                <div id="admin-users-chart"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <!--end::Container-->
    </div>
    <!--end::App Content-->
  </main>
  <!--end::App Main-->
@endsection

@push('scripts')
  <script>
    (function () {
      const statsUrl = @json(route('admin.dashboard.stats'));

      const periodButtons = Array.from(document.querySelectorAll('[data-dashboard-period]'));
      const revenueEl = document.querySelector('#admin-revenue-chart');
      const usersEl = document.querySelector('#admin-users-chart');
      const filtersEl = document.querySelector('#dashboard-filters');
      const monthSelect = document.querySelector('#dashboard-month');
      const yearSelect = document.querySelector('#dashboard-year');
      if (!revenueEl || !usersEl || typeof ApexCharts === 'undefined') return;

      const formatCurrency = (value) => {
        try {
          return new Intl.NumberFormat('vi-VN').format(value) + ' đ';
        } catch (e) {
          return String(value) + ' đ';
        }
      };

      const revenueChart = new ApexCharts(revenueEl, {
        chart: { type: 'area', height: 300, toolbar: { show: false } },
        series: [{ name: 'Doanh thu', data: [] }],
        xaxis: { categories: [] },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2 },
        tooltip: {
          y: { formatter: (val) => formatCurrency(val) },
        },
      });

      const usersChart = new ApexCharts(usersEl, {
        chart: { type: 'bar', height: 300, toolbar: { show: false } },
        series: [{ name: 'Người dùng mới', data: [] }],
        xaxis: { categories: [] },
        dataLabels: { enabled: false },
      });

      revenueChart.render();
      usersChart.render();

      const setActivePeriod = (period) => {
        periodButtons.forEach((btn) => {
          btn.classList.toggle('active', btn.getAttribute('data-dashboard-period') === period);
        });
      };

      const setFiltersVisibility = (period) => {
        if (!filtersEl) return;
        if (period === 'week') {
          // Bootstrap `.d-flex` uses `display: flex !important;` so we must override with `!important`.
          filtersEl.style.setProperty('display', 'none', 'important');
          return;
        }
        filtersEl.style.removeProperty('display');
        if (monthSelect) monthSelect.style.display = period === 'month' ? '' : 'none';
        if (yearSelect) yearSelect.style.display = '';
      };

      const ensureFilterOptions = () => {
        const now = new Date();
        const currentYear = now.getFullYear();
        const currentMonth = now.getMonth() + 1;

        if (monthSelect && monthSelect.options.length === 0) {
          for (let m = 1; m <= 12; m++) {
            const opt = document.createElement('option');
            opt.value = String(m);
            opt.textContent = 'Tháng ' + m;
            if (m === currentMonth) opt.selected = true;
            monthSelect.appendChild(opt);
          }
        }

        if (yearSelect && yearSelect.options.length === 0) {
          // show last 5 years + current
          for (let y = currentYear - 5; y <= currentYear; y++) {
            const opt = document.createElement('option');
            opt.value = String(y);
            opt.textContent = String(y);
            if (y === currentYear) opt.selected = true;
            yearSelect.appendChild(opt);
          }
        }
      };

      let currentPeriod = 'month';

      const buildQuery = (period) => {
        const params = new URLSearchParams();
        params.set('period', period);
        if (period === 'month') {
          if (monthSelect && monthSelect.value) params.set('month', monthSelect.value);
          if (yearSelect && yearSelect.value) params.set('year', yearSelect.value);
        }
        if (period === 'year') {
          if (yearSelect && yearSelect.value) params.set('year', yearSelect.value);
        }
        return params.toString();
      };

      const loadStats = async (period) => {
        currentPeriod = period;
        setActivePeriod(period);
        setFiltersVisibility(period);
        const res = await fetch(statsUrl + '?' + buildQuery(period), {
          headers: { 'Accept': 'application/json' },
          credentials: 'same-origin',
        });
        if (!res.ok) throw new Error('Failed to load stats');
        return await res.json();
      };

      const applyStats = (payload) => {
        const labels = Array.isArray(payload.labels) ? payload.labels : [];
        const revenue = Array.isArray(payload.revenue) ? payload.revenue : [];
        const users = Array.isArray(payload.users) ? payload.users : [];

        const period = payload.period || currentPeriod;
        const xaxisForPeriod = (() => {
          if (period === 'month') {
            return {
              categories: labels,
              tickAmount: 10,
              labels: { rotate: -45, hideOverlappingLabels: true, trim: true },
            };
          }
          if (period === 'year') {
            return {
              categories: labels,
              tickAmount: 12,
              labels: { rotate: 0, hideOverlappingLabels: true, trim: true },
            };
          }
          return {
            categories: labels,
            tickAmount: 7,
            labels: { rotate: 0, hideOverlappingLabels: true, trim: true },
          };
        })();

        revenueChart.updateOptions({ xaxis: xaxisForPeriod });
        revenueChart.updateSeries([{ name: 'Doanh thu', data: revenue }]);

        usersChart.updateOptions({ xaxis: xaxisForPeriod });
        usersChart.updateSeries([{ name: 'Người dùng mới', data: users }]);
      };

      periodButtons.forEach((btn) => {
        btn.addEventListener('click', async function () {
          const period = this.getAttribute('data-dashboard-period');
          try {
            const payload = await loadStats(period);
            applyStats(payload);
          } catch (e) {
            if (window.toastr) toastr.error('Không tải được dữ liệu thống kê');
          }
        });
      });

      const reloadCurrent = async () => {
        try {
          const payload = await loadStats(currentPeriod);
          applyStats(payload);
        } catch (e) {
          if (window.toastr) toastr.error('Không tải được dữ liệu thống kê');
        }
      };

      ensureFilterOptions();
      setFiltersVisibility('month');

      if (monthSelect) monthSelect.addEventListener('change', reloadCurrent);
      if (yearSelect) yearSelect.addEventListener('change', reloadCurrent);

      loadStats('month').then(applyStats).catch(() => {
        if (window.toastr) toastr.error('Không tải được dữ liệu thống kê');
      });
    })();
  </script>
@endpush