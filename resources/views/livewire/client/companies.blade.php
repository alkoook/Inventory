<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-blue-600 sm:text-5xl mb-4 transform-3d">
                شركاؤنا
                </h1>
            <p class="max-w-2xl text-lg text-slate-600 mx-auto">
                    تعرف على الشركات الموردة لدينا واستعرض منتجاتها المميزة
                </p>
    </div>

        <!-- Search Section -->
        <div class="mb-8 max-w-md mx-auto">
            <div class="relative">
                <input 
                    wire:model.live="search" 
                    type="text" 
                    placeholder="ابحث عن شركة..." 
                    class="w-full bg-white border-2 border-slate-200 text-slate-900 text-base rounded-xl focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 block p-4 pl-12 shadow-md hover:shadow-lg transition-all"
                >
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Companies Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
            @forelse($companies as $company)
                <a href="{{ route('client.company.details', $company) }}" 
                   class="group bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-200 hover:border-blue-300 flex flex-col transform hover:-translate-y-1">
                    <div class="aspect-square bg-blue-600 overflow-hidden flex items-center justify-center">
                        @if($company->image)
                            <img src="{{ asset('storage/' . $company->image) }}" 
                                 alt="{{ $company->name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                <svg class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="text-base font-bold text-gray-900 group-hover:text-blue-600 transition-colors mb-1">
                            {{ $company->name }}
                        </h3>
                        @if($company->contact_name)
                            <p class="text-xs text-gray-500">{{ $company->contact_name }}</p>
                        @endif
                    </div>
                </a>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-12 bg-white rounded-xl border border-slate-200">
                        <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-slate-900">لا توجد شركات</h3>
                        <p class="mt-1 text-sm text-slate-500">لم يتم العثور على أي شركات.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
