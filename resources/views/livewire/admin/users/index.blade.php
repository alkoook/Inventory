<div>
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
            
            <!-- Search -->
            <div class="relative w-full sm:w-64">
                <input 
                    wire:model.live="search" 
                    type="text" 
                    placeholder="بحث عن مستخدم..." 
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-2.5 pl-10">
                
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
            </div>
            
            <!-- Add new user -->
            <a href="{{ route('admin.users.create') }}" 
                class="w-full sm:w-auto text-white bg-blue-600 hover:bg-blue-700 
                       focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-sm 
                       px-5 py-2.5 flex items-center justify-center gap-2 transition-colors shadow-sm">

                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>

                إضافة مستخدم جديد
            </a>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm text-gray-700">
                <thead class="bg-gray-50 text-xs uppercase text-gray-600 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold">الاسم</th>
                        <th class="px-6 py-4 font-semibold">البريد الإلكتروني</th>
                        <th class="px-6 py-4 font-semibold">الدور</th>
                        <th class="px-6 py-4 font-semibold">تاريخ الإضافة</th>
                        <th class="px-6 py-4 font-semibold">إجراءات</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            
                            <!-- Name -->
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $user->name }}
                            </td>

                            <!-- Email -->
                            <td class="px-6 py-4 text-gray-600">
                                {{ $user->email }}
                            </td>

                            <!-- Role from Spatie -->
                            <td class="px-6 py-4">
                                @php
                                    $role = $user->getRoleNames()->first();
                                @endphp

                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $role === 'admin' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ $role ?? '—' }}
                                </span>
                            </td>

                            <!-- Created At -->
                            <td class="px-6 py-4 text-gray-600">
                                {{ $user->created_at->format('Y-m-d') }}
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 flex gap-3">
                                <a href="{{ route('admin.users.edit', $user->id) }}" 
                                    class="font-medium text-blue-600 hover:text-blue-700 transition-colors">
                                    تعديل
                                </a>

                                <button wire:click="delete({{ $user->id }})" 
                                        wire:confirm="هل أنت متأكد من حذف هذا المستخدم؟"
                                        class="font-medium text-red-600 hover:text-red-700 transition-colors">
                                    حذف
                                </button>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                لا يوجد مستخدمون حالياً.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
    </div>
</div>
