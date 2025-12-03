<<<<<<< HEAD
<div class="space-y-6">
    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="bg-green-50 border-2 border-green-200 text-green-800 px-6 py-4 rounded-xl shadow-lg flex items-center gap-3 animate-bounce">
            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="font-bold">{{ session('message') }}</span>
        </div>
    @endif
    
    <!-- Hero Banner -->
    <div class="relative bg-gradient-to-br from-indigo-600 via-blue-600 to-purple-600 rounded-3xl overflow-hidden shadow-2xl">
        <div class="absolute inset-0 bg-grid-white/[0.05] bg-[size:30px_30px]"></div>
        <div class="relative px-8 py-12 md:py-16">
            <div class="max-w-2xl">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 leading-tight">
                    اكتشف أفضل المنتجات 
                    <span class="text-indigo-200">بأفضل الأسعار</span>
                </h1>
                <p class="text-lg text-indigo-100 mb-6">
                    تصفح مجموعتنا الواسعة من المنتجات عالية الجودة من أفضل الشركات الموردة
                </p>
                <a href="#products" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-indigo-600 font-bold rounded-xl hover:shadow-2xl transition-all transform hover:-translate-y-1">
                    <span>تصفح المنتجات</span>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </a>
            </div>
        </div>
        <!-- Decorative Elements -->
        <div class="absolute top-0 left-0 w-72 h-72 bg-white/10 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-500/20 rounded-full translate-x-1/3 translate-y-1/3"></div>
    </div>

    <!-- Categories -->
    <section id="products">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                <div class="w-1 h-8 bg-gradient-to-b from-indigo-600 to-blue-600 rounded-full"></div>
                الأصناف المتاحة
            </h2>
        </div>
        <div class="flex flex-wrap gap-3">
            @foreach($categories as $category)
                <button class="group px-6 py-3 bg-white border-2 border-gray-200 hover:border-indigo-600 rounded-xl font-semibold text-gray-700 hover:text-indigo-600 transition-all shadow-sm hover:shadow-lg transform hover:-translate-y-0.5">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>
    </section>

    <!-- Products Grid -->
    <section>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                <div class="w-1 h-8 bg-gradient-to-b from-indigo-600 to-blue-600 rounded-full"></div>
                أحدث المنتجات
            </h2>
            <select class="px-4 py-2 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600/20">
                <option>الأحدث</option>
                <option>الأكثر مبيعاً</option>
                <option>الأقل سعراً</option>
                <option>الأعلى سعراً</option>
            </select>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $product)
                <div class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-indigo-200 transform hover:-translate-y-1">
                    <a href="{{ route('client.product.details', $product) }}" class="block relative aspect-square bg-gradient-to-br from-gray-50 to-gray-100 overflow-hidden">
                        <div class="absolute inset-0 flex items-center justify-center text-gray-300">
                            <svg class="w-24 h-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <!-- Badge -->
                        @if($product->stock > 0)
                            <div class="absolute top-4 right-4 flex items-center gap-2 bg-green-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                متوفر
                            </div>
                        @else
                            <div class="absolute top-4 right-4 bg-red-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                                غير متوفر
                            </div>
                        @endif
                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </a>
                    
                    <div class="p-5">
                        <div class="mb-3">
                            <span class="inline-flex items-center gap-1 text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-lg mb-2">
                                {{ $product->category?->name }}
                            </span>
                            <h3 class="text-lg font-bold text-gray-900 mb-1 line-clamp-2 group-hover:text-indigo-600 transition-colors">
                                <a href="{{ route('client.product.details', $product) }}">
                                    {{ $product->name }}
                                </a>
                            </h3>
                        </div>
                        
                        <p class="text-xs text-gray-500 mb-3 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"/>
                            </svg>
                            {{ $product->company?->name }}
                        </p>
                        
                        <p class="text-sm text-gray-600 line-clamp-2 mb-4">
                            {{ $product->description }}
                        </p>
                        
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div>
                                <span class="text-2xl font-bold text-gray-900">
                                    {{ number_format($product->sale_price, 0) }}
                                </span>
                                <span class="text-sm text-gray-500 mr-1">ر.س</span>
=======
<div class="min-h-screen bg-slate-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header & Search -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 mb-6">المنتجات</h1>
            
            <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div class="md:col-span-2">
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="search"
                            placeholder="ابحث عن منتج..."
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <select 
                            wire:model.live="selectedCategory"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="">كل الأصناف</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sort -->
                    <div>
                        <select 
                            wire:model.live="sortBy"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="latest">الأحدث</option>
                            <option value="price_asc">السعر: من الأقل للأعلى</option>
                            <option value="price_desc">السعر: من الأعلى للأقل</option>
                            <option value="name_asc">الاسم: أ-ي</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition-shadow duration-200 flex flex-col">
                        <!-- Product Image Placeholder -->
                        <div class="aspect-square bg-slate-100 flex items-center justify-center border-b border-slate-100">
                            <svg class="w-16 h-16 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        
                        <div class="p-4 flex-1 flex flex-col">
                            <div class="mb-2">
                                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">
                                    {{ $product->category?->name }}
                                </span>
                            </div>
                            
                            <h3 class="text-lg font-bold text-slate-900 mb-1 line-clamp-1">
                                <a href="{{ route('client.product.details', $product) }}" class="hover:text-blue-600 transition-colors">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            
                            <p class="text-sm text-slate-500 mb-4 line-clamp-2 flex-1">
                                {{ $product->description }}
                            </p>
                            
                            <div class="flex items-center justify-between mt-auto pt-4 border-t border-slate-100">
                                <span class="text-lg font-bold text-slate-900">
                                    {{ number_format($product->sale_price, 0) }} <span class="text-sm font-normal text-slate-500">ر.س</span>
                                </span>
                                
                                <button
                                    wire:click="addToCart({{ $product->id }})"
                                    @if($product->stock <= 0) disabled @endif
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 disabled:bg-slate-300 text-white text-sm font-medium rounded-lg transition-colors flex items-center gap-2"
                                >
                                    @if($product->stock > 0)
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        إضافة
                                    @else
                                        نفذت الكمية
                                    @endif
                                </button>
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
                            </div>
                            <button
                                wire:click="addToCart({{ $product->id }})"
                                class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-bold rounded-xl hover:shadow-lg hover:shadow-indigo-500/50 transition-all transform hover:scale-105"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                إضافة
                            </button>
                        </div>
                    </div>
<<<<<<< HEAD
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </section>
=======
                @endforeach
            </div>
            
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-lg border border-slate-200">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <h3 class="text-lg font-medium text-slate-900">لا توجد منتجات</h3>
                <p class="text-slate-500 mt-1">جرب تغيير معايير البحث</p>
            </div>
        @endif
    </div>
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
</div>
