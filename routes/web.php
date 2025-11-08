<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('brands', BrandController::class);

Route::get('/', [HomeController::class, 'index'])->name('home');
