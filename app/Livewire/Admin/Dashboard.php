<?php

namespace App\Livewire\Admin;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use App\Models\SalesInvoice;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'products' => Product::count(),
            'categories' => Category::count(),
            'companies' => Company::count(),
            'pending_orders' => Cart::where('status', 'open')->count(), // Assuming 'open' means pending for now
            'total_sales' => SalesInvoice::sum('total_amount'),
            // 'low_stock' => Product::where('stock_quantity', '<', 10)->count(),
        ];

        $recentOrders = Cart::with(['customer.user', 'items'])
            ->where('status', 'open')
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.admin.dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
        ])->layout('components.layouts.admin', ['header' => 'لوحة التحكم']);
    }
}
