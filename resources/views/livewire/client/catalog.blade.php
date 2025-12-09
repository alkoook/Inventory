<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header & Search -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-6 text-blue-600 fade-in">المنتجات</h1>
            
            <div class="bg-white p-6 rounded-xl shadow-lg border-2 border-slate-200 hover:border-blue-600 transition-all duration-300 scale-in">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <!-- Search -->
                    <div class="md:col-span-2">
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="search"
                            placeholder="ابحث عن منتج..."
                            class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition-all duration-300 text-slate-900 placeholder-slate-400"
                        >
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <select 
                            wire:model.live="selectedCategory"
                            class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition-all duration-300 text-slate-900"
                        >
                            <option value="">كل الأصناف</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Company Filter -->
                    <div>
                        <select 
                            wire:model.live="selectedCompany"
                            class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition-all duration-300 text-slate-900"
                        >
                            <option value="">كل الشركات</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sort -->
                    <div>
                        <select 
                            wire:model.live="sortBy"
                            class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition-all duration-300 text-slate-900"
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
                    <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-200 hover:border-blue-300 flex flex-col transform hover:-translate-y-1">
                        <a href="{{ route('client.product.details', $product) }}" class="block relative aspect-square bg-gray-100 overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center text-gray-400 group-hover:scale-110 transition-transform duration-500">
                                    <svg class="w-20 h-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <!-- Badge -->
                            @if($product->stock > 0)
                                <div class="absolute top-3 right-3 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                    متوفر
                                </div>
                            @else
                                <div class="absolute top-3 right-3 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                    غير متوفر
                                </div>
                            @endif
                        </a>
                        <div class="p-5 flex-1 flex flex-col">
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-blue-600 mb-1 uppercase tracking-wide">
                                    {{ $product->category?->name }}
                                </p>
                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors mb-2 line-clamp-2">
                                    <a href="{{ route('client.product.details', $product) }}">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-600 line-clamp-2 mb-3">
                                    {{ $product->description }}
                                </p>
                            </div>
                            <div class="mt-auto pt-4 border-t border-gray-100 space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-xl font-bold text-gray-900">
                                        {{ number_format($product->sale_price, 0) }}
                                    </span>
                                    <span class="text-sm font-normal text-gray-500">ر.س</span>
                                </div>
                                
                                <div class="flex items-center gap-2">
                                    <button
                                        type="button"
                                        wire:click="decrement({{ $product->id }})"
                                        @if(($quantities[$product->id] ?? 1) <= 1) disabled @endif
                                        class="w-10 h-10 bg-red-600 hover:bg-red-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-bold rounded-lg transition-all duration-200 flex items-center justify-center shadow-md hover:shadow-lg hover:scale-110 disabled:hover:scale-100"
                                    >
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                                        </svg>
                                    </button>
                                    
                                    <input
                                        type="number"
                                        wire:model.live="quantities.{{ $product->id }}"
                                        min="1"
                                        max="{{ $product->stock }}"
                                        class="flex-1 h-10 text-center text-lg font-bold text-blue-600 bg-white border-2 border-blue-400 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                                    >
                                    
                                    <button
                                        type="button"
                                        wire:click="increment({{ $product->id }})"
                                        @if(($quantities[$product->id] ?? 1) >= $product->stock) disabled @endif
                                        class="w-10 h-10 bg-green-600 hover:bg-green-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-bold rounded-lg transition-all duration-200 flex items-center justify-center shadow-md hover:shadow-lg hover:scale-110 disabled:hover:scale-100"
                                    >
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </div>
                                
                                <button
                                    wire:click="addToCart({{ $product->id }})"
                                    @if($product->stock <= 0) disabled @endif
                                    class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 disabled:bg-slate-300 disabled:cursor-not-allowed text-white text-sm font-medium rounded-lg transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105 flex items-center justify-center gap-2"
                                >
                                    @if($product->stock > 0)
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        إضافة للسلة
                                    @else
                                        نفذت الكمية
                                    @endif
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-xl border-2 border-dashed border-gray-300">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900">لا توجد منتجات</h3>
                <p class="text-gray-500 mt-1">جرب تغيير معايير البحث</p>
            </div>
        @endif
    </div>
</div>
