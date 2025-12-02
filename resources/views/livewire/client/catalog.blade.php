<div class="min-h-screen">
    <!-- Hero -->
    <div class="bg-slate-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">مرحباً بك في متجر المخزون</h1>
            <p class="text-lg text-slate-300 mb-8">استعرض أحدث المنتجات واطلب ما تحتاجه بسهولة</p>
            <a href="#products" class="inline-block px-6 py-3 bg-white text-slate-800 rounded-lg font-medium hover:bg-slate-100">
                تصفح المنتجات
            </a>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" id="products">
        <!-- Categories -->
        <section class="mb-12">
            <h2 class="text-2xl font-bold text-slate-800 mb-6">الأصناف</h2>
            <div class="flex flex-wrap gap-3">
                @foreach($categories as $category)
                    <button class="px-4 py-2 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 text-slate-700 font-medium">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
        </section>

        <!-- Products -->
        <section>
            <h2 class="text-2xl font-bold text-slate-800 mb-6">المنتجات</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden hover:shadow-lg transition">
                        <a href="{{ route('client.product.details', $product) }}" class="block aspect-square bg-slate-100 flex items-center justify-center">
                            <svg class="w-16 h-16 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </a>
                        
                        <div class="p-4">
                            <p class="text-xs text-slate-500 mb-1">{{ $product->category?->name }}</p>
                            <h3 class="text-lg font-bold text-slate-800 mb-1">
                                <a href="{{ route('client.product.details', $product) }}" class="hover:text-slate-600">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            <p class="text-xs text-slate-500 mb-3">{{ $product->company?->name }}</p>
                            <p class="text-sm text-slate-600 line-clamp-2 mb-4">{{ $product->description }}</p>
                            
                            <div class="flex items-center justify-between pt-4 border-t border-slate-200">
                                <span class="text-xl font-bold text-slate-800">
                                    {{ number_format($product->sale_price, 2) }} <span class="text-xs text-slate-500">ر.س</span>
                                </span>
                                <button
                                    wire:click="$dispatch('add-to-cart', { productId: {{ $product->id }} })"
                                    class="px-4 py-2 bg-slate-800 text-white rounded-lg hover:bg-slate-700 text-sm font-medium"
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
        </section>
    </main>
</div>
