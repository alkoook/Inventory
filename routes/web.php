<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Admin
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Categories;
use App\Livewire\Admin\Products;
use App\Livewire\Admin\Companies as AdminCompanies;
use App\Livewire\Admin\Customers;
use App\Livewire\Admin\Orders;
use App\Livewire\Admin\SalesInvoices;
use App\Livewire\Admin\PurchaseInvoices;
use App\Livewire\Admin\Settings;
use App\Livewire\Admin\Users;

// Client
use App\Livewire\Client\Catalog;
use App\Livewire\Client\Categories as ClientCategories;
use App\Livewire\Client\Companies;
use App\Livewire\Client\ProductDetails;
use App\Livewire\Client\CompanyDetails;
use App\Livewire\Client\Card;
use App\Livewire\Client\About;
use App\Livewire\Client\Contact;
use App\Livewire\Client\AboutUs;
use App\Livewire\Client\ContactUs;

// Auth
use App\Livewire\Auth\Login;


// Redirect root
Route::get('/', fn () => redirect()->route('client.catalog'));

Auth::routes(['register' => false]);


// -----------------------------
// ADMIN ROUTES
// -----------------------------
Route::prefix('admin')
    ->name('admin.')
    // ->middleware(['web', 'admin'])
    ->group(function () {

        Route::get('/', Dashboard::class)->name('dashboard');
        Route::get('/categories', Categories::class)->name('categories');
        Route::get('/products', Products::class)->name('products');
        Route::get('/companies', AdminCompanies::class)->name('companies');
        Route::get('/customers', Customers::class)->name('customers');
        Route::get('/orders', Orders::class)->name('orders');
        Route::get('/sales-invoices', SalesInvoices::class)->name('sales-invoices');
        Route::get('/purchase-invoices', PurchaseInvoices::class)->name('purchase-invoices');
        Route::get('/settings', Settings::class)->name('settings');
        Route::get('/users', Users::class)->name('users');

        Route::post('/logout', function () {
            auth()->logout();
            return redirect()->route('login');
        })->name('logout');
    });


// -----------------------------
// CLIENT ROUTES
// -----------------------------
Route::prefix('client')
    ->name('client.')
    ->middleware(['web'])
    ->group(function () {

        Route::get('/catalog', Catalog::class)->name('catalog');
        Route::get('/categories', ClientCategories::class)->name('categories');
        Route::get('/companies', Companies::class)->name('companies');
        Route::get('/companies/{company}', CompanyDetails::class)->name('company.details');
        Route::get('/products/{product}', ProductDetails::class)->name('product.details');
        Route::get('/card', Card::class)->name('card');

        Route::get('/about', About::class)->name('about');
        Route::get('/contact', Contact::class)->name('contact');
        Route::get('/about-us', AboutUs::class)->name('about-us');
        Route::get('/contact-us', ContactUs::class)->name('contact-us');
    });
