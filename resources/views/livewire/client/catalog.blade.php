<div class="min-h-screen bg-slate-900">
    <!-- Hero Section -->
    <div class="relative bg-slate-900 overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-slate-900 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-right">
                        <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                            <span class="block xl:inline">مرحباً بك في</span>
                            <span class="block text-cyan-400 xl:inline">بوابة الزبون</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-400 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            استعرض أحدث المنتجات من أفضل الشركات الموردة. اطلب ما تحتاجه بسهولة وسرعة.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="#products" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-cyan-600 hover:bg-cyan-700 md:py-4 md:text-lg md:px-10 transition-all hover:shadow-lg hover:shadow-cyan-500/30 hover:-translate-y-1">
                                    تصفح المنتجات
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:mr-3">
                                <a href="{{ route('client.companies') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-cyan-400 bg-slate-800 hover:bg-slate-700 md:py-4 md:text-lg md:px-10 transition-all">
                                    الشركات
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:left-0 lg:w-1/2 bg-slate-900 flex items-center justify-center">
            <div class="text-9xl opacity-5 select-none text-white">📦</div>
        </div>
    </div>

    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12" id="products">
        <section class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-white">الأصناف</h2>
            </div>
            <div class="flex flex-wrap gap-3">
                @foreach($categories as $category)
                    <button class="group relative inline-flex items-center justify-center px-6 py-2 overflow-hidden font-medium transition-all bg-slate-800 border border-slate-700 rounded-full hover:bg-slate-700 hover:border-cyan-500/50 cursor-pointer shadow-sm hover:shadow-md">
                        <span class="w-full h-full absolute inset-0 bg-gradient-to-br from-cyan-500/10 to-blue-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                        <span class="relative text-gray-300 group-hover:text-cyan-400 transition-colors">{{ $category->name }}</span>
                    </button>
                @endforeach
            </div>
        </section>

        <section>
            <h2 class="mb-8 text-2xl font-bold text-white">أحدث المنتجات</h2>
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach($products as $product)
                    <div class="group bg-slate-800 rounded-2xl shadow-lg shadow-black/20 hover:shadow-cyan-500/10 transition-all duration-300 overflow-hidden border border-slate-700 hover:border-cyan-500/30 flex flex-col">
                        <a href="{{ route('client.product.details', $product) }}" class="block relative aspect-w-1 aspect-h-1 bg-slate-700 overflow-hidden">
                            <div class="absolute inset-0 flex items-center justify-center text-slate-600 group-hover:scale-110 transition-transform duration-500">
                                <svg class="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300"></div>
                        </a>
                        
                        <div class="p-5 flex-1 flex flex-col">
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-xs font-medium text-cyan-400 mb-1">
                                            {{ $product->category?->name }}
                                        </p>
                                        <h3 class="text-lg font-bold text-white mb-1 group-hover:text-cyan-400 transition-colors">
                                            <a href="{{ route('client.product.details', $product) }}">
                                                {{ $product->name }}
                                            </a>
                                        </h3>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mb-3">
                                    بواسطة <a href="{{ $product->company ? route('client.company.details', $product->company) : '#' }}" class="hover:underline hover:text-cyan-400">{{ $product->company?->name }}</a>
                                </p>
                                <p class="text-sm text-gray-400 line-clamp-2 mb-4">
                                    {{ $product->description }}
                                </p>
                            </div>
                            
                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-slate-700">
                                <span class="text-xl font-bold text-white">
                                    {{ number_format($product->sale_price, 2) }} <span class="text-xs font-normal text-gray-500">ر.س</span>
                                </span>
                                <button
                                    wire:click="$dispatch('add-to-cart', { productId: {{ $product->id }} })"
                                    class="rounded-xl bg-cyan-600 px-4 py-2 text-sm font-medium text-white hover:bg-cyan-500 shadow-lg shadow-cyan-900/20 hover:shadow-cyan-500/40 transition-all active:scale-95"
                                >
                                    إضافة
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $products->links() }}
            </div>
        </section>
    </main>
</div>
