<?php

use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication routes
Route::prefix('auth')->group(function () {
    Route::get('login', function () {
        return view('auth.login');
    })->name('auth.login');
    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('auth.login.post');
    Route::get('register', function () {
        return view('auth.register');
    })->name('auth.register');
    Route::post('register', [\App\Http\Controllers\AuthController::class, 'register'])->name('auth.register.post');
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');
});


Route::prefix('user')->group(function () {
    route::get('about', function () {
        return view('user.about');
    })->name('user.about');
    route::get('contact', function () {
        return view('user.contact');
    })->name('user.contact');
    // Product detail by slug
    Route::get('products/{slug}', [\App\Http\Controllers\User\ProductController::class, 'show'])->name('user.productDetail');
    Route::get('products', [\App\Http\Controllers\User\ProductController::class, 'index'])->name('user.products');
    Route::post('favorites/toggle', [\App\Http\Controllers\User\FavoriteController::class, 'toggle'])->name('user.favorites.toggle');
    Route::post('products/reviews', [\App\Http\Controllers\User\ReviewController::class, 'store'])->name('user.reviews.store');
    Route::get('products/discounts', [\App\Http\Controllers\User\HomeController::class, 'discounts'])->name('user.products.discounts');
    Route::get('products/new-arrivals', [\App\Http\Controllers\User\HomeController::class, 'newArrivals'])->name('user.products.new');
    Route::post('products/reviews', [\App\Http\Controllers\User\ReviewController::class, 'store'])->name('user.reviews.store');
});

// Admin product management
Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::get('products', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('admin.products.index');
    Route::get('products/create', [\App\Http\Controllers\Admin\ProductController::class, 'create'])->name('admin.products.create');
    Route::post('products', [\App\Http\Controllers\Admin\ProductController::class, 'store'])->name('admin.products.store');

    // Trashed products 
    Route::get('products/trashed', [\App\Http\Controllers\Admin\ProductController::class, 'trashed'])->name('admin.products.trashed');
    Route::post('products/{product}/restore', [\App\Http\Controllers\Admin\ProductController::class, 'restore'])->name('admin.products.restore');

    // Variants
    Route::post('products/{product}/variants', [\App\Http\Controllers\Admin\ProductController::class, 'storeVariant'])->name('admin.products.variants.store');
    Route::put('products/{product}/variants/{variant}', [\App\Http\Controllers\Admin\ProductController::class, 'updateVariant'])->name('admin.products.variants.update');
    Route::delete('products/{product}/variants/{variant}', [\App\Http\Controllers\Admin\ProductController::class, 'deleteVariant'])->name('admin.products.variants.destroy');

    // Images
    Route::post('products/{product}/images', [\App\Http\Controllers\Admin\ProductController::class, 'uploadImage'])->name('admin.products.images.upload');
    Route::post('products/{product}/images/{image}/set-main', [\App\Http\Controllers\Admin\ProductController::class, 'setMainImage'])->name('admin.products.images.setMain');
    Route::delete('products/{product}/images/{image}', [\App\Http\Controllers\Admin\ProductController::class, 'deleteImage'])->name('admin.products.images.destroy');

    // Categories CRUD
    Route::get('categories', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('categories/create', [\App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('categories', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('categories/{category}/edit', [\App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('admin.categories.destroy');

    // Vouchers CRUD
    Route::get('vouchers', [\App\Http\Controllers\Admin\VoucherController::class, 'index'])->name('admin.vouchers.index');
    Route::get('vouchers/create', [\App\Http\Controllers\Admin\VoucherController::class, 'create'])->name('admin.vouchers.create');
    Route::post('vouchers', [\App\Http\Controllers\Admin\VoucherController::class, 'store'])->name('admin.vouchers.store');
    Route::get('vouchers/{voucher}/edit', [\App\Http\Controllers\Admin\VoucherController::class, 'edit'])->name('admin.vouchers.edit');
    Route::put('vouchers/{voucher}', [\App\Http\Controllers\Admin\VoucherController::class, 'update'])->name('admin.vouchers.update');
    Route::delete('vouchers/{voucher}', [\App\Http\Controllers\Admin\VoucherController::class, 'destroy'])->name('admin.vouchers.destroy');


    Route::get('products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'show'])->name('admin.products.show');
    Route::get('products/{product}/edit', [\App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('admin.products.destroy');
});