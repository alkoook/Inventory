<div class="min-h-screen bg-slate-900 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-3xl font-extrabold text-white sm:text-4xl">
                الشركات الموردة
            </h1>
            <p class="mt-4 max-w-2xl text-xl text-gray-400 mx-auto">
                تصفح قائمة الشركات الموثوقة لدينا
            </p>
        </div>

        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($companies as $company)
                <a href="{{ route('client.company.details', $company) }}" class="group relative block bg-slate-800 rounded-2xl shadow-lg shadow-black/20 hover:shadow-cyan-500/10 transition-all duration-300 overflow-hidden border border-slate-700 hover:border-cyan-500/30">
                    <div class="aspect-w-16 aspect-h-9 bg-slate-700 group-hover:scale-105 transition-transform duration-500">
                        <!-- Placeholder for company logo/image if available, otherwise a gradient or pattern -->
                        <div class="w-full h-48 bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center">
                            <span class="text-4xl grayscale group-hover:grayscale-0 transition-all duration-300">🏢</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-white group-hover:text-cyan-400 transition-colors">
                            {{ $company->name }}
                        </h3>
                        @if($company->description)
                            <p class="mt-2 text-sm text-gray-400 line-clamp-2">
                                {{ $company->description }}
                            </p>
                        @endif
                        <div class="mt-4 flex items-center text-sm text-cyan-400 font-medium opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                            عرض المنتجات
                            <svg class="mr-2 h-4 w-4 rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-12">
            {{ $companies->links() }}
        </div>
    </div>
</div>
