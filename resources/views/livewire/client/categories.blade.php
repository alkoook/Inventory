<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
            <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-red-600 sm:text-5xl mb-4 transform-3d">
                تصفح حسب الأصناف
            </h1>
            <p class="max-w-2xl text-lg text-slate-600 mx-auto">
                اختر الصنف الذي تبحث عنه لاستعراض المنتجات المتاحة
            </p>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
            @foreach($categories as $category)
                <a href="{{ route('client.catalog') }}?cat={{ $category->id }}" 
                   class="group bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-200 hover:border-red-300 flex flex-col transform hover:-translate-y-1">
                    <div class="aspect-square bg-gray-100 overflow-hidden flex items-center justify-center">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" 
                                 alt="{{ $category->name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-20 h-20 bg-red-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="text-base font-bold text-gray-900 group-hover:text-red-600 transition-colors mb-1">
                            {{ $category->name }}
                        </h3>
                        <span class="text-xs text-gray-500">
                            {{ $category->products_count ?? 0 }} منتج
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
