<?php

use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Settings;
use App\Livewire\Client\AboutUs;
use App\Livewire\Client\Card;
use App\Livewire\Client\Catalog;
use App\Livewire\Client\Categories as ClientCategories;
use App\Livewire\Client\Companies;
use App\Livewire\Client\CompanyDetails;
use App\Livewire\Client\ContactUs;
use App\Livewire\Client\Home;
use App\Livewire\Client\ProductDetails;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ============================================
// Public Routes
// ============================================
Route::get('/', Home::class)->name('home')->middleware('auth');
Route::get('/login', \App\Livewire\Auth\Login::class)->name('login')->middleware('guest');

// ============================================
// Admin Panel Routes
// ============================================
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        
        // Dashboard
        Route::get('/', Dashboard::class)->name('dashboard');
        
        // Categories
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', \App\Livewire\Admin\Categories\Index::class)->name('index');
            Route::get('/create', \App\Livewire\Admin\Categories\Create::class)->name('create');
            Route::get('/{id}/edit', \App\Livewire\Admin\Categories\Edit::class)->name('edit');
        });
        
        // Companies
        Route::prefix('companies')->name('companies.')->group(function () {
            Route::get('/', \App\Livewire\Admin\Companies\Index::class)->name('index');
            Route::get('/create', \App\Livewire\Admin\Companies\Create::class)->name('create');
            Route::get('/{id}/edit', \App\Livewire\Admin\Companies\Edit::class)->name('edit');
        });
        
        // Products
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', \App\Livewire\Admin\Products\Index::class)->name('index');
            Route::get('/create', \App\Livewire\Admin\Products\Create::class)->name('create');
            Route::get('/{id}/edit', \App\Livewire\Admin\Products\Edit::class)->name('edit');
        });
        
        // Inventory
        Route::get('/inventory', \App\Livewire\Admin\Inventory\Index::class)->name('inventory.index');
        
        // Orders
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', \App\Livewire\Admin\Orders\Index::class)->name('index');
            Route::get('/{id}', \App\Livewire\Admin\Orders\View::class)->name('view');
            Route::get('/{id}/approve', \App\Livewire\Admin\Orders\Approve::class)->name('approve');
            Route::get('/{id}/reject', \App\Livewire\Admin\Orders\Reject::class)->name('reject');
        });
        
        // Sales Invoices
        Route::prefix('sales-invoices')->name('sales-invoices.')->group(function () {
            Route::get('/', \App\Livewire\Admin\SalesInvoices\Index::class)->name('index');
            Route::get('/create', \App\Livewire\Admin\SalesInvoices\Create::class)->name('create');
            Route::get('/{id}', \App\Livewire\Admin\SalesInvoices\View::class)->name('view');
            Route::get('/{id}/edit', \App\Livewire\Admin\SalesInvoices\Edit::class)->name('edit');
        });
        
        // Purchase Invoices
        Route::prefix('purchase-invoices')->name('purchase-invoices.')->group(function () {
            Route::get('/', \App\Livewire\Admin\PurchaseInvoices\Index::class)->name('index');
            Route::get('/create', \App\Livewire\Admin\PurchaseInvoices\Create::class)->name('create');
            Route::get('/{id}', \App\Livewire\Admin\PurchaseInvoices\View::class)->name('view');
            Route::get('/{id}/edit', \App\Livewire\Admin\PurchaseInvoices\Edit::class)->name('edit');
        });
        
        // Workers
        Route::prefix('workers')->name('workers.')->group(function () {
            Route::get('/', \App\Livewire\Admin\Workers\Index::class)->name('index');
            Route::get('/my-invoices', \App\Livewire\Admin\Workers\MyInvoices::class)->name('my-invoices');
            Route::get('/invoices/{id}', \App\Livewire\Admin\Workers\InvoiceView::class)->name('invoice-view');
        });
        
        // Users
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', \App\Livewire\Admin\Users\Index::class)->name('index');
            Route::get('/create', \App\Livewire\Admin\Users\Create::class)->name('create');
            Route::get('/{id}/edit', \App\Livewire\Admin\Users\Edit::class)->name('edit');
        });
        
        // Notifications
        Route::get('/notifications', \App\Livewire\Admin\Notifications\Index::class)->name('notifications.index');
        
        // Reports
        Route::get('/reports', \App\Livewire\Admin\Reports\Index::class)->name('reports.index');
        
        // Settings
        Route::get('/settings', Settings::class)->name('settings');
        
        // Logout
        Route::post('/logout', function () {
            auth()->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return redirect()->route('login');
        })->name('logout');
    });

// ============================================
// Client Routes
// ============================================
Route::prefix('client')
    ->name('client.')
    ->middleware('auth')
    ->group(function () {
        
        // Main Pages
        Route::get('/catalog', Catalog::class)->name('catalog');
        Route::get('/categories', ClientCategories::class)->name('categories');
        Route::get('/companies', Companies::class)->name('companies');
        
        // Detail Pages
        Route::get('/products', ProductDetails::class)->name('products');
        Route::get('/products/{product}', ProductDetails::class)->name('product.details');
        Route::get('/companies/{company}', CompanyDetails::class)->name('company.details');
        
        // Shopping Cart (Customer Only)
        Route::get('/cart', Card::class)->name('card')->middleware('customer');
        
        // Information Pages
        Route::get('/about', AboutUs::class)->name('about-us');
        Route::get('/contact', ContactUs::class)->name('contact-us');
        
        // Logout
        Route::post('/logout', function () {
            auth()->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return redirect()->route('login');
        })->name('logout');
    });
