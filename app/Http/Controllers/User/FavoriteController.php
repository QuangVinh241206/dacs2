<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Favorite::with(['product.category', 'product.images', 'product.variants'])
            ->where('user_id', $user->id);

        // Tìm kiếm theo tên sản phẩm
        if ($request->filled('q')) {
            $q = $request->get('q');
            $query->whereHas('product', function ($productQuery) use ($q) {
                $productQuery->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        // Lọc theo danh mục
        if ($request->filled('category_id')) {
            $query->whereHas('product.category', function ($categoryQuery) use ($request) {
                $categoryQuery->where('id', $request->category_id);
            });
        }

        // Sắp xếp
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
                $query->join('products', 'favorites.product_id', '=', 'products.id')
                    ->orderBy('products.name', 'asc');
                break;
            case 'name_desc':
                $query->join('products', 'favorites.product_id', '=', 'products.id')
                    ->orderBy('products.name', 'desc');
                break;
            case 'price_low':
                $query->join('products', 'favorites.product_id', '=', 'products.id')
                    ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
                    ->orderByRaw('COALESCE(MIN(product_variants.price), 0) ASC')
                    ->groupBy('favorites.id');
                break;
            case 'price_high':
                $query->join('products', 'favorites.product_id', '=', 'products.id')
                    ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
                    ->orderByRaw('COALESCE(MAX(product_variants.price), 0) DESC')
                    ->groupBy('favorites.id');
                break;
            default: // newest
                $query->orderBy('created_at', 'desc');
                break;
        }

        $favorites = $query->paginate(12)->withQueryString();

        // Lấy danh mục cho bộ lọc
        $categories = \App\Models\Category::orderBy('name')->get();

        return view('user.favoriteProducts', compact('favorites', 'categories', 'sort'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $productId = $request->input('product_id');

        $existing = Favorite::where('user_id', $user->id)->where('product_id', $productId)->first();
        if ($existing) {
            $existing->delete();
            $status = 'removed';
        } else {
            Favorite::create(['user_id' => $user->id, 'product_id' => $productId]);
            $status = 'added';
        }

        $count = Favorite::where('product_id', $productId)->count();

        return response()->json(['status' => $status, 'count' => $count]);
    }
}
