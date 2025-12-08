<div>
    <div class="max-w-2xl mx-auto">
        <div class="bg-slate-800 rounded-2xl border border-slate-700/50 shadow-xl p-6">
            <h2 class="text-xl font-bold mb-6 text-gray-100">الموافقة على الطلب</h2>
            
            <p class="text-gray-400 mb-6">سيتم إنشاء فاتورة مبيعات وتحديث المخزون تلقائياً عند الموافقة.</p>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-700/50">
                <button 
                    wire:click="approve"
                    wire:confirm="هل أنت متأكد من الموافقة على هذا الطلب؟ سيتم إنشاء فاتورة مبيعات وتحديث المخزون."
                    class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-6 py-3 rounded-xl font-medium transition-all shadow-lg hover:shadow-xl">
                    تأكيد الموافقة
                </button>
                <a href="{{ route('admin.orders.view', $cartId) }}" 
                   class="bg-slate-700 hover:bg-slate-600 text-gray-100 px-6 py-3 rounded-xl font-medium transition-all">
                    إلغاء
                </a>
            </div>
        </div>
    </div>
</div>
