<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <div class="p-2 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                سلة المشتريات
            </h1>
            <p class="text-gray-600 mt-1">راجع مشترياتك واتمم طلبك بكل سهولة</p>
        </div>
        <a href="{{ route('client.catalog') }}" class="flex items-center gap-2 px-6 py-3 bg-white border-2 border-gray-200 hover:border-indigo-600 text-gray-700 hover:text-indigo-600 font-bold rounded-xl transition-all shadow-sm hover:shadow-lg">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
            متابعة التسوق
        </a>
    </div>

    @if (! $cart || $cart->items->isEmpty())
        <!-- Empty Cart -->
        <div class="bg-white rounded-3xl shadow-lg p-16 text-center border border-gray-100">
            <div class="w-32 h-32 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-16 h-16 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">السلة فارغة</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">لم تقم بإضافة أي منتجات للسلة بعد. استعرض منتجاتنا المميزة وابدأ التسوق الآن!</p>
            <a href="{{ route('client.catalog') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl hover:shadow-2xl hover:shadow-indigo-500/50 transition-all transform hover:-translate-y-1">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                استعرض المنتجات
            </a>
        </div>
    @else
        <!-- Cart Items -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Items List -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart->items as $item)
                    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl p-6 border border-gray-100 transition-all">
                        <div class="flex gap-6">
                            <!-- Product Image -->
                            <div class="flex-shrink-0 w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl flex items-center justify-center shadow-inner">
                                <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            
                            <!-- Product Info -->
                            <div class="flex-1">
                                <div class="flex items-start justify-between mb-2">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">{{ $item->product?->name }}</h3>
                                        <p class="text-sm text-gray-500 flex items-center gap-1 mt-1">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $item->product?->category?->name }}
                                        </p>
                                    </div>
                                    <button class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                                
                                <div class="flex items-center justify-between mt-4">
                                    <!-- Quantity -->
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-semibold text-gray-600">الكمية:</span>
                                        <div class="flex items-center gap-2">
                                            <button wire:click="decrement({{ $item->id }})" class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-600 transition-colors font-bold">-</button>
                                            <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-600 to-purple-600 text-white text-lg font-bold shadow-lg shadow-indigo-500/50">
                                                {{ $item->quantity }}
                                            </span>
                                            <button wire:click="increment({{ $item->id }})" class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-600 transition-colors font-bold">+</button>
                                        </div>
                                    </div>
                                    
                                    <!-- Price -->
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500">{{ number_format($item->unit_price, 2) }} ر.س × {{ $item->quantity }}</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ number_format($item->total_price, 2) }} <span class="text-sm text-gray-500">ر.س</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button wire:click="remove({{ $item->id }})" class="absolute top-4 left-4 p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                @endforeach
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 rounded-3xl shadow-2xl p-6 sticky top-24">
                    <div class="text-white">
                        <h3 class="text-2xl font-bold mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            ملخص الطلب
                        </h3>
                        
                        <div class="space-y-3 mb-6 pb-6 border-b border-white/20">
                            <div class="flex justify-between text-indigo-100">
                                <span>عدد المنتجات:</span>
                                <span class="font-bold">{{ $cart->items->count() }}</span>
                            </div>
                            <div class="flex justify-between text-indigo-100">
                                <span>المجموع الفرعي:</span>
                                <span class="font-bold">{{ number_format($cart->total_amount, 2) }} ر.س</span>
                            </div>
                            <div class="flex justify-between text-indigo-100">
                                <span>الشحن:</span>
                                <span class="font-bold">مجاناً</span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between text-2xl font-bold mb-6">
                            <span>الإجمالي:</span>
                            <span>{{ number_format($cart->total_amount, 2) }} ر.س</span>
                        </div>
                        
                        <button wire:click="submit" wire:confirm="هل أنت متأكد من إرسال الطلب للاعتماد؟" class="w-full py-4 bg-white text-indigo-600 font-bold rounded-xl hover:shadow-2xl transition-all transform hover:scale-105 flex items-center justify-center gap-2">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            إتمام الطلب
                        </button>
                        
                        <p class="text-xs text-indigo-100 text-center mt-4">
                            🔒 عملية دفع آمنة ومشفرة
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>