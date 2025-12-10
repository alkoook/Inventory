<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-slate-900">سلة المشتريات</h1>
            <a href="{{ route('client.catalog') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                متابعة التسوق
            </a>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

        @if (!$cart || $cart->items->isEmpty())
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-12 text-center">
                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">السلة فارغة</h3>
                <p class="text-slate-500 mb-8">لم تقم بإضافة أي منتجات للسلة بعد</p>
                <a href="{{ route('client.catalog') }}" class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    تصفح المنتجات
                </a>
            </div>
        @else
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cart->items as $item)
                        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-4 flex gap-4">
                            <!-- Image -->
                            <div class="w-24 h-24 bg-gray-100 rounded-lg flex-shrink-0 flex items-center justify-center overflow-hidden">
                                @if($item->product?->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" 
                                         alt="{{ $item->product->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                @endif
                            </div>

                            <!-- Details -->
                            <div class="flex-1 flex flex-col justify-between">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-bold text-slate-900">{{ $item->product?->name }}</h3>
                                        <p class="text-sm text-slate-500">{{ $item->product?->category?->name }}</p>
                                    </div>
                                    <button 
                                        wire:click="removeItem({{ $item->id }})"
                                        wire:confirm="هل أنت متأكد من حذف هذا المنتج؟"
                                        class="text-slate-400 hover:text-red-600 transition-colors"
                                    >
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="flex justify-between items-end mt-4">
                                    <!-- Quantity -->
                                    <div class="flex items-center border border-slate-300 rounded-lg">
                                        <button 
                                            wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})"
                                            class="px-3 py-1 hover:bg-slate-100 text-slate-600 transition-colors"
                                        >-</button>
                                        <span class="px-3 py-1 font-medium text-slate-900 border-x border-slate-300 min-w-[3rem] text-center">
                                            {{ $item->quantity }}
                                        </span>
                                        <button 
                                            wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})"
                                            @if($item->quantity >= $item->product->stock) disabled @endif
                                            class="px-3 py-1 hover:bg-slate-100 text-slate-600 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                                        >+</button>
                                    </div>

                                    <!-- Price -->
                                    <div class="text-left">
                                        <p class="text-xs text-slate-500 mb-1">{{ number_format($item->unit_price, 0) }} USD / وحدة</p>
                                        <p class="font-bold text-lg text-blue-600">{{ number_format($item->total_price, 0) }} USD</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 sticky top-6">
                        <h2 class="text-lg font-bold text-slate-900 mb-4">ملخص الطلب</h2>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-slate-600">
                                <span>عدد المنتجات</span>
                                <span>{{ $cart->items->count() }}</span>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span>إجمالي الكمية</span>
                                <span>{{ $cart->items->sum('quantity') }}</span>
                            </div>
                            <div class="border-t border-slate-200 pt-3 mt-3">
                                <div class="flex justify-between items-center font-bold text-lg text-slate-900">
                                    <span>الإجمالي</span>
                                    <span class="text-blue-600">{{ number_format($cart->total_amount, 0) }} USD</span>
                                </div>
                            </div>
                        </div>

                        <button 
                            wire:click="submitOrder"
                            wire:confirm="هل أنت متأكد من إرسال الطلب؟ سيتم إرساله للإدارة للموافقة عليه."
                            class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition-all shadow-sm hover:shadow-lg"
                        >
                            إرسال الطلب
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
