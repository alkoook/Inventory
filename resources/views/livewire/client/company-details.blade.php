<div class="min-h-screen bg-slate-900">
    <!-- Company Hero -->
    <div class="bg-slate-800 border-b border-slate-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="flex flex-col md:flex-row items-center gap-8">
                <div class="w-32 h-32 rounded-2xl bg-gradient-to-br from-slate-700 to-slate-600 flex items-center justify-center flex-shrink-0 shadow-inner">
                    <span class="text-5xl grayscale">🏢</span>
                </div>
                <div class="text-center md:text-right flex-1">
                    <h1 class="text-3xl font-extrabold text-white sm:text-4xl">
                        {{ $company->name }}
                    </h1>
                    @if($company->description)
                        <p class="mt-4 text-xl text-gray-400 max-w-2xl">
                            {{ $company->description }}
                        </p>
                    @endif
                    <div class="mt-6 flex flex-wrap justify-center md:justify-start gap-4">
                        @if($company->email)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-slate-700 text-cyan-400 border border-slate-600">
                                <svg class="ml-2 -mr-0.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ $company->email }}
                            </span>
                        @endif
                        @if($company->phone)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-slate-700 text-emerald-400 border border-slate-600">
                                <svg class="ml-2 -mr-0.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                {{ $company->phone }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-2xl font-bold text-white mb-8">منتجات الشركة</h2>
        
        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="group bg-slate-800 rounded-xl shadow-lg shadow-black/20 hover:shadow-cyan-500/10 transition-all duration-300 overflow-hidden border border-slate-700 hover:border-cyan-500/30 flex flex-col">
                        <a href="{{ route('client.product.details', $product) }}" class="block relative aspect-w-1 aspect-h-1 bg-slate-700 overflow-hidden">
                            <div class="absolute inset-0 flex items-center justify-center text-slate-600 group-hover:scale-110 transition-transform duration-500">
                                <svg class="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </a>
                        <div class="p-4 flex-1 flex flex-col">
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-white group-hover:text-cyan-400 transition-colors mb-1">
                                    <a href="{{ route('client.product.details', $product) }}">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-400 line-clamp-2 mb-3">
                                    {{ $product->description }}
                                </p>
                            </div>
                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-slate-700">
                                <span class="text-lg font-bold text-white">
                                    {{ number_format($product->sale_price, 2) }} <span class="text-xs font-normal text-gray-500">ر.س</span>
                                </span>
                                <button
                                    wire:click="$dispatch('add-to-cart', { productId: {{ $product->id }} })"
                                    class="rounded-lg bg-cyan-900/30 px-3 py-2 text-sm font-medium text-cyan-400 hover:bg-cyan-900/50 border border-cyan-900/50 transition-colors"
                                >
                                    إضافة
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
            <div class="text-center py-12 bg-slate-800 rounded-xl border border-dashed border-slate-600">
                <svg class="mx-auto h-12 w-12 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-white">لا توجد منتجات</h3>
                <p class="mt-1 text-sm text-gray-400">لم تقم هذه الشركة بإضافة أي منتجات بعد.</p>
            </div>
        @endif
    </div>
</div>
