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

        <!-- Companies Carousel with Navigation -->
        <div x-data="{
            currentIndex: 0,
            itemsPerView: 3,
            companies: @js($companies->toArray()),
            get maxIndex() {
                return Math.max(0, this.companies.length - this.itemsPerView);
            },
            next() {
                if (this.currentIndex < this.maxIndex) {
                    this.currentIndex++;
                } else {
                    this.currentIndex = 0;
                }
            },
            prev() {
                if (this.currentIndex > 0) {
                    this.currentIndex--;
                } else {
                    this.currentIndex = this.maxIndex;
                }
            },
            init() {
                setInterval(() => {
                    this.next();
                }, 4000);
            }
        }" class="relative">
            <!-- Navigation Buttons -->
            <button @click="prev()" 
                    class="absolute right-0 top-1/2 -translate-y-1/2 z-20 bg-white/90 backdrop-blur-sm border-2 border-blue-300 text-blue-700 p-3 rounded-full shadow-lg hover:shadow-xl hover:scale-110 hover:bg-blue-50 hover:border-blue-400 hover:text-blue-600 transition-all duration-300 transform-3d">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button @click="next()" 
                    class="absolute left-0 top-1/2 -translate-y-1/2 z-20 bg-white/90 backdrop-blur-sm border-2 border-blue-300 text-blue-700 p-3 rounded-full shadow-lg hover:shadow-xl hover:scale-110 hover:bg-blue-50 hover:border-blue-400 hover:text-blue-600 transition-all duration-300 transform-3d">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            <!-- Companies Container -->
            <div class="overflow-hidden px-12">
                <div class="flex transition-transform duration-500 ease-in-out" 
                     :style="'transform: translateX(-' + (currentIndex * (100 / itemsPerView)) + '%)'">
                    @forelse($companies as $index => $company)
                        <div class="min-w-[33.333%] px-3 flex-shrink-0">
                            <a href="{{ route('client.company.details', $company) }}" 
                               class="group block card-3d" wire:ignore>
                                <div class="bg-white rounded-2xl shadow-md border-2 border-blue-200 hover:border-blue-400 hover:shadow-xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-2 overflow-hidden">
                                    <!-- Company Image/Header -->
                                    <div class="relative h-40 bg-blue-600 overflow-hidden">
                                        @if($company->image)
                                            <img src="{{ asset('storage/' . $company->image) }}" 
                                                 alt="{{ $company->name }}"
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        @else
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-24 h-24 bg-white/20 backdrop-blur-sm rounded-2xl shadow-lg flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                                @if(file_exists(public_path('logo.png')))
                                    <img src="{{ asset('logo.png') }}" alt="Logo" class="w-full h-full object-contain p-4">
                                @else
                                    <svg class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                @endif
                            </div>
                        </div>
                                        @endif
                    </div>
                    
                    <!-- Company Info -->
                    <div class="p-6">
                                        <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-blue-600 transition-colors text-center">
                            {{ $company->name }}
                        </h3>
                        
                                        @if($company->contact_name)
                                            <p class="text-sm text-slate-600 mb-4 text-center">
                                                {{ $company->contact_name }}
                            </p>
                        @endif
                        
                        <div class="space-y-2 mb-4">
                            @if($company->email)
                                                <div class="flex items-center gap-2 text-sm text-slate-600">
                                                    <svg class="w-4 h-4 text-indigo-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span class="truncate">{{ $company->email }}</span>
                                </div>
                            @endif
                            
                            @if($company->phone)
                                                <div class="flex items-center gap-2 text-sm text-slate-600">
                                                    <svg class="w-4 h-4 text-indigo-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span>{{ $company->phone }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- View Products Button -->
                                        <div class="pt-4 border-t border-slate-200">
                                            <div class="flex items-center justify-center text-indigo-600 font-semibold group-hover:text-indigo-700">
                                <span>عرض المنتجات</span>
                                <svg class="w-5 h-5 mr-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                                            </div>
                            </div>
                        </div>
                    </div>
                </a>
                        </div>
            @empty
                        <div class="col-span-full w-full">
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
    </div>
</div>
