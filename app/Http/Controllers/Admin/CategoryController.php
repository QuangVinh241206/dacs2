<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->paginate(20);
        return view('admin.categories.listCategory', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.createCategory');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ];
        $messages = [
            'required' => ':attribute không được để trống.',
            'max' => ':attribute không được vượt quá :max ký tự.',
            'string' => ':attribute phải là chuỗi ký tự.',
        ];
        $attributes = [
            'name' => 'Tên danh mục',
            'slug' => 'Slug',
            'description' => 'Mô tả',
        ];

        $request->validate($rules, $messages, $attributes);

        $data = $request->only(['name', 'slug', 'description']);
        if (empty($data['slug'])) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
        } else {
            $data['slug'] = \Illuminate\Support\Str::slug($data['slug']);
        }

        Category::create($data);
        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được tạo.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.editCategory', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ];
        $messages = [
            'required' => ':attribute không được để trống.',
            'max' => ':attribute không được vượt quá :max ký tự.',
            'string' => ':attribute phải là chuỗi ký tự.',
        ];
        $attributes = [
            'name' => 'Tên danh mục',
            'slug' => 'Slug',
            'description' => 'Mô tả',
        ];

        $request->validate($rules, $messages, $attributes);

        $category = Category::findOrFail($id);
        $data = $request->only(['name', 'slug', 'description']);
        $data['slug'] = empty($data['slug']) ? \Illuminate\Support\Str::slug($data['name']) : \Illuminate\Support\Str::slug($data['slug']);
        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được cập nhật.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã bị xóa.');
    }
}
