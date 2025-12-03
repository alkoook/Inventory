<div class="w-full max-w-md">
    <!-- Card -->
    <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-2xl p-8 border border-white/20">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">نظام إدارة المخزون</h1>
            <p class="text-slate-300">مرحباً بك، قم بتسجيل الدخول للمتابعة</p>
        </div>

        <!-- Form -->
        <form wire:submit="login" class="space-y-6">
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-slate-200 mb-2">
                    البريد الإلكتروني
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input 
                        type="email" 
                        id="email" 
                        wire:model="email"
                        class="block w-full pr-10 pl-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="example@domain.com"
                        autocomplete="email"
                    >
                </div>
                @error('email') 
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-slate-200 mb-2">
                    كلمة المرور
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input 
                        type="password" 
                        id="password" 
                        wire:model="password"
                        class="block w-full pr-10 pl-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="••••••••"
                        autocomplete="current-password"
                    >
                </div>
                @error('password') 
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input 
                    type="checkbox" 
                    id="remember" 
                    wire:model="remember"
                    class="h-4 w-4 rounded border-white/20 bg-white/10 text-blue-600 focus:ring-blue-500 focus:ring-offset-0"
                >
                <label for="remember" class="mr-2 block text-sm text-slate-300">
                    تذكرني
                </label>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit"
                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-slate-900"
            >
                <span wire:loading.remove>تسجيل الدخول</span>
                <span wire:loading class="flex items-center justify-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    جاري التحميل...
                </span>
            </button>
        </form>

        <!-- Footer -->
        <div class="mt-6 text-center">
            <p class="text-sm text-slate-400">
                لا تملك حساب؟ تواصل مع المسؤول
            </p>
        </div>
    </div>

    <!-- Additional Info -->
    <div class="mt-6 text-center">
        <p class="text-xs text-slate-500">
            © {{ date('Y') }} نظام إدارة المخزون. جميع الحقوق محفوظة.
        </p>
    </div>
</div>
