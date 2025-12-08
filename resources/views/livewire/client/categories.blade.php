<div class="min-h-screen bg-gradient-to-br from-red-50 via-white to-red-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
            <div class="text-center mb-12">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-red-600 to-red-500 bg-clip-text text-transparent sm:text-5xl mb-4 transform-3d">
                تصفح حسب الأصناف
            </h1>
            <p class="max-w-2xl text-lg text-slate-600 mx-auto">
                اختر الصنف الذي تبحث عنه لاستعراض المنتجات المتاحة
            </p>
        </div>

        <!-- Categories Carousel with Navigation -->
        <div x-data="{
            currentIndex: 0,
            itemsPerView: 4,
            categories: @js($categories->toArray()),
            get maxIndex() {
                return Math.max(0, this.categories.length - this.itemsPerView);
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
                    class="absolute right-0 top-1/2 -translate-y-1/2 z-20 bg-white/90 backdrop-blur-sm border-2 border-red-300 text-red-700 p-3 rounded-full shadow-lg hover:shadow-xl hover:scale-110 hover:bg-red-50 hover:border-red-400 hover:text-red-600 transition-all duration-300 transform-3d">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button @click="next()" 
                    class="absolute left-0 top-1/2 -translate-y-1/2 z-20 bg-white/90 backdrop-blur-sm border-2 border-red-300 text-red-700 p-3 rounded-full shadow-lg hover:shadow-xl hover:scale-110 hover:bg-red-50 hover:border-red-400 hover:text-red-600 transition-all duration-300 transform-3d">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            <!-- Categories Container -->
            <div class="overflow-hidden px-12">
                <div class="flex transition-transform duration-500 ease-in-out" 
                     :style="'transform: translateX(-' + (currentIndex * (100 / itemsPerView)) + '%)'">
                    @foreach($categories as $index => $category)
                        <div class="min-w-[25%] px-3 flex-shrink-0">
                            <a href="{{ route('client.catalog') }}?cat={{ $category->id }}" 
                               class="group block card-3d" wire:ignore>
                                <div class="bg-white rounded-2xl shadow-md border-2 border-slate-200 hover:border-indigo-400 hover:shadow-xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-2 overflow-hidden flex flex-col items-center p-6 text-center">
                                    <!-- Image or Icon -->
                                    @if($category->image)
                                        <div class="w-24 h-24 mb-4 rounded-xl overflow-hidden shadow-lg group-hover:shadow-xl transition-all duration-300 transform group-hover:rotate-3 group-hover:scale-110">
                                            <img src="{{ asset('storage/' . $category->image) }}" 
                                                 alt="{{ $category->name }}"
                                                 class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <div class="w-24 h-24 bg-gradient-to-br from-indigo-500 to-blue-500 rounded-xl flex items-center justify-center text-white mb-4 shadow-lg group-hover:shadow-xl transition-all duration-300 transform group-hover:rotate-3 group-hover:scale-110 group">
                                            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-indigo-600 transition-colors">
                                        {{ $category->name }}
                                    </h3>
                                    
                                    <span class="text-sm text-slate-600 bg-slate-100 px-3 py-1 rounded-full">
                                        {{ $category->products_count ?? 0 }} منتج
                                    </span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
