<div>
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-500/20 border border-green-500/50 text-green-400 rounded-xl" style="box-shadow: 0 0 15px rgba(34, 197, 94, 0.2);">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-slate-800 rounded-2xl border border-slate-700/50 shadow-xl overflow-hidden" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);">
        <div class="p-6 border-b border-slate-700/50 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-800">
            
            <!-- Search -->
            <div class="relative w-full sm:w-64">
                <input 
                    wire:model.live="search" 
                    type="text" 
                    placeholder="بحث عن مستخدم..." 
                    class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block p-2.5 pl-10 transition-all">
                
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
            </div>
            
            <!-- Add new user -->
            <a href="{{ route('admin.users.create') }}" 
                class="w-full sm:w-auto text-white bg-blue-600 hover:bg-blue-700 
                       focus:ring-4 focus:ring-blue-500/50 font-medium rounded-xl text-sm 
                       px-5 py-2.5 flex items-center justify-center gap-2 transition-all shadow-lg">

                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>

                إضافة مستخدم جديد
            </a>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm text-gray-300">
                <thead class="bg-slate-800/50 text-xs uppercase text-gray-400 border-b border-slate-700/50">
                    <tr>
                        <th class="px-6 py-4 font-semibold">الاسم</th>
                        <th class="px-6 py-4 font-semibold">البريد الإلكتروني</th>
                        <th class="px-6 py-4 font-semibold">الدور</th>
                        <th class="px-6 py-4 font-semibold">تاريخ الإضافة</th>
                        <th class="px-6 py-4 font-semibold">إجراءات</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-700/50">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-700/30 transition-colors">
                            
                            <!-- Name -->
                            <td class="px-6 py-4 font-medium text-gray-100">
                                {{ $user->name }}
                            </td>

                            <!-- Email -->
                            <td class="px-6 py-4 text-gray-400">
                                {{ $user->email }}
                            </td>

                            <!-- Role from Spatie -->
                            <td class="px-6 py-4">
                                @php
                                    $role = $user->getRoleNames()->first();
                                @endphp

                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $role === 'admin' ? 'bg-blue-500/20 text-blue-400 border border-blue-500/50' : 'bg-slate-700/50 text-gray-400 border border-slate-600/50' }}" style="{{ $role === 'admin' ? 'box-shadow: 0 0 10px rgba(59, 130, 246, 0.2);' : '' }}">
                                    {{ $role ?? '—' }}
                                </span>
                            </td>

                            <!-- Created At -->
                            <td class="px-6 py-4 text-gray-400">
                                {{ $user->created_at->format('Y-m-d') }}
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 flex gap-3">
                                <a href="{{ route('admin.users.edit', $user->id) }}" 
                                    class="font-medium text-blue-400 hover:text-blue-300 transition-colors">
                                    تعديل
                                </a>

                                <button wire:click="delete({{ $user->id }})" 
                                        wire:confirm="هل أنت متأكد من حذف هذا المستخدم؟"
                                        class="font-medium text-red-400 hover:text-red-300 transition-colors">
                                    حذف
                                </button>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                لا يوجد مستخدمون حالياً.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-slate-700/50">
            {{ $users->links() }}
        </div>
    </div>
</div>
