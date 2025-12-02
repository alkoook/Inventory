<div class="min-h-screen bg-slate-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-slate-900 sm:text-4xl mb-4">
                الشركات الموردة
            </h1>
            <p class="max-w-2xl text-lg text-slate-500 mx-auto">
                نفتخر بالتعامل مع نخبة من أفضل الشركات العالمية والمحلية
            </p>
        </div>

        <!-- Companies Grid -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($companies as $company)
                <a href="{{ route('client.company.details', $company) }}" class="group bg-white rounded-xl shadow-sm border border-slate-200 hover:shadow-md hover:border-blue-200 transition-all duration-300 overflow-hidden flex flex-col">
                    <!-- Icon/Logo Placeholder -->
                    <div class="h-40 bg-slate-50 flex items-center justify-center border-b border-slate-100 group-hover:bg-blue-50 transition-colors">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-sm text-slate-400 group-hover:text-blue-600 transition-colors">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                    </div>
                    
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-blue-600 transition-colors">
                            {{ $company->name }}
                        </h3>
                        
                        @if($company->contact_name)
                            <div class="flex items-center gap-2 text-sm text-slate-500 mb-4">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ $company->contact_name }}
                            </div>
                        @endif

                        <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between text-sm">
                            <span class="text-slate-500">
                                {{ $company->products_count ?? 0 }} منتجات
                            </span>
                            <span class="text-blue-600 font-medium group-hover:translate-x-[-4px] transition-transform flex items-center gap-1">
                                عرض التفاصيل
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </span>
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
