<div class="min-h-screen bg-slate-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-slate-900 sm:text-4xl mb-4">
                تصفح حسب الأصناف
            </h1>
            <p class="max-w-2xl text-lg text-slate-500 mx-auto">
                اختر الصنف الذي تبحث عنه لاستعراض المنتجات المتاحة
            </p>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($categories as $category)
                <a href="{{ route('client.catalog') }}?cat={{ $category->id }}" class="group bg-white rounded-xl shadow-sm border border-slate-200 hover:shadow-md hover:border-blue-200 transition-all duration-300 overflow-hidden flex flex-col items-center p-8 text-center">
                    <!-- Icon Placeholder -->
                    <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </div>
                    
                    <h3 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-blue-600 transition-colors">
                        {{ $category->name }}
                    </h3>
                    
                    <span class="text-sm text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                        {{ $category->products_count }} منتج
                    </span>
                </a>
            @endforeach
        </div>

        <div class="mt-12">
            {{ $categories->links() }}
        </div>
    </div>
</div>
