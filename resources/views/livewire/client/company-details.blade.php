<div class="min-h-screen bg-gray-50">
    <!-- Company Hero -->
    <div class="bg-blue-600 border-b border-blue-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="flex flex-col md:flex-row items-center gap-8">
                <div class="w-32 h-32 rounded-2xl bg-white flex items-center justify-center flex-shrink-0 shadow-xl">
                    @if(file_exists(public_path('logo.png')))
                        <img src="{{ asset('logo.png') }}" alt="Logo" class="w-full h-full object-contain p-4">
                    @else
                        <svg class="w-16 h-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    @endif
                </div>
                <div class="text-center md:text-right flex-1">
                    <h1 class="text-4xl font-extrabold text-white sm:text-5xl">
                        {{ $company->name }}
                    </h1>
                    @if($company->description)
                        <p class="mt-4 text-xl text-blue-100 max-w-2xl">
                            {{ $company->description }}
                        </p>
                    @endif
                    <div class="mt-6 flex flex-wrap justify-center md:justify-start gap-4">
                        @if($company->email)
                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium bg-white/10 text-white border border-white/20 backdrop-blur-sm">
                                <svg class="ml-2 -mr-0.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ $company->email }}
                            </span>
                        @endif
                        @if($company->phone)
                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium bg-white/10 text-white border border-white/20 backdrop-blur-sm">
                                <svg class="ml-2 -mr-0.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                {{ $company->phone }}
                            </span>
                        @endif
                        @if($company->address)
                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium bg-white/10 text-white border border-white/20 backdrop-blur-sm">
                                <svg class="ml-2 -mr-0.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $company->address }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 flex items-center gap-3">
            <span class="w-1 h-8 bg-blue-600 rounded-full"></span>
            منتجات الشركة
        </h2>
        
        @if($products->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                @foreach($products as $product)
                    <div class="group bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-200 hover:border-blue-300 flex flex-col transform hover:-translate-y-1">
                        <a href="{{ route('client.product.details', $product) }}" class="block relative aspect-square bg-gray-100 overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center text-gray-400 group-hover:scale-110 transition-transform duration-500">
                                    <svg class="w-12 h-12 sm:w-16 sm:h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <!-- Badge -->
                            @if($product->stock > 0)
                                <div class="absolute top-2 right-2 bg-green-500 text-white text-[10px] sm:text-xs font-bold px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-full shadow-lg">
                                    متوفر ({{ $product->stock }})
                                </div>
                            @else
                                <div class="absolute top-2 right-2 bg-red-500 text-white text-[10px] sm:text-xs font-bold px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-full shadow-lg">
                                    غير متوفر
                                </div>
                            @endif
                        </a>
                        <div class="p-3 sm:p-4 flex-1 flex flex-col">
                            <div class="flex-1 mb-2">
                                <p class="text-[10px] sm:text-xs font-semibold text-blue-600 mb-1 uppercase tracking-wide line-clamp-1">
                                    {{ $product->category?->name }}
                                </p>
                                <h3 class="text-sm sm:text-base font-bold text-gray-900 group-hover:text-blue-600 transition-colors mb-1 line-clamp-2 min-h-[2.5rem]">
                                    <a href="{{ route('client.product.details', $product) }}">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                            </div>
                            <div class="mt-auto pt-2 sm:pt-3 border-t border-gray-100 space-y-2">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-base sm:text-lg font-bold text-gray-900">
                                        {{ number_format($product->sale_price, 0) }}
                                    </span>
                                    <span class="text-xs sm:text-sm font-normal text-gray-500">USD</span>
                                </div>
                                <div class="text-xs text-gray-600 text-center">
                                    الكمية المتوفرة: <span class="font-bold text-blue-600">{{ $product->stock }}</span>
                                </div>
                                
                                <div class="flex items-center gap-1.5 sm:gap-2">
                                    <button
                                        type="button"
                                        wire:click="decrement({{ $product->id }})"
                                        @if(($quantities[$product->id] ?? 1) <= 1) disabled @endif
                                        class="w-8 h-8 sm:w-10 sm:h-10 bg-red-600 hover:bg-red-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-bold rounded-lg transition-all duration-200 flex items-center justify-center shadow-md hover:shadow-lg hover:scale-110 disabled:hover:scale-100"
                                    >
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                                        </svg>
                                    </button>
                                    
                                    <input
                                        type="number"
                                        wire:model.live="quantities.{{ $product->id }}"
                                        min="1"
                                        max="{{ $product->stock }}"
                                        class="flex-1 h-8 sm:h-10 text-center text-sm sm:text-base font-bold text-blue-600 bg-white border-2 border-blue-400 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                                    >
                                    
                                    <button
                                        type="button"
                                        wire:click="increment({{ $product->id }})"
                                        @if(($quantities[$product->id] ?? 1) >= $product->stock) disabled @endif
                                        class="w-8 h-8 sm:w-10 sm:h-10 bg-green-600 hover:bg-green-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-bold rounded-lg transition-all duration-200 flex items-center justify-center shadow-md hover:shadow-lg hover:scale-110 disabled:hover:scale-100"
                                    >
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </div>
                                
                                <button
                                    wire:click="addToCart({{ $product->id }})"
                                    @if($product->stock <= 0) disabled @endif
                                    class="w-full px-3 sm:px-4 py-1.5 sm:py-2 bg-blue-600 hover:bg-blue-700 disabled:bg-slate-300 disabled:cursor-not-allowed text-white text-xs sm:text-sm font-medium rounded-lg transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105 flex items-center justify-center gap-1.5 sm:gap-2"
                                >
                                    @if($product->stock > 0)
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span class="hidden sm:inline">إضافة للسلة</span>
                                        <span class="sm:hidden">إضافة</span>
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
            <div class="text-center py-16 bg-white rounded-2xl border-2 border-dashed border-gray-300">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <h3 class="mt-4 text-lg font-semibold text-gray-900">لا توجد منتجات</h3>
                <p class="mt-2 text-sm text-gray-600">لم تقم هذه الشركة بإضافة أي منتجات بعد.</p>
            </div>
        @endif
    </div>
</div>
