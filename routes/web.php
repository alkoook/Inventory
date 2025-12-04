<?php

use Illuminate\Support\Facades\Route;

// ============================================
// Admin Livewire Components
// ============================================
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Settings;

// ============================================
// Client Livewire Components
// ============================================
use App\Livewire\Client\AboutUs;
use App\Livewire\Client\Card;
use App\Livewire\Client\Catalog;
use App\Livewire\Client\Categories as ClientCategories;
use App\Livewire\Client\Companies;
use App\Livewire\Client\CompanyDetails;
use App\Livewire\Client\ContactUs;
use App\Livewire\Client\ProductDetails;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to client catalog
Route::get('/', fn () => redirect()->route('client.catalog'));

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', \App\Livewire\Auth\Login::class)->name('login')->middleware('guest');



/*
|--------------------------------------------------------------------------
| Admin Panel Routes
|--------------------------------------------------------------------------
| All admin routes require authentication and admin role.
| Each module follows RESTful pattern: index, create, edit/view
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {
        
        // Dashboard
        Route::get('/', Dashboard::class)->name('dashboard');
        
        // ============================================
        // Inventory Management
        // ============================================
        
        // Categories
        Route::get('/categories', \App\Livewire\Admin\Categories\Index::class)->name('categories.index');
        Route::get('/categories/create', \App\Livewire\Admin\Categories\Create::class)->name('categories.create');
        Route::get('/categories/{id}/edit', \App\Livewire\Admin\Categories\Edit::class)->name('categories.edit');
        
        // Companies
        Route::get('/companies', \App\Livewire\Admin\Companies\Index::class)->name('companies.index');
        Route::get('/companies/create', \App\Livewire\Admin\Companies\Create::class)->name('companies.create');
        Route::get('/companies/{id}/edit', \App\Livewire\Admin\Companies\Edit::class)->name('companies.edit');
        
        // Products
        Route::get('/products', \App\Livewire\Admin\Products\Index::class)->name('products.index');
        Route::get('/products/create', \App\Livewire\Admin\Products\Create::class)->name('products.create');
        Route::get('/products/{id}/edit', \App\Livewire\Admin\Products\Edit::class)->name('products.edit');
        
        // Inventory
        Route::get('/inventory', \App\Livewire\Admin\Inventory\Index::class)->name('inventory.index');
        
        // ============================================
        // Sales & Customer Management
        // ============================================
        
        // // Customers
        // Route::get('/customers', \App\Livewire\Admin\Customers\Index::class)->name('customers.index');
        // Route::get('/customers/create', \App\Livewire\Admin\Customers\Create::class)->name('customers.create');
        // Route::get('/customers/{id}/edit', \App\Livewire\Admin\Customers\Edit::class)->name('customers.edit');
        
        // Customer Orders
        Route::get('/orders', \App\Livewire\Admin\Orders\Index::class)->name('orders.index');
        Route::get('/orders/{id}', \App\Livewire\Admin\Orders\View::class)->name('orders.view');
        
        // Sales Invoices
        Route::get('/sales-invoices', \App\Livewire\Admin\SalesInvoices\Index::class)->name('sales-invoices.index');
        Route::get('/sales-invoices/create', \App\Livewire\Admin\SalesInvoices\Create::class)->name('sales-invoices.create');
        Route::get('/sales-invoices/{id}', \App\Livewire\Admin\SalesInvoices\View::class)->name('sales-invoices.view');
        
        // Purchase Invoices
        Route::get('/purchase-invoices', \App\Livewire\Admin\PurchaseInvoices\Index::class)->name('purchase-invoices.index');
        Route::get('/purchase-invoices/create', \App\Livewire\Admin\PurchaseInvoices\Create::class)->name('purchase-invoices.create');
        Route::get('/purchase-invoices/{id}', \App\Livewire\Admin\PurchaseInvoices\View::class)->name('purchase-invoices.view');
        
        // ============================================
        // System Management
        // ============================================
        
        // Users
        Route::get('/users', \App\Livewire\Admin\Users\Index::class)->name('users.index');
        Route::get('/users/create', \App\Livewire\Admin\Users\Create::class)->name('users.create');
        Route::get('/users/{id}/edit', \App\Livewire\Admin\Users\Edit::class)->name('users.edit');
        
        // Settings
        Route::get('/settings', Settings::class)->name('settings');

        //logout
        Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');
    });

/*
|--------------------------------------------------------------------------
| Client/Public Routes
|--------------------------------------------------------------------------
| Public-facing routes for browsing products and managing cart
*/
Route::prefix('client')
    ->name('client.')
    ->middleware(['web'])
    ->group(function () {
        
        // Main browsing pages
        Route::get('/catalog', Catalog::class)->name('catalog');
        Route::get('/categories', ClientCategories::class)->name('categories');
        Route::get('/companies', Companies::class)->name('companies');
        
        // Detail pages
        Route::get('/products', ProductDetails::class)->name('products');
        Route::get('/products/{product}', ProductDetails::class)->name('product.details');
        Route::get('/companies/{company}', CompanyDetails::class)->name('company.details');
        
        // Shopping cart
        Route::get('/cart', Card::class)->name('card');
        
        // Information pages
        Route::get('/about', AboutUs::class)->name('about-us');
        Route::get('/contact', ContactUs::class)->name('contact-us');
    });
