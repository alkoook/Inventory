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

        // إحصائيات الشهر الحالي
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();
        
        $monthSales = SalesInvoice::whereBetween('invoice_date', [$monthStart, $monthEnd])
            ->orWhereBetween('created_at', [$monthStart, $monthEnd])
            ->sum('total_amount');

        $monthPurchases = PurchaseInvoice::whereBetween('invoice_date', [$monthStart, $monthEnd])
            ->orWhereBetween('created_at', [$monthStart, $monthEnd])
            ->sum('total_amount');

        $monthProfit = $monthSales - $monthPurchases;

        // إحصائيات إجمالية
        $totalSales = SalesInvoice::sum('total_amount');
        $totalPurchases = PurchaseInvoice::sum('total_amount');
        $totalProfit = $totalSales - $totalPurchases;

        $recentOrders = Cart::with(['user', 'items'])
            ->where('status', 'open')
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.admin.dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'monthSales' => $monthSales,
            'monthPurchases' => $monthPurchases,
            'monthProfit' => $monthProfit,
            'totalSales' => $totalSales,
            'totalPurchases' => $totalPurchases,
            'totalProfit' => $totalProfit,
        ])->layout('components.layouts.admin', ['header' => 'لوحة التحكم']);
    }
}
