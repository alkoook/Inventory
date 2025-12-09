<div>
    <div class="max-w-2xl mx-auto">
        <div class="bg-slate-800 rounded-2xl border border-slate-700/50 shadow-xl p-6">
            <h2 class="text-xl font-bold mb-6 text-gray-100">رفض الطلب</h2>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-300 mb-2">سبب الرفض *</label>
                <textarea 
                    wire:model="rejected_reason"
                    rows="4"
                    class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 rounded-xl p-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                    placeholder="أدخل سبب رفض الطلب..."></textarea>
                @error('rejected_reason') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-700/50">
                <button 
                    wire:click="reject"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-medium transition-all shadow-lg hover:shadow-xl">
                    تأكيد الرفض
                </button>
                <a href="{{ route('admin.orders.view', $cartId) }}" 
                   class="bg-slate-700 hover:bg-slate-600 text-gray-100 px-6 py-3 rounded-xl font-medium transition-all">
                    إلغاء
                </a>
            </div>
        </div>
    </div>
</div>
