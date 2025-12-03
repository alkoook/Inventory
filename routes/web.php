<?php

use App\Livewire\Client\Card;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Categories;
use App\Livewire\Admin\Products;
use App\Livewire\Admin\Companies as AdminCompanies;
use App\Livewire\Client\Catalog;
use App\Livewire\Client\Companies;
use App\Livewire\Client\ProductDetails;
use App\Livewire\Client\CompanyDetails;

use Illuminate\Support\Facades\Auth;

Route::get('/', fn () => redirect()->route('client.catalog'));

Auth::routes(['register' => false]);

// Admin Routes - Protected by auth and admin check
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('/categories', Categories::class)->name('categories');
    Route::get('/products', Products::class)->name('products');
    Route::get('/companies', AdminCompanies::class)->name('companies');
    Route::get('/customers', \App\Livewire\Admin\Customers::class)->name('customers');
    Route::get('/orders', \App\Livewire\Admin\Orders::class)->name('orders');
    Route::get('/sales-invoices', \App\Livewire\Admin\SalesInvoices::class)->name('sales-invoices');
    Route::get('/purchase-invoices', \App\Livewire\Admin\PurchaseInvoices::class)->name('purchase-invoices');
    Route::get('/settings', \App\Livewire\Admin\Settings::class)->name('settings');
});

// Client Routes - Accessible to all (or auth users if required)
Route::prefix('client')->name('client.')->group(function () {
    Route::get('/catalog', Catalog::class)->name('catalog');
    Route::get('/companies', Companies::class)->name('companies');
    Route::get('/companies/{company}', CompanyDetails::class)->name('company.details');
    Route::get('/products/{product}', ProductDetails::class)->name('product.details');
    Route::get('/card', Card::class)->name('card');
    Route::get('/about', \App\Livewire\Client\About::class)->name('about');
    Route::get('/contact', \App\Livewire\Client\Contact::class)->name('contact');
});
