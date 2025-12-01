<div>
<div class="min-h-screen bg-slate-900 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8 animate-fade-in">
            <h1 class="text-3xl font-bold text-white">سلة المشتريات</h1>
            <a href="{{ route('client.catalog') }}" class="group text-sm font-medium text-cyan-400 hover:text-cyan-300 flex items-center gap-1 transition-all hover:gap-2">
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
                متابعة التسوق
            </a>
        </div>

        @if (! $cart || $cart->items->isEmpty())
            <div class="bg-slate-800 rounded-2xl shadow-lg shadow-black/20 p-12 text-center border border-slate-700 animate-scale-in">
                <div class="w-24 h-24 bg-slate-700/50 rounded-full flex items-center justify-center mx-auto mb-6 animate-pulse">
                    <svg class="w-12 h-12 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-white mb-2">السلة فارغة</h3>
                <p class="text-gray-400 mb-8">لم تقم بإضافة أي منتجات للسلة بعد.</p>
                <a href="{{ route('client.catalog') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-cyan-600 hover:bg-cyan-500 transition-all shadow-lg shadow-cyan-900/20 hover:shadow-cyan-500/40 hover:-translate-y-1">
                    تصفح المنتجات
                </a>
            </div>
        @else
            <div class="bg-slate-800 rounded-2xl shadow-lg shadow-black/20 overflow-hidden border border-slate-700 animate-slide-up">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-700">
                        <thead class="bg-slate-900/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">المنتج</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">الكمية</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">سعر الوحدة</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">الإجمالي</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700 bg-slate-800">
                        @foreach($cart->items as $item)
                            <tr class="hover:bg-slate-700/50 transition-all duration-200 group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-slate-700 rounded-lg flex items-center justify-center text-slate-500 group-hover:bg-slate-600 transition-colors">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="mr-4">
                                            <div class="text-sm font-medium text-white group-hover:text-cyan-400 transition-colors">{{ $item->product?->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $item->product?->category?->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-700 text-white text-sm font-medium group-hover:bg-cyan-500/10 group-hover:text-cyan-400 transition-all">
                                        {{ $item->quantity }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                    {{ number_format($item->unit_price, 2) }} <span class="text-xs">ر.س</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-white">
                                    {{ number_format($item->total_price, 2) }} <span class="text-xs font-normal text-gray-500">ر.س</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="bg-slate-900/50 px-6 py-6 border-t border-slate-700">
                    <div class="flex items-center justify-between mb-6">
                        <span class="text-base font-medium text-gray-300">الإجمالي الكلي</span>
                        <span class="text-2xl font-bold text-white animate-pulse-slow">
                            {{ number_format($cart->total_amount, 2) }} <span class="text-sm font-normal text-gray-400">ر.س</span>
                        </span>
                    </div>
                    <div class="flex justify-end">
                        <button class="group w-full sm:w-auto rounded-xl bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-500 hover:to-green-500 px-8 py-3 text-base font-medium text-white transition-all shadow-lg shadow-emerald-900/20 hover:shadow-emerald-500/40 flex items-center justify-center gap-2 hover:-translate-y-1">
                            <span>إتمام الطلب</span>
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes scale-in {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

@keyframes slide-up {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fade-in 0.5s ease-out;
}

.animate-scale-in {
    animation: scale-in 0.5s ease-out;
}

.animate-slide-up {
    animation: slide-up 0.5s ease-out;
}

.animate-pulse-slow {
    animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>
</div>