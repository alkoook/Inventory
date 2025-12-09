<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md">
        <!-- Card with enhanced design -->
        <div class="bg-slate-800/95 backdrop-blur-xl rounded-3xl shadow-2xl p-10 border border-slate-700/50 relative overflow-hidden" style="box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5), 0 0 30px rgba(59, 130, 246, 0.2);">
            <!-- Decorative background elements -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-600/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl"></div>
            
            <!-- Logo/Header -->
            <div class="text-center mb-10 relative z-10">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-600 rounded-2xl mb-6 shadow-2xl overflow-hidden transform hover:scale-110 transition-transform duration-300" style="box-shadow: 0 8px 30px rgba(59, 130, 246, 0.6);">
                    @if(file_exists(public_path('logo.png')))
                        <img src="{{ asset('logo.png') }}" alt="Logo" class="w-full h-full object-cover">
                    @else
                        <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    @endif
                </div>
                <h1 class="text-4xl font-extrabold text-gray-100 mb-3 bg-gradient-to-r from-blue-400 to-blue-300 bg-clip-text text-transparent">
                    نظام إدارة المخزون
                </h1>
                <p class="text-gray-400 text-lg">مرحباً بك، قم بتسجيل الدخول للمتابعة</p>
            </div>

            <!-- Form -->
            <form wire:submit="login" class="space-y-6 relative z-10">
                
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-300 mb-3">
                        البريد الإلكتروني
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-500 group-focus-within:text-blue-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input 
                            type="email" 
                            id="email" 
                            wire:model="email"
                            class="block w-full pr-12 pl-4 py-4 bg-slate-700/60 border-2 border-slate-600 rounded-xl text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 hover:border-slate-500"
                            placeholder="example@domain.com"
                            autocomplete="email"
                        >
                    </div>
                    @error('email') 
                        <p class="mt-3 text-sm text-red-400 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-300 mb-3">
                        كلمة المرور
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-500 group-focus-within:text-blue-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input 
                            type="password" 
                            id="password" 
                            wire:model="password"
                            class="block w-full pr-12 pl-4 py-4 bg-slate-700/60 border-2 border-slate-600 rounded-xl text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 hover:border-slate-500"
                            placeholder="••••••••"
                            autocomplete="current-password"
                        >
                    </div>
                    @error('password') 
                        <p class="mt-3 text-sm text-red-400 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-bold py-4 px-6 rounded-xl shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-500/50 relative overflow-hidden group"
                    style="box-shadow: 0 8px 25px rgba(59, 130, 246, 0.5);"
                >
                    <span class="relative z-10 flex items-center justify-center gap-3">
                        <span wire:loading.remove>تسجيل الدخول</span>
                        <span wire:loading class="flex items-center justify-center gap-3">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            جاري التحميل...
                        </span>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-blue-300 opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                </button>
            </form>

            <!-- Footer -->
            <div class="mt-8 text-center relative z-10">
                <p class="text-sm text-gray-400">
                    لا تملك حساب؟ 
                    <span class="text-blue-400 font-semibold">تواصل مع المسؤول</span>
                </p>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="mt-8 text-center">
            <p class="text-xs text-gray-500">
                © {{ date('Y') }} نظام إدارة المخزون. جميع الحقوق محفوظة.
            </p>
        </div>
    </div>
</div>
