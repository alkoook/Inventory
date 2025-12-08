<?php

namespace App\Livewire\Admin;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use App\Models\PurchaseInvoice;
use App\Models\SalesInvoice;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        // إحصائيات عامة
        $stats = [
            'products' => Product::count(),
            'categories' => Category::count(),
            'companies' => Company::count(),
            'customers' => User::whereHas('roles', function ($q) {
                $q->where('name', '!=', 'admin');
            })->orWhereDoesntHave('roles')->count(),
            'pending_orders' => Cart::where('status', 'open')->count(),
        ];

        // إحصائيات اليوم
        $today = Carbon::today();
        $todaySales = SalesInvoice::whereDate('invoice_date', $today)
            ->orWhereDate('created_at', $today)
            ->sum('total_amount');

        $todayPurchases = PurchaseInvoice::whereDate('invoice_date', $today)
            ->orWhereDate('created_at', $today)
            ->sum('total_amount');

        $todayProfit = $todaySales - $todayPurchases;

        // إحصائيات إجمالية
        $totalSales = SalesInvoice::sum('total_amount');
        $totalPurchases = PurchaseInvoice::sum('total_amount');
        $totalProfit = $totalSales - $totalPurchases;

        $recentOrders = Cart::with(['customer', 'user', 'items'])
            ->where('status', 'open')
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.admin.dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'todaySales' => $todaySales,
            'todayPurchases' => $todayPurchases,
            'todayProfit' => $todayProfit,
            'totalSales' => $totalSales,
            'totalPurchases' => $totalPurchases,
            'totalProfit' => $totalProfit,
        ])->layout('components.layouts.admin', ['header' => 'لوحة التحكم']);
    }
}
