<div class="min-h-screen bg-slate-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="relative h-48 bg-blue-600 flex items-center justify-center overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-blue-800 opacity-90"></div>
                <div class="relative z-10 text-center">
                    <h1 class="text-4xl font-bold text-white mb-2">من نحن</h1>
                    <p class="text-blue-100 text-lg">تعرف على قصتنا ورؤيتنا</p>
                </div>
                <!-- Decorative circles -->
                <div class="absolute top-0 left-0 w-32 h-32 bg-white opacity-10 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-48 h-48 bg-white opacity-10 rounded-full translate-x-1/3 translate-y-1/3"></div>
            </div>
            
            <div class="p-8 sm:p-12">
                <div class="prose prose-lg prose-slate max-w-none">
                    <p class="text-slate-600 leading-relaxed whitespace-pre-line">
                        {{ $aboutUs }}
                    </p>
                </div>

                <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8 text-center border-t border-slate-100 pt-12">
                    <div>
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-900 mb-2">جودة مضمونة</h3>
                        <p class="text-sm text-slate-500">نضمن لك أفضل المنتجات من موردين موثوقين</p>
                    </div>
                    <div>
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-900 mb-2">سرعة التوصيل</h3>
                        <p class="text-sm text-slate-500">نصل إليك أينما كنت بأسرع وقت ممكن</p>
                    </div>
                    <div>
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-900 mb-2">دعم متواصل</h3>
                        <p class="text-sm text-slate-500">فريق دعم فني جاهز لخدمتكم على مدار الساعة</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
