<?php

namespace App\Livewire\Admin\SalesInvoices;

use App\Models\SalesInvoice;
use App\Models\SalesInvoiceItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\InventoryTransaction;
use App\Models\User;
use Livewire\Component;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Traits\HasRoles;

class Create extends Component
{
    public $customer_id = '';
    public $invoice_date;
    public $notes = '';

    public $items = [];

    public function mount()
    {
        $this->invoice_date = now()->format('Y-m-d');
        $this->addItem();
    }

    protected function rules()
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ];
    }

    public function addItem()
    {
        $this->items[] = [
            'product_id' => '',
            'quantity' => 1,
            'unit_price' => 0,
        ];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function updatedItems($value, $key)
    {
        // إذا المستخدم غيّر المنتج
        if (str_contains($key, 'product_id')) {

            $index = explode('.', $key)[0];
            $productId = $this->items[$index]['product_id'];

            // منع التكرار
            if ($productId && collect($this->items)->pluck('product_id')->duplicates()->isNotEmpty()) {
                $this->items[$index]['product_id'] = '';
                throw ValidationException::withMessages([
                    "items.$index.product_id" => "لا يمكنك اختيار نفس المنتج أكثر من مرة."
                ]);
            }

            // جلب السعر تلقائياً
            $product = Product::find($productId);
            if ($product) {
                $this->items[$index]['unit_price'] = $product->sale_price;
            }
        }
    }

    public function save()
    {
        $this->validate();

        // تأكيد عدم التكرار
        $duplicate = collect($this->items)->groupBy('product_id')
            ->filter(fn ($g) => $g->count() > 1);

        if($duplicate->isNotEmpty()) {
            throw ValidationException::withMessages([
                'items' => 'المنتجات المكررة غير مسموحة.'
            ]);
        }

        // التحقق من المخزون
        foreach ($this->items as $index => $item) {
            $product = Product::find($item['product_id']);

            if ($product->stock < $item['quantity']) {
                throw ValidationException::withMessages([
                    "items.$index.quantity" => "الكمية المطلوبة غير متوفرة، المتاح: {$product->stock}."
                ]);
            }
        }

        // حساب الإجمالي
        $total = collect($this->items)
            ->sum(fn($i) => $i['quantity'] * $i['unit_price']);

        // إنشاء فاتورة
        $invoice = SalesInvoice::create([
            'customer_id'    => $this->customer_id,
            'invoice_number' => 'INV-' . now()->format('YmdHis'),
            'invoice_date'   => $this->invoice_date,
            'total_amount'   => $total,
            'cost_amount'    => 0,
            'profit_amount'  => 0,
            'status'         => 'approved',
            'notes'          => $this->notes,
        ]);

        // إنشاء العناصر + خصم المخزون + تخزين الحركة
        foreach ($this->items as $item) {
            $product = Product::find($item['product_id']);

            // حفظ عنصر الفاتورة
            SalesInvoiceItem::create([
                'sales_invoice_id' => $invoice->id,
                'product_id'       => $product->id,
                'quantity'         => $item['quantity'],
                'unit_price'       => $item['unit_price'],
                'total_price'      => $item['quantity'] * $item['unit_price'],
            ]);

            // خصم المخزون
            $product->decrement('stock', $item['quantity']);

            // تسجيل حركة المخزون
            InventoryTransaction::createTransaction(
                $product->id,
                'sale',
                $item['quantity'],
                SalesInvoice::class,
                $invoice->id,
                'بيع - فاتورة: ' . $invoice->invoice_number
            );
        }

        session()->flash('message', 'تم إنشاء الفاتورة بنجاح.');
        return redirect()->route('admin.sales-invoices.index');
    }

    public function render()
    {
        return view('livewire.admin.sales-invoices.create', [
            'customers' => User::role('customer')->get(),
            'products'  => Product::where('stock', '>', 0)->get(),
        ])->layout('components.layouts.admin', [
            'header' => 'إنشاء فاتورة مبيعات'
        ]);
    }
    protected $listeners = [
    'update-product' => 'setProduct',
];

public function setProduct($data)
{
    $this->items[$data['index']]['product_id'] = $data['product_id'];
}

}
