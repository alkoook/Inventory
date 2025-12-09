
<div class="min-h-screen bg-gray-50">
    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
             class="fixed top-20 left-4 right-4 z-50 bg-green-600 text-white px-6 py-3 rounded-xl shadow-xl animate-slide-down">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
             class="fixed top-20 left-4 right-4 z-50 bg-red-600 text-white px-6 py-3 rounded-xl shadow-xl animate-slide-down">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Hero Section with Search -->
        <div class="text-center mb-12 animate-fade-in">
            <h1 class="text-5xl md:text-6xl font-bold mb-6 fade-in transform hover:scale-105 transition-transform duration-500 text-slate-800">
                مرحباً بك في <span class="text-blue-600">{{ \App\Models\Setting::get('site_name', 'متجرنا') }}</span>
            </h1>
            <p class="text-xl text-slate-600 max-w-2xl mx-auto mb-10 fade-in">
                اكتشف مجموعة واسعة من المنتجات عالية الجودة من أفضل الشركات
            </p>
            
            <!-- Search Bar -->
            <div class="max-w-2xl mx-auto mb-8 fade-in">
                <form action="{{ route('client.catalog') }}" method="GET" class="relative transform hover:scale-105 transition-transform duration-300">
                    <input type="text" 
                           name="q" 
                           placeholder="ابحث عن منتج..." 
                           class="w-full px-6 py-5 pr-16 rounded-xl border-2 border-blue-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-300 outline-none transition-all shadow-md hover:shadow-lg text-slate-900 placeholder-slate-400 bg-white">
                    <button type="submit" 
                            class="absolute left-3 top-1/2 -translate-y-1/2 bg-blue-600 hover:bg-blue-700 text-white p-3.5 rounded-lg transition-all shadow-md hover:shadow-lg hover:scale-110 transform duration-300">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Categories Carousel - Auto Scroll Right to Left -->
        <div class="mb-16 fade-in">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-red-600">الأصناف</h2>
                <a href="{{ route('client.categories') }}" class="text-red-600 hover:text-red-700 font-semibold transition-all duration-300 transform hover:scale-110 flex items-center gap-2">
                    عرض الكل <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            
            <div class="relative bg-white rounded-xl shadow-lg p-6 overflow-hidden border-2 border-red-200">
                <div class="flex gap-4 animate-scroll-right" style="animation: scrollRight 30s linear infinite;">
                    @foreach($categories as $category)
                        <div class="flex-shrink-0 w-48">
                            <a href="{{ route('client.catalog') }}?cat={{ $category->id }}" 
                               class="block group card-3d">
                                <div class="bg-slate-50 rounded-xl p-6 text-center hover:shadow-lg transition-all duration-300 transform hover:scale-105 border border-slate-200">
                                    @if($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" 
                                             alt="{{ $category->name }}"
                                             class="w-20 h-20 mx-auto mb-4 rounded-lg object-cover shadow-md group-hover:shadow-lg transition-all duration-300">
                                    @else
                                        <div class="w-20 h-20 mx-auto mb-4 bg-slate-200 rounded-lg flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-300">
                                            <svg class="w-10 h-10 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <h3 class="text-base font-semibold text-slate-800 group-hover:text-slate-900 transition-colors">
                                        {{ $category->name }}
                                    </h3>
                                </div>
                            </a>
                        </div>
                    @endforeach
                    <!-- Duplicate for seamless loop -->
                    @foreach($categories as $category)
                        <div class="flex-shrink-0 w-48">
                            <a href="{{ route('client.catalog') }}?cat={{ $category->id }}" 
                               class="block group card-3d">
                                <div class="bg-slate-50 rounded-xl p-6 text-center hover:shadow-lg transition-all duration-300 transform hover:scale-105 border border-slate-200">
                                    @if($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" 
                                             alt="{{ $category->name }}"
                                             class="w-20 h-20 mx-auto mb-4 rounded-lg object-cover shadow-md group-hover:shadow-lg transition-all duration-300">
                                    @else
                                        <div class="w-20 h-20 mx-auto mb-4 bg-slate-200 rounded-lg flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-300">
                                            <svg class="w-10 h-10 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <h3 class="text-base font-semibold text-slate-800 group-hover:text-slate-900 transition-colors">
                                        {{ $category->name }}
                                    </h3>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Companies Carousel - Auto Scroll Left to Right -->
        <div class="mb-16 fade-in">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-blue-600">شركاؤنا</h2>
                <a href="{{ route('client.companies') }}" class="text-blue-600 hover:text-blue-700 font-semibold transition-all duration-300 transform hover:scale-110 flex items-center gap-2">
                    عرض الكل <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            
            <div class="relative bg-white rounded-xl shadow-lg p-6 overflow-hidden border-2 border-blue-200">
                <div class="flex gap-4 animate-scroll-left" style="animation: scrollLeft 30s linear infinite;">
                    @foreach($companies as $company)
                        <div class="flex-shrink-0 w-48">
                            <a href="{{ route('client.company.details', $company) }}" 
                               class="block group card-3d">
                                <div class="bg-slate-50 rounded-xl p-6 text-center hover:shadow-lg transition-all duration-300 transform hover:scale-105 border border-slate-200">
                                    @if($company->image)
                                        <img src="{{ asset('storage/' . $company->image) }}" 
                                             alt="{{ $company->name }}"
                                             class="w-20 h-20 mx-auto mb-4 rounded-lg object-cover shadow-md group-hover:shadow-lg transition-all duration-300">
                                    @else
                                        <div class="w-20 h-20 mx-auto mb-4 bg-slate-200 rounded-lg flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-300">
                                            <span class="text-2xl font-bold text-slate-600">{{ substr($company->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <h3 class="text-base font-semibold text-slate-800 group-hover:text-slate-900 transition-colors">
                                        {{ $company->name }}
                                    </h3>
                                    @if($company->contact_name)
                                        <p class="text-xs text-slate-500 mt-1">{{ $company->contact_name }}</p>
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endforeach
                    <!-- Duplicate for seamless loop -->
                    @foreach($companies as $company)
                        <div class="flex-shrink-0 w-48">
                            <a href="{{ route('client.company.details', $company) }}" 
                               class="block group card-3d">
                                <div class="bg-slate-50 rounded-xl p-6 text-center hover:shadow-lg transition-all duration-300 transform hover:scale-105 border border-slate-200">
                                    @if($company->image)
                                        <img src="{{ asset('storage/' . $company->image) }}" 
                                             alt="{{ $company->name }}"
                                             class="w-20 h-20 mx-auto mb-4 rounded-lg object-cover shadow-md group-hover:shadow-lg transition-all duration-300">
                                    @else
                                        <div class="w-20 h-20 mx-auto mb-4 bg-slate-200 rounded-lg flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-300">
                                            <span class="text-2xl font-bold text-slate-600">{{ substr($company->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <h3 class="text-base font-semibold text-slate-800 group-hover:text-slate-900 transition-colors">
                                        {{ $company->name }}
                                    </h3>
                                    @if($company->contact_name)
                                        <p class="text-xs text-slate-500 mt-1">{{ $company->contact_name }}</p>
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Latest Products Section -->
        <div class="mb-12 fade-in">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-blue-600">أحدث المنتجات</h2>
                <a href="{{ route('client.catalog') }}" class="text-blue-600 hover:text-blue-700 font-semibold transition-all duration-300 transform hover:scale-110 flex items-center gap-2">
                    عرض الكل <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            
            @if($latestProducts->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($latestProducts as $index => $product)
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
            @else
                <div class="text-center py-12 bg-white rounded-xl border border-dashed border-slate-300">
                    <svg class="w-16 h-16 text-slate-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <h3 class="text-lg font-medium text-slate-900">لا توجد منتجات حالياً</h3>
                    <p class="text-slate-500 mt-1">سيتم إضافة منتجات جديدة قريباً</p>
                </div>
            @endif
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px) translateZ(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0) translateZ(0);
            }
        }
        
        @keyframes slide-down {
            from {
                opacity: 0;
                transform: translateY(-100%) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        
        @keyframes scrollRight {
            from {
                transform: translateX(0);
            }
            to {
                transform: translateX(-50%);
            }
        }
        
        @keyframes scrollLeft {
            from {
                transform: translateX(-50%);
            }
            to {
                transform: translateX(0);
            }
        }
        
        .animate-fade-in {
            animation: fade-in 0.6s ease-out;
        }
        
        .animate-slide-down {
            animation: slide-down 0.4s ease-out;
        }

        .fade-in {
            animation: fade-in 0.6s ease-out;
        }
        
        .card-3d {
            transform-style: preserve-3d;
            transition: transform 0.3s ease;
        }
        
        .card-3d:hover {
            transform: translateY(-4px) rotateX(2deg) rotateY(-2deg) translateZ(10px);
        }
    </style>
</div>

