<div class="min-h-screen bg-slate-900 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumbs -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 space-x-reverse md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('client.catalog') }}" class="inline-flex items-center text-sm font-medium text-gray-400 hover:text-cyan-400">
                        الرئيسية
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-600 mx-1 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="mr-1 text-sm font-medium text-gray-500 md:mr-2">{{ $product->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-slate-800 rounded-2xl shadow-lg shadow-black/20 overflow-hidden border border-slate-700">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                <!-- Product Image -->
                <div class="relative bg-slate-900 rounded-xl overflow-hidden aspect-square group border border-slate-700">
                    <div class="absolute inset-0 flex items-center justify-center text-slate-700">
                        <svg class="w-24 h-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <!-- Actual image would go here -->
                </div>

                <!-- Product Info -->
                <div class="flex flex-col justify-center">
                    @if($product->company)
                        <a href="{{ route('client.company.details', $product->company) }}" class="text-sm font-medium text-cyan-400 hover:text-cyan-300 mb-2">
                            {{ $product->company->name }}
                        </a>
                    @endif
                    
                    <h1 class="text-3xl font-bold text-white mb-4">{{ $product->name }}</h1>
                    
                    <div class="flex items-baseline mb-6">
                        <span class="text-3xl font-bold text-white">{{ number_format($product->sale_price, 2) }}</span>
                        <span class="text-lg text-gray-400 mr-2">ر.س</span>
                    </div>

                    <div class="prose prose-sm text-gray-400 mb-8">
                        <p>{{ $product->description }}</p>
                    </div>

                    @if (session()->has('message'))
                        <div class="mb-4 p-4 rounded-lg bg-emerald-900/30 text-emerald-400 border border-emerald-900/50 text-sm">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="flex items-center gap-4">
                        <div class="w-32">
                            <label for="quantity" class="sr-only">الكمية</label>
                            <div class="relative flex items-center max-w-[8rem]">
                                <button type="button" wire:click="$decrement('quantity')" class="bg-slate-700 hover:bg-slate-600 border border-slate-600 rounded-r-lg p-3 h-11 focus:ring-slate-700 focus:ring-2 focus:outline-none text-white">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                                    </svg>
                                </button>
                                <input type="text" id="quantity" wire:model="quantity" class="bg-slate-900 border-x-0 border-slate-600 h-11 text-center text-white text-sm focus:ring-cyan-500 focus:border-cyan-500 block w-full py-2.5" required>
                                <button type="button" wire:click="$increment('quantity')" class="bg-slate-700 hover:bg-slate-600 border border-slate-600 rounded-l-lg p-3 h-11 focus:ring-slate-700 focus:ring-2 focus:outline-none text-white">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <button wire:click="addToCart" class="flex-1 bg-cyan-600 hover:bg-cyan-500 text-white font-bold py-3 px-8 rounded-xl transition-colors duration-200 flex items-center justify-center gap-2 shadow-lg shadow-cyan-900/20 hover:shadow-cyan-500/40">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            إضافة للسلة
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-white mb-8">منتجات مشابهة</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                        <a href="{{ route('client.product.details', $related) }}" class="group bg-slate-800 rounded-xl shadow-lg shadow-black/20 hover:shadow-cyan-500/10 transition-all duration-300 overflow-hidden border border-slate-700 hover:border-cyan-500/30">
                            <div class="aspect-w-1 aspect-h-1 bg-slate-700 group-hover:opacity-90 transition-opacity">
                                <div class="w-full h-48 flex items-center justify-center text-slate-600">
                                    <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="text-sm font-medium text-white group-hover:text-cyan-400 transition-colors truncate">
                                    {{ $related->name }}
                                </h3>
                                <p class="mt-1 text-lg font-bold text-white">
                                    {{ number_format($related->sale_price, 2) }} <span class="text-xs text-gray-500 font-normal">ر.س</span>
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
