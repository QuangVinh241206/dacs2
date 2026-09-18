<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category', 'variants')->where('status', 1);

        // Search by name or description
        if ($request->filled('q')) {
            $q = $request->get('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->get('category_id'));
        }

        // Filter by price range (applies to variants)
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

        $products = $query->orderBy('id', 'desc')->paginate(10);

        $categories = Category::orderBy('name')->get();

        return view('admin.products.listProduct', compact('products', 'categories'));
    }

    // Show deleted/inactive products
    public function trashed()
    {
        $products = Product::with('category', 'variants')->where('status', 0)->orderBy('id', 'desc')->paginate(20);
        return view('admin.products.trashed', compact('products'));
    }

    public function restore($id)
    {
        $product = Product::findOrFail($id);
        $product->status = 1;
        $product->save();
        return redirect()->route('admin.products.trashed')->with('success', 'Khôi phục thành công.');
    }

    public function show($id)
    {
        $product = Product::with('variants', 'images', 'category')->findOrFail($id);
        return view('admin.products.showProduct', compact('product'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.createProduct', compact('categories'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'weight_capacity' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',
            'warranty' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'nullable|string',
        ];
        $messages = [
            'required' => ':attribute không được để trống.',
            'max' => ':attribute không được vượt quá :max ký tự.',
            'min' => ':attribute phải lớn hơn hoặc bằng :min.',
            'string' => ':attribute phải là chuỗi ký tự.',
            'exists' => ':attribute không hợp lệ.',
        ];
        $attributes = [
            'name' => 'Tên sản phẩm',
            'slug' => 'Slug',
            'discount_percent' => 'Phần trăm giảm giá',
            'weight_capacity' => 'Chịu tải',
            'material' => 'Chất liệu',
            'warranty' => 'Bảo hành',
            'description' => 'Mô tả',
            'category_id' => 'Danh mục',
            'status' => 'Trạng thái',
        ];

        $request->validate($rules, $messages, $attributes);

        $data = $request->only(['name', 'slug', 'description', 'category_id', 'status', 'discount_percent', 'weight_capacity', 'material', 'warranty']);
        // generate slug if empty and ensure uniqueness
        if (empty($data['slug'])) {
            $base = Str::slug($data['name'] ?? '');
            $slug = $base ?: time();
            $i = 1;
            while (Product::where('slug', $slug)->exists()) {
                $slug = $base . '-' . $i++;
            }
            $data['slug'] = $slug;
        } else {
            // normalize provided slug
            $data['slug'] = Str::slug($data['slug']);
        }
        if (Product::where('slug', $data['slug'])->exists()) {
            $base = $data['slug'];
            $slug = $base;
            $i = 1;
            while (Product::where('slug', $slug)->exists()) {
                $slug = $base . '-' . $i++;
            }
            $data['slug'] = $slug;
        }
        
        $product = Product::create($data);

        return redirect()->route('admin.products.show', $product->id)->with('success', 'Thêm sản phẩm thành công.');
    }

    public function storeVariant(Request $request, $productId)
    {
        $rules = [
            'size' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:255',
        ];
        $messages = [
            'required' => ':attribute không được để trống.',
            'numeric' => ':attribute phải là số.',
            'integer' => ':attribute phải là số nguyên.',
            'min' => ':attribute phải lớn hơn hoặc bằng :min.',
            'max' => ':attribute không được vượt quá :max ký tự.',
        ];
        $attributes = [
            'size' => 'Kích thước',
            'color' => 'Màu sắc',
            'price' => 'Giá',
            'stock' => 'Số lượng',
            'sku' => 'SKU',
        ];

        $request->validate($rules, $messages, $attributes);

        $product = Product::findOrFail($productId);
        $product->variants()->create($request->only(['size', 'color', 'price', 'stock', 'sku']));

        return redirect()->route('admin.products.show', $product->id)->with('success', 'Thêm biến thể thành công.');
    }

    public function updateVariant(Request $request, $productId, $variantId)
    {
        $rules = [
            'size' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:255',
        ];
        $messages = [
            'required' => ':attribute không được để trống.',
            'numeric' => ':attribute phải là số.',
            'integer' => ':attribute phải là số nguyên.',
            'min' => ':attribute phải lớn hơn hoặc bằng :min.',
            'max' => ':attribute không được vượt quá :max ký tự.',
        ];
        $attributes = [
            'size' => 'Kích thước',
            'color' => 'Màu sắc',
            'price' => 'Giá',
            'stock' => 'Số lượng',
            'sku' => 'SKU',
        ];

        $request->validate($rules, $messages, $attributes);

        $variant = ProductVariant::where('product_id', $productId)->findOrFail($variantId);
        $variant->update($request->only(['size', 'color', 'price', 'stock', 'sku']));

        return redirect()->route('admin.products.show', $productId)->with('success', 'Cập nhật biến thể thành công.');
    }

    public function deleteVariant($productId, $variantId)
    {
        $variant = ProductVariant::where('product_id', $productId)->findOrFail($variantId);
        $variant->delete();
        return redirect()->route('admin.products.show', $productId)->with('success', 'Đã xóa thành công.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        // Instead of deleting, mark the product as inactive (status = 0)
        $product->status = 0;
        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Đã xóa sản phẩm.');
    }

    public function edit($id)
    {
        $product = Product::with('variants')->findOrFail($id);
        return view('admin.products.editProduct', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'weight_capacity' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',
            'warranty' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'nullable|string',
        ];
        $messages = [
            'required' => ':attribute không được để trống.',
            'min' => ':attribute phải lớn hơn hoặc bằng :min.',
            'max' => ':attribute không được vượt quá :max ký tự.',
            'string' => ':attribute phải là chuỗi ký tự.',
            'exists' => ':attribute không hợp lệ.',
        ];
        $attributes = [
            'name' => 'Tên sản phẩm',
            'slug' => 'Slug',
            'discount_percent' => 'Phần trăm giảm giá',
            'weight_capacity' => 'Chịu tải',
            'material' => 'Chất liệu',
            'warranty' => 'Bảo hành',
            'description' => 'Mô tả',
            'category_id' => 'Danh mục',
            'status' => 'Trạng thái',
        ];

        $request->validate($rules, $messages, $attributes);

        $data = $request->only(['name', 'description', 'status', 'category_id', 'slug', 'discount_percent', 'weight_capacity', 'material', 'warranty']);
        // ensure slug present and unique (exclude current product)
        if (empty($data['slug'])) {
            $base = Str::slug($data['name'] ?? '');
            $slug = $base ?: time();
            $i = 1;
            while (Product::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $base . '-' . $i++;
            }
            $data['slug'] = $slug;
        } else {
            $data['slug'] = Str::slug($data['slug']);
            // if slug collides with another product, append suffix
            $base = $data['slug'];
            $slug = $base;
            $i = 1;
            while (Product::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $base . '-' . $i++;
            }
            $data['slug'] = $slug;
        }

        $product = Product::findOrFail($id);
        $product->update($data);
        return redirect()->route('admin.products.show', $product->id)->with('success', 'Cập nhật sản phẩm thành công.');
    }

    // Image upload for a product
    public function uploadImage(Request $request, $productId)
    {
        $request->validate([
            'image' => 'required|image|max:4096'
        ], [
            'image.required' => 'Vui lòng chọn ảnh để tải lên.',
            'image.image' => 'Tệp phải là ảnh.',
            'image.max' => 'Kích thước ảnh không được lớn hơn 4MB.'
        ]);

        $product = Product::findOrFail($productId);
        $file = $request->file('image');
        $path = $file->store('products/' . $productId, 'public');

        // If no images yet, mark this as main
        $isMain = $product->images()->count() == 0 ? 1 : 0;

        $product->images()->create([
            'image_url' => $path,
            'is_main' => $isMain
        ]);

        return redirect()->route('admin.products.show', $productId)->with('success', 'Ảnh đã được tải lên.');
    }

    // Set an image as the main image
    public function setMainImage($productId, $imageId)
    {
        $product = Product::findOrFail($productId);
        $image = $product->images()->findOrFail($imageId);

        // unset others
        $product->images()->update(['is_main' => 0]);

        $image->is_main = 1;
        $image->save();

        return redirect()->route('admin.products.show', $productId)->with('success', 'Đã đặt ảnh chính.');
    }

    // Delete an image
    public function deleteImage($productId, $imageId)
    {
        $product = Product::findOrFail($productId);
        $image = $product->images()->findOrFail($imageId);

        // delete file from storage
        if ($image->image_url) {
            Storage::disk('public')->delete($image->image_url);
        }

        $wasMain = $image->is_main;
        $image->delete();

        // if it was main, set another image as main
        if ($wasMain) {
            $next = $product->images()->first();
            if ($next) {
                $next->is_main = 1;
                $next->save();
            }
        }

        return redirect()->route('admin.products.show', $productId)->with('success', 'Đã xóa ảnh.');
    }
}
