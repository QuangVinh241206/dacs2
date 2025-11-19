<?php

use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('user.home');
})->name('home');

Route::prefix('auth')->group(function () {
    Route::get('login', function () {
        return view('auth.login');
    })->name('auth.login');
    Route::get('register', function () {
        return view('auth.register');
    })->name('auth.register');
});


Route::prefix('user')->group(function () {
    route::get('about', function () {
        return view('user.about');
    })->name('user.about');
    route::get('contact', function () {
        return view('user.contact');
    })->name('user.contact');
    route::get('product_detail', function () {
        return view('user.productDetail');
    })->name('user.productDetail');
});