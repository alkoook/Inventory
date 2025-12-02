<div>
    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-4 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <!-- Header with Search and Add Button -->
    <div class="mb-6 flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center">
        <div class="flex-1 w-full sm:w-auto">
            <input 
                type="text" 
                wire:model.live="search" 
                placeholder="بحث عن زبون..."
                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>
        <button 
            wire:click="create"
            class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition flex items-center justify-center gap-2"
        >
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            إضافة زبون جديد
        </button>
    </div>

    <!-- Customers Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">اسم الزبون</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">معلومات الاتصال</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">الحد الائتماني</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">الحالة</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">إجراءات</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse ($customers as $customer)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-slate-900">{{ $customer->name }}</div>
                            <div class="text-xs text-slate-400">ID: {{ $customer->id }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-slate-900">{{ $customer->phone ?? '-' }}</div>
                            <div class="text-sm text-slate-500">{{ $customer->email ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-bold text-slate-900">
                            {{ number_format($customer->credit_limit, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($customer->is_active)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    نشط
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    غير نشط
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex gap-2">
                                <button 
                                    wire:click="edit({{ $customer->id }})"
                                    class="text-blue-600 hover:text-blue-900 transition"
                                >
                                    تعديل
                                </button>
                                <button 
                                    wire:click="delete({{ $customer->id }})"
                                    wire:confirm="هل أنت متأكد من حذف هذا الزبون؟"
                                    class="text-red-600 hover:text-red-900 transition"
                                >
                                    حذف
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            لا يوجد زبائن
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $customers->links() }}
    </div>

    <!-- Modal -->
    @if ($selected_id !== null || $name !== null)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-6 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900">
                        {{ $selected_id ? 'تعديل بيانات الزبون' : 'إضافة زبون جديد' }}
                    </h3>
                    <button wire:click="$set('selected_id', null); $set('name', null)" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <form wire:submit="save" class="p-6 space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-2">الاسم الكامل</label>
                        <input 
                            type="text" 
                            id="name" 
                            wire:model="name"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-2">البريد الإلكتروني (للدخول)</label>
                        <input 
                            type="email" 
                            id="email" 
                            wire:model="email"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-2">كلمة المرور {{ $selected_id ? '(اتركها فارغة إذا لم ترد التغيير)' : '' }}</label>
                        <input 
                            type="password" 
                            id="password" 
                            wire:model="password"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                        @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-slate-700 mb-2">رقم الهاتف</label>
                        <input 
                            type="text" 
                            id="phone" 
                            wire:model="phone"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                        @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-slate-700 mb-2">العنوان</label>
                        <textarea 
                            id="address" 
                            wire:model="address" 
                            rows="2"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        ></textarea>
                        @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="credit_limit" class="block text-sm font-medium text-slate-700 mb-2">الحد الائتماني</label>
                        <input 
                            type="number" 
                            step="0.01" 
                            id="credit_limit" 
                            wire:model="credit_limit"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                        @error('credit_limit') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center">
                        <input 
                            id="is_active" 
                            type="checkbox" 
                            wire:model="is_active"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                        >
                        <label for="is_active" class="mr-2 text-sm font-medium text-slate-700">نشط</label>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex gap-3 pt-4">
                        <button 
                            type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition"
                        >
                            {{ $selected_id ? 'تحديث' : 'إضافة' }}
                        </button>
                        <button 
                            type="button"
                            wire:click="$set('selected_id', null); $set('name', null)"
                            class="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2 rounded-lg font-medium transition"
                        >
                            إلغاء
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
