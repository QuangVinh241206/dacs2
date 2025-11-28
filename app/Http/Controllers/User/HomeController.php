<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $discounts = Product::with('images', 'variants')
            ->where('status', 1)
            ->where('discount_percent', '>', 0)
            ->orderBy('updated_at', 'desc')
            ->limit(15)
            ->get();

        $newArrivals = Product::with('images', 'variants')
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->limit(15)
            ->get();

        // top 4 categories by product count
        $topCategories = Category::withCount('products')->orderBy('products_count', 'desc')->limit(4)->get();

        return view('user.home', compact('discounts', 'newArrivals', 'topCategories'));
    }

    public function discounts(Request $request)
    {
        $page = max(1, (int) $request->get('page', 1));
        $perPage = 5;

        $query = Product::with('images', 'variants')
            ->where('status', 1)
            ->where('discount_percent', '>', 0)
            ->orderBy('updated_at', 'desc');

        $products = $query->skip(($page - 1) * $perPage)->take($perPage)->get();
        $html = view('user.partials.products_row', ['products' => $products])->render();
        $total = (clone $query)->count();
        $hasMore = $total > $page * $perPage;

        return response()->json(['html' => $html, 'page' => $page, 'hasMore' => $hasMore]);
    }

    public function newArrivals(Request $request)
    {
        $page = max(1, (int) $request->get('page', 1));
        $perPage = 5;

        $query = Product::with('images', 'variants')
            ->where('status', 1)
            ->orderBy('created_at', 'desc');

        $products = $query->skip(($page - 1) * $perPage)->take($perPage)->get();
        $html = view('user.partials.products_row', ['products' => $products])->render();
        $total = (clone $query)->count();
        $hasMore = $total > $page * $perPage;

        return response()->json(['html' => $html, 'page' => $page, 'hasMore' => $hasMore]);
    }
}
