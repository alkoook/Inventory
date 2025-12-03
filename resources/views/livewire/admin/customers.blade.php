<<<<<<< HEAD
<div class="min-h-screen bg-gray-900 text-white p-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-400 to-pink-600">
                Customers Management
            </h1>
            <button wire:click="create" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg transform transition hover:scale-105">
                Add New Customer
            </button>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-500/10 border border-green-500 text-green-400 px-4 py-3 rounded mb-6 relative" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <div class="mb-4">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search customers..." class="w-full md:w-1/3 bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors">
        </div>

        <div class="bg-gray-800 rounded-xl shadow-2xl border border-gray-700 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Phone</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Address</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($customers as $customer)
                        <tr class="hover:bg-gray-700/30 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">{{ $customer->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $customer->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $customer->phone }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ Str::limit($customer->address, 30) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="edit({{ $customer->id }})" class="text-purple-400 hover:text-purple-300 mr-3">Edit</button>
                                <button wire:click="delete({{ $customer->id }})" class="text-red-400 hover:text-red-300" onclick="return confirm('Are you sure?')">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-6 py-4 border-t border-gray-700">
                {{ $customers->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    @if($isOpen)
        <div class="fixed inset-0 z-10 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-700">
                    <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-white mb-4" id="modal-title">
                            {{ $customer_id ? 'Edit Customer' : 'Add New Customer' }}
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Name</label>
                                <input wire:model="name" type="text" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-purple-500">
                                @error('name') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Email</label>
                                <input wire:model="email" type="email" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-purple-500">
                                @error('email') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Phone</label>
                                <input wire:model="phone" type="text" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-purple-500">
                                @error('phone') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Address</label>
                                <textarea wire:model="address" rows="3" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-purple-500"></textarea>
                                @error('address') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="store" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Save
                        </button>
                        <button wire:click="closeModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-800 text-base font-medium text-gray-300 hover:bg-gray-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
=======
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
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
            </div>
        </div>
    @endif
</div>
