<?php

use App\Livewire\Client\Card;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Categories;
use App\Livewire\Client\Catalog;
use App\Livewire\Client\Companies;
use App\Livewire\Client\ProductDetails;
use App\Livewire\Client\CompanyDetails;

Route::get('/', fn () => redirect()->route('client.catalog'));

Route::prefix('admin')->name('admin.')->middleware(['web'])->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('/categories', Categories::class)->name('categories');
});

Route::prefix('client')->name('client.')->middleware(['web'])->group(function () {
    Route::get('/catalog', Catalog::class)->name('catalog');
    Route::get('/companies', Companies::class)->name('companies');
    Route::get('/companies/{company}', CompanyDetails::class)->name('company.details');
    Route::get('/products/{product}', ProductDetails::class)->name('product.details');
    Route::get('/card', Card::class)->name('card');
});
