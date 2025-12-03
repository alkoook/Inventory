<a href="{{ route('client.card') }}" class="relative group">
    <div class="p-3 bg-slate-100 hover:bg-blue-100 rounded-xl transition-all transform hover:scale-110">
        <svg class="w-6 h-6 text-slate-600 group-hover:text-blue-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
        </svg>
    </div>
    @if($itemCount > 0)
        <span class="absolute -top-2 -left-2 w-6 h-6 bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs font-bold rounded-full flex items-center justify-center shadow-lg animate-bounce-subtle">
            {{ $itemCount > 99 ? '99+' : $itemCount }}
        </span>
    @endif
</a>

<style>
@keyframes bounce-subtle {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-4px);
    }
}

.animate-bounce-subtle {
    animation: bounce-subtle 2s ease-in-out infinite;
}
</style>
