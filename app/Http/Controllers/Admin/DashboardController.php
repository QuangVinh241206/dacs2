<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $productCount = Product::where('status', 1)->count();
        $categoryCount = Category::count();
        $orderCount = Order::count();
        $userCount = User::where('role', 'user')->count();

        return view('admin.dashboard', compact('productCount', 'categoryCount', 'orderCount', 'userCount'));
    }

    public function stats(Request $request)
    {
        $period = $request->query('period', 'month');
        if (!in_array($period, ['week', 'month', 'year'], true)) {
            $period = 'month';
        }

        $requestedYear = (int) $request->query('year', 0);
        $requestedMonth = (int) $request->query('month', 0);

        $paidStatuses = ['paid', 'completed'];

        $now = Carbon::now();

        if ($period === 'week') {
            $start = $now->copy()->subDays(6)->startOfDay();
            $end = $now->copy()->endOfDay();

            $orderByDate = Order::query()
                ->selectRaw('DATE(order_date) as d, SUM(total_price) as total')
                ->whereBetween('order_date', [$start, $end])
                ->whereIn('order_status', $paidStatuses)
                ->groupBy('d')
                ->pluck('total', 'd');

            $usersByDate = User::query()
                ->selectRaw('DATE(created_at) as d, COUNT(*) as total')
                ->where('role', 'user')
                ->whereBetween('created_at', [$start, $end])
                ->groupBy('d')
                ->pluck('total', 'd');

            $labels = [];
            $revenue = [];
            $users = [];

            for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
                $key = $d->toDateString();
                $labels[] = $d->format('d/m');
                $revenue[] = (int) ($orderByDate[$key] ?? 0);
                $users[] = (int) ($usersByDate[$key] ?? 0);
            }

            return response()->json([
                'period' => $period,
                'labels' => $labels,
                'revenue' => $revenue,
                'users' => $users,
            ]);
        }

        if ($period === 'year') {
            $year = ($requestedYear >= 2000 && $requestedYear <= 2100) ? $requestedYear : (int) $now->year;
            $start = Carbon::create($year, 1, 1)->startOfYear();
            $end = Carbon::create($year, 12, 31)->endOfYear();

            $orderByMonth = Order::query()
                ->selectRaw('MONTH(order_date) as m, SUM(total_price) as total')
                ->whereBetween('order_date', [$start, $end])
                ->whereIn('order_status', $paidStatuses)
                ->groupBy('m')
                ->pluck('total', 'm');

            $usersByMonth = User::query()
                ->selectRaw('MONTH(created_at) as m, COUNT(*) as total')
                ->where('role', 'user')
                ->whereBetween('created_at', [$start, $end])
                ->groupBy('m')
                ->pluck('total', 'm');

            $labels = [];
            $revenue = [];
            $users = [];

            for ($m = 1; $m <= 12; $m++) {
                $labels[] = 'T' . $m;
                $revenue[] = (int) ($orderByMonth[$m] ?? 0);
                $users[] = (int) ($usersByMonth[$m] ?? 0);
            }

            return response()->json([
                'period' => $period,
                'year' => $year,
                'labels' => $labels,
                'revenue' => $revenue,
                'users' => $users,
            ]);
        }

        // month (default)
        $year = ($requestedYear >= 2000 && $requestedYear <= 2100) ? $requestedYear : (int) $now->year;
        $month = ($requestedMonth >= 1 && $requestedMonth <= 12) ? $requestedMonth : (int) $now->month;

        $start = Carbon::create($year, $month, 1)->startOfMonth()->startOfDay();
        $end = Carbon::create($year, $month, 1)->endOfMonth()->endOfDay();

        $orderByDate = Order::query()
            ->selectRaw('DATE(order_date) as d, SUM(total_price) as total')
            ->whereBetween('order_date', [$start, $end])
            ->whereIn('order_status', $paidStatuses)
            ->groupBy('d')
            ->pluck('total', 'd');

        $usersByDate = User::query()
            ->selectRaw('DATE(created_at) as d, COUNT(*) as total')
            ->where('role', 'user')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('d')
            ->pluck('total', 'd');

        $labels = [];
        $revenue = [];
        $users = [];

        for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
            $key = $d->toDateString();
            $labels[] = (string) $d->day;
            $revenue[] = (int) ($orderByDate[$key] ?? 0);
            $users[] = (int) ($usersByDate[$key] ?? 0);
        }

        return response()->json([
            'period' => $period,
            'year' => $year,
            'month' => $month,
            'labels' => $labels,
            'revenue' => $revenue,
            'users' => $users,
        ]);
    }
}
