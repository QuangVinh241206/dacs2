<?php

use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Chat AI query endpoint
Route::post('/chat/query', [\App\Http\Controllers\ChatController::class, 'query'])->name('chat.query');


// Authentication routes

Route::get('login', function () {
    return view('auth.login');
})->name('login');
Route::get('forgot', [\App\Http\Controllers\AuthController::class, 'showForgotForm'])->name('forgot');
Route::post('forgot', [\App\Http\Controllers\AuthController::class, 'sendResetLink'])->name('forgot.post');
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login.post');
Route::get('register', function () {
    return view('auth.register');
})->name('register');
Route::post('register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register.post');
Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::get('reset/{token}', [\App\Http\Controllers\AuthController::class, 'showResetForm'])->name('reset');
// Alias route name used by Laravel Password broker when generating reset links
Route::get('password/reset/{token}', [\App\Http\Controllers\AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('reset', [\App\Http\Controllers\AuthController::class, 'resetPassword'])->name('reset.post');


Route::prefix('user')->group(function () {
    route::get('about', function () {
        return view('user.about');
    })->name('user.about');
    route::get('contact', function () {
        return view('user.contact');
    })->name('user.contact');
    // Account management
    Route::get('account', [\App\Http\Controllers\User\AccountController::class, 'index'])->name('user.account.index');
    Route::put('account', [\App\Http\Controllers\User\AccountController::class, 'update'])->name('user.account.update');
    Route::post('account/change-password', [\App\Http\Controllers\User\AccountController::class, 'changePassword'])->name('user.account.changePassword');
    // Product detail by slug - must be BEFORE generic products route
    Route::get('products/{slug}', [\App\Http\Controllers\User\ProductController::class, 'show'])->name('user.productDetail');
    // Generic products list
    Route::get('products', [\App\Http\Controllers\User\ProductController::class, 'index'])->name('user.products');
    Route::post('favorites/toggle', [\App\Http\Controllers\User\FavoriteController::class, 'toggle'])->middleware('auth')->name('user.favorites.toggle');
    Route::get('favorites', [\App\Http\Controllers\User\FavoriteController::class, 'index'])->middleware('auth')->name('user.favorites.index');
    Route::post('products/reviews', [\App\Http\Controllers\User\ReviewController::class, 'store'])->middleware('auth')->name('user.reviews.store');
    Route::post('cart/add', [\App\Http\Controllers\User\CartController::class, 'add'])->middleware('auth')->name('user.cart.add');
    Route::get('cart', [\App\Http\Controllers\User\CartController::class, 'index'])->middleware('auth')->name('user.cart.index');
    Route::post('cart/update', [\App\Http\Controllers\User\CartController::class, 'update'])->middleware('auth')->name('user.cart.update');
    Route::post('cart/update', [\App\Http\Controllers\User\CartController::class, 'update'])->middleware('auth')->name('user.cart.update');
    Route::delete('cart/{detail}', [\App\Http\Controllers\User\CartController::class, 'destroy'])->middleware('auth')->name('user.cart.destroy');
    Route::get('checkout', [\App\Http\Controllers\User\CheckoutController::class, 'show'])->middleware('auth')->name('user.checkout.show');
    Route::post('checkout', [\App\Http\Controllers\User\CheckoutController::class, 'store'])->middleware('auth')->name('user.checkout.store');
    Route::post('checkout/voucher/validate', [\App\Http\Controllers\User\CheckoutController::class, 'validateVoucher'])->middleware('auth')->name('user.checkout.voucher.validate');
    Route::get('checkout/success/{order}', [\App\Http\Controllers\User\CheckoutController::class, 'success'])->middleware('auth')->name('user.checkout.success');
    Route::get('checkout/status/{order}', [\App\Http\Controllers\User\CheckoutController::class, 'status'])->middleware('auth')->name('user.checkout.status');
    Route::get('checkout/payos/return/{order}', [\App\Http\Controllers\User\CheckoutController::class, 'payosReturn'])->middleware('auth')->name('user.payos.return');
    Route::get('checkout/payos/cancel/{order}', [\App\Http\Controllers\User\CheckoutController::class, 'payosCancel'])->middleware('auth')->name('user.payos.cancel');
    Route::post('checkout/payos/webhook', [\App\Http\Controllers\User\CheckoutController::class, 'payosWebhook'])->name('user.payos.webhook');
    Route::get('orders', [\App\Http\Controllers\User\OrderController::class, 'index'])->middleware('auth')->name('user.orders.index');
    Route::post('orders/{order}/cancel', [\App\Http\Controllers\User\OrderController::class, 'cancel'])->middleware('auth')->name('user.orders.cancel');
    Route::get('orders/{order}/review', [\App\Http\Controllers\User\OrderController::class, 'review'])->middleware('auth')->name('user.orders.review');
    Route::get('orders/{order}', [\App\Http\Controllers\User\OrderController::class, 'show'])->middleware('auth')->name('user.orders.show');

    Route::get('products/discounts', [\App\Http\Controllers\User\HomeController::class, 'discounts'])->name('user.products.discounts');
    Route::get('products/new-arrivals', [\App\Http\Controllers\User\HomeController::class, 'newArrivals'])->name('user.products.new');
    Route::post('products/reviews', [\App\Http\Controllers\User\ReviewController::class, 'store'])->middleware('auth')->name('user.reviews.store');
});

// Admin product management
Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('/', function () {
        $productCount = \App\Models\Product::where('status', 1)->count();
        $categoryCount = \App\Models\Category::count();
        $orderCount = \App\Models\Order::count();
        $userCount = \App\Models\User::where('role', 'user')->count();

        return view('admin.dashboard', compact('productCount', 'categoryCount', 'orderCount', 'userCount'));
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

    // Admin user management
    Route::get('users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
    Route::get('users/trashed', [\App\Http\Controllers\Admin\UserController::class, 'trashed'])->name('admin.users.trashed');
    Route::get('users/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
    Route::delete('users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::post('users/{user}/restore', [\App\Http\Controllers\Admin\UserController::class, 'restore'])->name('admin.users.restore');
    Route::delete('users/{user}/force-delete', [\App\Http\Controllers\Admin\UserController::class, 'forceDelete'])->name('admin.users.forceDelete');

    // Admin profile
    Route::get('profile', [\App\Http\Controllers\Admin\UserController::class, 'profile'])->name('admin.profile');
    Route::put('profile', [\App\Http\Controllers\Admin\UserController::class, 'updateProfile'])->name('admin.profile.update');

    // Admin order management
    Route::get('orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('admin.orders.show');
    Route::patch('orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::delete('orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'destroy'])->name('admin.orders.destroy');

    // Trashed orders management
    Route::get('orders-trashed', [\App\Http\Controllers\Admin\OrderController::class, 'trashed'])->name('admin.orders.trashed');
    Route::post('orders/{id}/restore', [\App\Http\Controllers\Admin\OrderController::class, 'restore'])->name('admin.orders.restore');
    Route::delete('orders/{id}/force-delete', [\App\Http\Controllers\Admin\OrderController::class, 'forceDelete'])->name('admin.orders.forceDelete');
});