<?php

use App\Livewire\Client\AboutUs;
use App\Livewire\Client\ContactUs;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Admin Components
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

// Client Components
use App\Livewire\Client\Catalog;
use App\Livewire\Client\Categories as ClientCategories;
use App\Livewire\Client\Companies;
use App\Livewire\Client\ProductDetails;
use App\Livewire\Client\CompanyDetails;
use App\Livewire\Client\Card;
use App\Livewire\Client\About;
use App\Livewire\Client\Contact;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to catalog
Route::get('/', fn () => redirect()->route('client.catalog'));

// Laravel Auth Routes (registration disabled)
Auth::routes(['register' => false]);

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    // ->middleware(['web', 'auth', 'admin'])
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

        // Logout
        Route::post('/logout', function () {
            auth()->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return redirect()->route('login');
        })->name('logout');
    });

/*
|--------------------------------------------------------------------------
| Client Routes
|--------------------------------------------------------------------------
*/
Route::prefix('client')
    ->name('client.')
    ->middleware(['web'])
    ->group(function () {
        // Main pages
        Route::get('/catalog', Catalog::class)->name('catalog');
        Route::get('/categories', ClientCategories::class)->name('categories');
        Route::get('/companies', Companies::class)->name('companies');
        
        // Detail pages
        Route::get('/products/{product}', ProductDetails::class)->name('product.details');
        Route::get('/companies/{company}', CompanyDetails::class)->name('company.details');
        
        // Cart
        Route::get('/cart', Card::class)->name('card');
        
        // Info pages
        Route::get('/about', AboutUs::class)->name('about-us');
        Route::get('/contact', ContactUs::class)->name('contact-us');
    });
