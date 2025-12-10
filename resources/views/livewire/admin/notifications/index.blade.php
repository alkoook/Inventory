<div>
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-500/20 border border-green-500/50 text-green-400 rounded-xl" style="box-shadow: 0 0 15px rgba(34, 197, 94, 0.2);">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-slate-800 rounded-2xl border border-slate-700/50 shadow-xl overflow-hidden" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);">
        <!-- Header -->
        <div class="p-6 border-b border-slate-700/50 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-800">
            <h2 class="text-xl font-bold text-gray-100">الإشعارات</h2>
            
            <div class="flex items-center gap-3">
                <!-- Filter -->
                <div class="flex gap-2">
                    <button 
                        wire:click="$set('filter', 'all')"
                        class="px-4 py-2 rounded-xl text-sm font-medium transition-colors {{ $filter === 'all' ? 'bg-blue-600 text-white' : 'bg-slate-700/50 text-gray-300 hover:bg-slate-700' }}"
                    >
                        الكل
                    </button>
                    <button 
                        wire:click="$set('filter', 'unread')"
                        class="px-4 py-2 rounded-xl text-sm font-medium transition-colors {{ $filter === 'unread' ? 'bg-blue-600 text-white' : 'bg-slate-700/50 text-gray-300 hover:bg-slate-700' }}"
                    >
                        غير مقروءة
                    </button>
                    <button 
                        wire:click="$set('filter', 'read')"
                        class="px-4 py-2 rounded-xl text-sm font-medium transition-colors {{ $filter === 'read' ? 'bg-blue-600 text-white' : 'bg-slate-700/50 text-gray-300 hover:bg-slate-700' }}"
                    >
                        مقروءة
                    </button>
                </div>

                @if($unreadCount > 0)
                    <button 
                        wire:click="markAllAsRead"
                        wire:confirm="هل تريد تحديد جميع الإشعارات كمقروءة؟"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-medium transition-colors"
                    >
                        تحديد الكل كمقروء
                    </button>
                @endif
            </div>
        </div>

        <!-- Notifications List -->
        <div class="divide-y divide-slate-700/50">
            @forelse($notifications as $notification)
                <div class="p-6 hover:bg-slate-700/30 transition-colors {{ !$notification->is_read ? 'bg-slate-700/20' : '' }}">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                @if($notification->type === 'out_of_stock')
                                    <div class="p-2 rounded-lg bg-red-500/20 text-red-400">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                @else
                                    <div class="p-2 rounded-lg bg-yellow-500/20 text-yellow-400">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                @endif
                                
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-100 {{ !$notification->is_read ? 'font-bold' : '' }}">
                                        {{ $notification->title }}
                                        @if(!$notification->is_read)
                                            <span class="ml-2 inline-block w-2 h-2 bg-blue-500 rounded-full"></span>
                                        @endif
                                    </h3>
                                    <p class="text-sm text-gray-400 mt-1">{{ $notification->message }}</p>
                                    @if($notification->type === 'new_order' && $notification->cart_id)
                                        <button 
                                            wire:click="viewOrder({{ $notification->id }})"
                                            class="text-blue-400 hover:text-blue-300 text-sm mt-2 inline-block transition-colors"
                                        >
                                            عرض الطلب →
                                        </button>
                                    @elseif($notification->product)
                                        <a href="{{ route('admin.products.edit', $notification->product->id) }}" class="text-blue-400 hover:text-blue-300 text-sm mt-2 inline-block">
                                            عرض المنتج →
                                        </a>
                                    @endif
                                    <p class="text-xs text-gray-500 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            @if(!$notification->is_read)
                                <button 
                                    wire:click="markAsRead({{ $notification->id }})"
                                    class="p-2 text-blue-400 hover:text-blue-300 hover:bg-blue-500/10 rounded-lg transition-colors"
                                    title="تحديد كمقروء"
                                >
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                            @endif
                            <button 
                                wire:click="delete({{ $notification->id }})"
                                wire:confirm="هل أنت متأكد من حذف هذا الإشعار؟"
                                class="p-2 text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-lg transition-colors"
                                title="حذف"
                            >
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <p class="text-gray-400 text-lg">لا توجد إشعارات</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-slate-700/50">
            {{ $notifications->links() }}
        </div>
    </div>
</div>

