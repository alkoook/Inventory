<?php

namespace App\Livewire\Admin\Reports;

use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\SalesInvoice;
use App\Models\SalesInvoiceItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $activeReport = 'inventory';
    public $dateFrom;
    public $dateTo;
    public $productId;
    public $customerId;

    public function mount()
    {
        $this->dateFrom = Carbon::now()->startOfMonth()->toDateString();
        $this->dateTo = Carbon::now()->toDateString();
    }

    public function render()
    {
        $data = [];

        switch ($this->activeReport) {
            case 'inventory':
                $data = $this->getInventoryReport();
                break;
            case 'low_stock':
                $data = $this->getLowStockReport();
                break;
            case 'movement':
                $data = $this->getMovementReport();
                break;
            case 'sales_by_product':
                $data = $this->getSalesByProductReport();
                break;
            case 'sales_by_period':
                $data = $this->getSalesByPeriodReport();
                break;
            case 'slow_moving':
                $data = $this->getSlowMovingReport();
                break;
            case 'profit_loss':
                $data = $this->getProfitLossReport();
                break;
            case 'customer_sales':
                $data = $this->getCustomerSalesReport();
                break;
        }

        return view('livewire.admin.reports.index', array_merge($data, [
            'products' => Product::where('is_active', true)->get(),
            'customers' => User::whereHas('roles', function ($q) {
                $q->where('name', 'customer');
            })->get(),
        ]))->layout('components.layouts.admin', ['header' => 'التقارير']);
    }

    protected function getInventoryReport()
    {
        $products = Product::with(['category', 'company'])
            ->where('is_active', true)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'category' => $product->category?->name,
                    'company' => $product->company?->name,
                    'current_stock' => $product->stock,
                    'reorder_level' => $product->reorder_level ?? 0,
                    'unit_of_measure' => $product->unit_of_measure,
                    'purchase_price' => $product->purchase_price,
                    'total_cost' => $product->stock * $product->purchase_price,
                ];
            })
            ->values();

        return ['inventoryProducts' => $products];
    }

    protected function getLowStockReport()
    {
        $products = Product::with(['category', 'company'])
            ->where('is_active', true)
            ->get()
            ->filter(function ($product) {
                $reorderLevel = $product->reorder_level ?? 0;
                return $product->stock <= $reorderLevel;
            })
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'category' => $product->category?->name,
                    'current_stock' => $product->stock,
                    'reorder_level' => $product->reorder_level ?? 0,
                    'unit_of_measure' => $product->unit_of_measure,
                ];
            })
            ->values();

        return ['lowStockProducts' => $products];
    }

    protected function getMovementReport()
    {
        $query = InventoryTransaction::with(['product', 'user'])
            ->orderBy('created_at', 'desc');

        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }
        if ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }
        if ($this->productId) {
            $query->where('product_id', $this->productId);
        }

        $transactions = $query->paginate(50);

        return ['movements' => $transactions];
    }

    protected function getSalesByProductReport()
    {
        $query = SalesInvoiceItem::with(['product', 'salesInvoice'])
            ->selectRaw('
                product_id,
                SUM(quantity) as total_quantity,
                SUM(total_price) as total_revenue,
                COUNT(DISTINCT sales_invoice_id) as invoice_count
            ')
            ->groupBy('product_id');

        if ($this->dateFrom) {
            $query->whereHas('salesInvoice', function ($q) {
                $q->whereDate('invoice_date', '>=', $this->dateFrom);
            });
        }
        if ($this->dateTo) {
            $query->whereHas('salesInvoice', function ($q) {
                $q->whereDate('invoice_date', '<=', $this->dateTo);
            });
        }

        $sales = $query->get()->map(function ($item) {
            $product = $item->product;
            $purchasePrice = $product ? $product->purchase_price : 0;
            $totalCost = $item->total_quantity * $purchasePrice;
            $profit = $item->total_revenue - $totalCost;

            return [
                'product_id' => $item->product_id,
                'product_name' => $product?->name ?? 'غير معروف',
                'sku' => $product?->sku ?? '-',
                'total_quantity' => $item->total_quantity,
                'invoice_count' => $item->invoice_count,
                'total_revenue' => $item->total_revenue,
                'total_cost' => $totalCost,
                'profit' => $profit,
                'profit_margin' => $item->total_revenue > 0 ? ($profit / $item->total_revenue) * 100 : 0,
            ];
        })->sortByDesc('total_revenue')
          ->values();

        return ['salesByProduct' => $sales];
    }

    protected function getSalesByPeriodReport()
    {
        $startDate = $this->dateFrom ? Carbon::parse($this->dateFrom) : Carbon::now()->startOfMonth();
        $endDate = $this->dateTo ? Carbon::parse($this->dateTo) : Carbon::now();

        $daily = [];
        $current = $startDate->copy();

        while ($current <= $endDate) {
            $sales = SalesInvoice::whereDate('invoice_date', $current->toDateString())
                ->sum('total_amount');
            $daily[] = [
                'date' => $current->format('Y-m-d'),
                'date_formatted' => $current->format('d/m/Y'),
                'sales' => $sales,
            ];
            $current->addDay();
        }

        // Weekly summary
        $weekly = [];
        $weekStart = $startDate->copy()->startOfWeek();
        while ($weekStart <= $endDate) {
            $weekEnd = $weekStart->copy()->endOfWeek();
            if ($weekEnd > $endDate) {
                $weekEnd = $endDate;
            }
            $sales = SalesInvoice::whereBetween('invoice_date', [$weekStart, $weekEnd])
                ->sum('total_amount');
            $weekly[] = [
                'week' => $weekStart->format('Y-m-d') . ' - ' . $weekEnd->format('Y-m-d'),
                'sales' => $sales,
            ];
            $weekStart->addWeek();
        }

        // Monthly summary
        $monthly = [];
        $monthStart = $startDate->copy()->startOfMonth();
        while ($monthStart <= $endDate) {
            $monthEnd = $monthStart->copy()->endOfMonth();
            if ($monthEnd > $endDate) {
                $monthEnd = $endDate;
            }
            $sales = SalesInvoice::whereBetween('invoice_date', [$monthStart, $monthEnd])
                ->sum('total_amount');
            $monthly[] = [
                'month' => $monthStart->format('Y-m'),
                'month_formatted' => $monthStart->format('M Y'),
                'sales' => $sales,
            ];
            $monthStart->addMonth();
        }

        return [
            'dailySales' => $daily,
            'weeklySales' => $weekly,
            'monthlySales' => $monthly,
        ];
    }

    protected function getSlowMovingReport()
    {
        $daysThreshold = 90; // 90 days without sales
        $cutoffDate = Carbon::now()->subDays($daysThreshold);

        $allProducts = Product::where('is_active', true)->get();
        $soldProducts = SalesInvoiceItem::whereHas('salesInvoice', function ($q) use ($cutoffDate) {
            $q->where('invoice_date', '>=', $cutoffDate);
        })->pluck('product_id')->unique();

        $slowMoving = $allProducts->filter(function ($product) use ($soldProducts) {
            return !$soldProducts->contains($product->id);
        })->map(function ($product) {
            $lastSale = SalesInvoiceItem::where('product_id', $product->id)
                ->whereHas('salesInvoice')
                ->orderBy('created_at', 'desc')
                ->first();

            return [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'category' => $product->category?->name,
                'current_stock' => $product->stock,
                'purchase_price' => $product->purchase_price,
                'total_cost' => $product->stock * $product->purchase_price,
                'last_sale_date' => $lastSale?->created_at?->format('Y-m-d') ?? 'لم يُبع',
                'days_without_sale' => $lastSale ? $lastSale->created_at->diffInDays(now()) : 'N/A',
            ];
        })
        ->values();

        return ['slowMovingProducts' => $slowMoving];
    }

    protected function getProfitLossReport()
    {
        $startDate = $this->dateFrom ? Carbon::parse($this->dateFrom) : Carbon::now()->startOfMonth();
        $endDate = $this->dateTo ? Carbon::parse($this->dateTo) : Carbon::now();

        // Revenue (Sales) - Check both invoice_date and created_at
        $revenue = SalesInvoice::where(function ($q) use ($startDate, $endDate) {
            $q->whereBetween('invoice_date', [$startDate, $endDate])
              ->orWhere(function ($q2) use ($startDate, $endDate) {
                  $q2->whereNull('invoice_date')
                     ->whereBetween('created_at', [$startDate, $endDate]);
              });
        })->sum('total_amount');

        // COGS (Cost of Goods Sold)
        $cogs = SalesInvoiceItem::whereHas('salesInvoice', function ($q) use ($startDate, $endDate) {
            $q->where(function ($q2) use ($startDate, $endDate) {
                $q2->whereBetween('invoice_date', [$startDate, $endDate])
                   ->orWhere(function ($q3) use ($startDate, $endDate) {
                       $q3->whereNull('invoice_date')
                          ->whereBetween('created_at', [$startDate, $endDate]);
                   });
            });
        })->with('product')->get()->sum(function ($item) {
            $purchasePrice = $item->product?->purchase_price ?? 0;
            return $item->quantity * $purchasePrice;
        });

        // Purchases
        $purchases = \App\Models\PurchaseInvoice::where(function ($q) use ($startDate, $endDate) {
            $q->whereBetween('invoice_date', [$startDate, $endDate])
              ->orWhere(function ($q2) use ($startDate, $endDate) {
                  $q2->whereNull('invoice_date')
                     ->whereBetween('created_at', [$startDate, $endDate]);
              });
        })->sum('total_amount');

        $grossProfit = $revenue - $cogs;
        $netProfit = $grossProfit - $purchases;

        return [
            'revenue' => $revenue,
            'cogs' => $cogs,
            'purchases' => $purchases,
            'grossProfit' => $grossProfit,
            'netProfit' => $netProfit,
            'grossMargin' => $revenue > 0 ? ($grossProfit / $revenue) * 100 : 0,
            'netMargin' => $revenue > 0 ? ($netProfit / $revenue) * 100 : 0,
        ];
    }

    protected function getCustomerSalesReport()
    {
        // Build base query with date filters
        $baseQuery = SalesInvoice::query();
        
        if ($this->dateFrom) {
            $baseQuery->where(function ($q) {
                $q->whereDate('invoice_date', '>=', $this->dateFrom)
                  ->orWhere(function ($q2) {
                      $q2->whereNull('invoice_date')
                         ->whereDate('created_at', '>=', $this->dateFrom);
                  });
            });
        }
        if ($this->dateTo) {
            $baseQuery->where(function ($q) {
                $q->whereDate('invoice_date', '<=', $this->dateTo)
                  ->orWhere(function ($q2) {
                      $q2->whereNull('invoice_date')
                         ->whereDate('created_at', '<=', $this->dateTo);
                  });
            });
        }
        if ($this->customerId) {
            $baseQuery->where(function ($q) {
                $q->where('customer_user_id', $this->customerId)
                  ->orWhere('user_id', $this->customerId);
            });
        }

        // Get invoices grouped by customer (prefer customer_user_id, fallback to user_id)
        $invoices = $baseQuery->get();
        
        $customerData = [];
        
        foreach ($invoices as $invoice) {
            // Use customer_user_id if available, otherwise user_id
            $customerId = $invoice->customer_user_id ?? $invoice->user_id;
            
            if (!isset($customerData[$customerId])) {
                $customerData[$customerId] = [
                    'customer_id' => $customerId,
                    'invoice_count' => 0,
                    'total_spent' => 0,
                ];
            }
            
            $customerData[$customerId]['invoice_count']++;
            $customerData[$customerId]['total_spent'] += $invoice->total_amount;
        }

        // Map to final format with top products
        $customers = collect($customerData)->map(function ($data) {
            $customer = User::find($data['customer_id']);
            
            $topProducts = SalesInvoiceItem::whereHas('salesInvoice', function ($q) use ($data) {
                $q->where(function ($q2) use ($data) {
                    $q2->where('customer_user_id', $data['customer_id'])
                       ->orWhere('user_id', $data['customer_id']);
                });
            })
                ->selectRaw('product_id, SUM(quantity) as total_quantity')
                ->groupBy('product_id')
                ->orderByDesc('total_quantity')
                ->limit(5)
                ->with('product')
                ->get()
                ->map(function ($item) {
                    return [
                        'product_name' => $item->product?->name ?? 'غير معروف',
                        'quantity' => $item->total_quantity,
                    ];
                });

            return [
                'customer_id' => $data['customer_id'],
                'customer_name' => $customer?->name ?? 'غير معروف',
                'invoice_count' => $data['invoice_count'],
                'total_spent' => $data['total_spent'],
                'top_products' => $topProducts,
            ];
        })->sortByDesc('total_spent')
          ->values();

        return ['customerSales' => $customers];
    }
}

