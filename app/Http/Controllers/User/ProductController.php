<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('images', 'variants', 'category')->where('status', 1);

        if ($request->filled('q')) {
            $q = $request->get('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->get('category_id'));
        }

        if ($request->filled('price_min') || $request->filled('price_max')) {
            $min = $request->get('price_min');
            $max = $request->get('price_max');
            $query->whereHas('variants', function ($vquery) use ($min, $max) {
                if ($min !== null && $min !== '') {
                    $vquery->where('price', '>=', (float) $min);
                }
                if ($max !== null && $max !== '') {
                    $vquery->where('price', '<=', (float) $max);
                }
            });
        }

        // Filter by sizes (array of sizes)
        if ($request->filled('sizes')) {
            $sizes = (array) $request->get('sizes');
            $query->whereHas('variants', function ($vq) use ($sizes) {
                $vq->whereIn('size', $sizes);
            });
        }

        // Filter by materials (array)
        if ($request->filled('materials')) {
            $materials = (array) $request->get('materials');
            $query->whereIn('material', $materials);
        }

        $products = $query->orderBy('id', 'desc')->paginate(12);
        $categories = Category::orderBy('name')->get();

        // available filter options
        $sizes = \App\Models\ProductVariant::select('size')->distinct()->pluck('size')->filter()->values();
        $materials = Product::select('material')->whereNotNull('material')->distinct()->pluck('material')->filter()->values();

        return view('user.products', compact('products', 'categories', 'sizes', 'materials'));
    }

    /**
     * Show product detail page by slug
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $slug
     */
    public function show(Request $request, $slug)
    {
        $product = Product::with(['images', 'variants', 'reviews.user', 'category'])
            ->where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        // main image (fallback to first)
        $mainImage = $product->images->firstWhere('is_main', 1) ?? $product->images->first();
        $thumbnails = $product->images;

        // price range from variants
        $minPrice = $product->variants->min('price');
        $maxPrice = $product->variants->max('price');

        // reviews summary
        $avgRating = $product->reviews()->avg('rating') ?? 0;
        $reviewCount = $product->reviews()->count();

        // total stock
        $stock = $product->variants->sum('stock');

        // related products (same category)
        $related = Product::where('category_id', $product->category_id)
            ->where('id', '<>', $product->id)
            ->where('status', 1)
            ->with('images', 'variants')
            ->inRandomOrder()
            ->limit(4)
            ->get();

        // prepare variants data for frontend (avoid closure in Blade)
        $variantsData = $product->variants->map(function ($v) {
            return [
                'id' => $v->id,
                'size' => $v->size,
                'price' => (float) $v->price,
                'stock' => (int) $v->stock,
            ];
        })->toArray();

        return view('user.productDetail', compact(
            'product',
            'mainImage',
            'thumbnails',
            'minPrice',
            'maxPrice',
            'avgRating',
            'reviewCount',
            'stock',
            'related',
            'variantsData'
        ));
    }
}
