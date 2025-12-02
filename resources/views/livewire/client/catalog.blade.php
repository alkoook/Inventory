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
                            </div>
                        </div>
                    </div>
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
</div>
