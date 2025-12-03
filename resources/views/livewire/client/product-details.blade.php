<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumbs -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 space-x-reverse md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('client.catalog') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">
                        <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                        الرئيسية
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="mr-1 text-sm font-medium text-gray-500 md:mr-2">{{ $product->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-200">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-8">
                <!-- Product Image -->
                <div class="relative bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl overflow-hidden aspect-square group border border-gray-200 shadow-inner">
                    <div class="absolute inset-0 flex items-center justify-center text-gray-400">
                        <svg class="w-32 h-32" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <!-- Stock Badge -->
                    @if($product->stock > 0)
                        <div class="absolute top-4 right-4 bg-green-500 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            متوفر ({{ $product->stock }})
                        </div>
                    @else
                        <div class="absolute top-4 right-4 bg-red-500 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg">
                            غير متوفر
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="flex flex-col justify-center">
                    <!-- Company Badge -->
                    @if($product->company)
                        <a href="{{ route('client.company.details', $product->company) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-700 mb-3 w-fit transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"/>
                            </svg>
                            {{ $product->company->name }}
                        </a>
                    @endif
                    
                    <!-- Category Badge -->
                    @if($product->category)
                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-gray-600 mb-3 w-fit px-3 py-1 bg-gray-100 rounded-full">
                            {{ $product->category->name }}
                        </span>
                    @endif
                    
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                    
                    <!-- SKU -->
                    <p class="text-sm text-gray-500 mb-4">رمز المنتج: <span class="font-mono">{{ $product->sku }}</span></p>
                    
                    <!-- Price -->
                    <div class="flex items-baseline gap-2 mb-6 p-4 bg-blue-50 rounded-xl border-2 border-blue-100 w-fit">
                        <span class="text-4xl font-bold text-blue-600">{{ number_format($product->sale_price, 0) }}</span>
                        <span class="text-xl text-blue-600">ر.س</span>
                    </div>

                    <!-- Description -->
                    <div class="prose prose-sm text-gray-600 mb-8 bg-gray-50 p-4 rounded-xl">
                        <p>{{ $product->description }}</p>
                    </div>

                    @if (session()->has('message'))
                        <div class="mb-4 p-4 rounded-xl bg-green-50 text-green-700 border-2 border-green-200 text-sm flex items-center gap-2">
                            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            {{ session('message') }}
                        </div>
                    @endif

                    <!-- Add to Cart Section -->
                    <div class="flex items-center gap-4">
                        <div class="w-36">
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">الكمية</label>
                            <div class="relative flex items-center">
                                <button type="button" wire:click="decrement" class="bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-r-xl p-3 h-12 focus:ring-blue-500 focus:ring-2 focus:outline-none text-gray-700 transition-colors">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                                    </svg>
                                </button>
                                <input type="text" id="quantity" wire:model="quantity" class="bg-white border-x-0 border-y border-gray-300 h-12 text-center text-gray-900 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block w-full" required>
                                <button type="button" wire:click="increment" class="bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-l-xl p-3 h-12 focus:ring-blue-500 focus:ring-2 focus:outline-none text-gray-700 transition-colors">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2 opacity-0">-</label>
                            <button wire:click="addToCart" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl transition-all duration-200 flex items-center justify-center gap-2 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                إضافة للسلة
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details Table -->
        <div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900">تفاصيل المنتج</h2>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex justify-between py-3 border-b border-gray-100">
                        <dt class="font-semibold text-gray-700">الصنف:</dt>
                        <dd class="text-gray-900">{{ $product->category?->name ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between py-3 border-b border-gray-100">
                        <dt class="font-semibold text-gray-700">الشركة:</dt>
                        <dd class="text-gray-900">{{ $product->company?->name ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between py-3 border-b border-gray-100">
                        <dt class="font-semibold text-gray-700">الكمية المتوفرة:</dt>
                        <dd class="text-gray-900 font-semibold">{{ $product->stock }} قطعة</dd>
                    </div>
                    <div class="flex justify-between py-3 border-b border-gray-100">
                        <dt class="font-semibold text-gray-700">رمز المنتج:</dt>
                        <dd class="text-gray-900 font-mono">{{ $product->sku }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 flex items-center gap-3">
                    <span class="w-1 h-8 bg-blue-600 rounded-full"></span>
                    منتجات مشابهة
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                        <a href="{{ route('client.product.details', $related) }}" class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-200 hover:border-blue-300 transform hover:-translate-y-1">
                            <div class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 group-hover:opacity-90 transition-opacity">
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-2 mb-2">
                                    {{ $related->name }}
                                </h3>
                                <p class="text-xl font-bold text-gray-900">
                                    {{ number_format($related->sale_price, 0) }} <span class="text-sm text-gray-500 font-normal">ر.س</span>
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
