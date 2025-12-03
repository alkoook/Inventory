<?php

use App\Livewire\Client\Card;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Categories;
use App\Livewire\Client\Catalog;
use App\Livewire\Client\Companies;
use App\Livewire\Client\ProductDetails;
use App\Livewire\Client\CompanyDetails;
use App\Livewire\Auth\Login;

Route::get('/', fn () => redirect()->route('client.catalog'));

// Authentication Routes
Route::get('/login', Login::class)->name('login')->middleware('guest');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['web', 'admin'])->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('/categories', Categories::class)->name('categories');
    Route::get('/products', \App\Livewire\Admin\Products::class)->name('products');
    Route::get('/companies', \App\Livewire\Admin\Companies::class)->name('companies');
    Route::get('/customers', \App\Livewire\Admin\Customers::class)->name('customers');
    Route::get('/invoices', \App\Livewire\Admin\PurchaseInvoices::class)->name('invoices');
    Route::get('/sales', \App\Livewire\Admin\SalesInvoices::class)->name('sales');
    Route::get('/orders', \App\Livewire\Admin\Orders::class)->name('orders');
    Route::get('/settings', \App\Livewire\Admin\Settings::class)->name('settings');
    Route::get('/users', \App\Livewire\Admin\Users::class)->name('users');
    Route::post('/logout', function () {
        auth()->logout();
        return redirect()->route('login');
    })->name('logout');
});

// Client Routes
Route::prefix('client')->name('client.')->middleware(['web'])->group(function () {
    Route::get('/catalog', Catalog::class)->name('catalog');
    Route::get('/categories', \App\Livewire\Client\Categories::class)->name('categories');
    Route::get('/companies', Companies::class)->name('companies');
    Route::get('/companies/{company}', CompanyDetails::class)->name('company.details');
    Route::get('/products/{product}', ProductDetails::class)->name('product.details');
    Route::get('/card', Card::class)->name('card');
    Route::get('/about-us', \App\Livewire\Client\AboutUs::class)->name('about-us');
    Route::get('/contact-us', \App\Livewire\Client\ContactUs::class)->name('contact-us');
});
