<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;


Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get(
            '/dashboard',
            [DashboardController::class, 'index']
        )->name('dashboard');

        // Categories routes
        Route::resource('categories', CategoryController::class);

        Route::get('categories-trash', [CategoryController::class, 'trash'])
            ->name('categories.trash');
        Route::patch('categories/{id}/restore', [CategoryController::class, 'restore'])
            ->name('categories.restore');
        Route::delete('categories/{id}/force-delete', [CategoryController::class, 'forceDelete'])
            ->name('categories.forceDelete');

        // Brands routes
        Route::resource('brands', BrandController::class);

        Route::get('brands-trash', [BrandController::class, 'trash'])
            ->name('brands.trash');
        Route::patch('brands/{id}/restore', [BrandController::class, 'restore'])
            ->name('brands.restore');
        Route::delete('brands/{id}/force-delete', [BrandController::class, 'forceDelete'])
            ->name('brands.forceDelete');

        // Products
        Route::delete(
            'products/gallery/{image}',
            [ProductController::class, 'destroyGallery']
        )->name('products.gallery.destroy');
        
        Route::resource('products', ProductController::class);
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
