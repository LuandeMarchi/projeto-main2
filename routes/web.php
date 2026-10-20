<?php

use App\Livewire\Products\Create as CreateProduct;
use App\Livewire\Products\Edit as EditProduct;
use App\Livewire\Products\Index as ProductIndex;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', [
        'featuredProducts' => Product::query()
            ->where('is_active', true)
            ->latest()
            ->take(6)
            ->get(),
        'activeProductsCount' => Product::query()->where('is_active', true)->count(),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::livewire('products', ProductIndex::class)->name('products.index');
    Route::livewire('products/create', CreateProduct::class)->name('products.create');
    Route::livewire('products/{product}/edit', EditProduct::class)->name('products.edit');
});

require __DIR__.'/settings.php';
