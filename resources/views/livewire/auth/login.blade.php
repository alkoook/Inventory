@php
    $appName = \App\Models\Setting::get('site_name', 'نظام إدارة المخزون');
@endphp

<div class="min-h-screen flex items-center justify-center bg-slate-950 py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden" style="background-color: #020617;">
    <!-- Animated background particles -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-1/4 left-1/4 w-96 h-96 bg-blue-500/15 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/2 w-72 h-72 bg-indigo-600/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>
    
    <!-- Floating particles animation -->
    <div class="absolute inset-0">
        <div class="particle absolute w-2 h-2 bg-blue-400/30 rounded-full animate-float" style="top: 20%; right: 10%; animation-delay: 0s;"></div>
        <div class="particle absolute w-1.5 h-1.5 bg-blue-300/40 rounded-full animate-float" style="top: 60%; right: 20%; animation-delay: 1s;"></div>
        <div class="particle absolute w-1 h-1 bg-indigo-400/30 rounded-full animate-float" style="top: 40%; right: 30%; animation-delay: 2s;"></div>
        <div class="particle absolute w-2.5 h-2.5 bg-blue-500/20 rounded-full animate-float" style="top: 80%; right: 15%; animation-delay: 1.5s;"></div>
        <div class="particle absolute w-1.5 h-1.5 bg-indigo-300/30 rounded-full animate-float" style="top: 30%; right: 50%; animation-delay: 0.5s;"></div>
    </div>

    <div class="w-full max-w-md relative z-10">
        <!-- Card with enhanced design -->
        <div class="bg-slate-900/95 backdrop-blur-xl rounded-3xl shadow-2xl p-10 border border-slate-700/30 relative overflow-hidden transform transition-all duration-500 hover:scale-[1.02]" style="box-shadow: 0 20px 60px rgba(0, 0, 0, 0.7), 0 0 40px rgba(59, 130, 246, 0.15);">
            <!-- Animated gradient border -->
            <div class="absolute inset-0 rounded-3xl bg-gradient-to-r from-blue-600/20 via-indigo-600/20 to-blue-600/20 opacity-0 hover:opacity-100 transition-opacity duration-500 animate-gradient"></div>
            
            <!-- Decorative background elements with animation -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-600/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1.5s;"></div>
            
            <!-- Header -->
            <div class="text-center mb-10 relative z-10 animate-fade-in">
                <h1 class="text-5xl font-extrabold text-gray-100 mb-4 bg-gradient-to-r from-blue-400 via-indigo-400 to-blue-300 bg-clip-text text-transparent animate-gradient-text">
                    {{ $appName }}
                </h1>
                <div class="flex items-center justify-center gap-2 mb-3">
                    <div class="h-1 w-12 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full animate-slide-in"></div>
                    <div class="h-1 w-2 bg-blue-500 rounded-full animate-pulse"></div>
                    <div class="h-1 w-12 bg-gradient-to-l from-blue-600 to-indigo-600 rounded-full animate-slide-in" style="animation-delay: 0.2s;"></div>
                </div>
                <p class="text-gray-400 text-lg animate-fade-in-delay">مرحباً بك، قم بتسجيل الدخول للمتابعة</p>
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
                    <span class="text-blue-400 font-semibold hover:text-blue-300 transition-colors cursor-pointer">تواصل مع المسؤول</span>
                </p>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="mt-8 text-center">
            <p class="text-xs text-gray-500">
                © {{ date('Y') }} {{ $appName }}. جميع الحقوق محفوظة.
            </p>
        </div>
    </div>

    <style>
        @keyframes float {
            0%, 100% {
                transform: translateY(0) translateX(0);
                opacity: 0.3;
            }
            50% {
                transform: translateY(-20px) translateX(10px);
                opacity: 0.6;
            }
        }
        
        @keyframes gradient {
            0%, 100% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
        }
        
        @keyframes gradient-text {
            0%, 100% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
        }
        
        @keyframes slide-in {
            from {
                width: 0;
            }
            to {
                width: 3rem;
            }
        }
        
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 3s ease infinite;
        }
        
        .animate-gradient-text {
            background-size: 200% 200%;
            animation: gradient-text 3s ease infinite;
        }
        
        .animate-slide-in {
            animation: slide-in 1s ease-out forwards;
        }
        
        .animate-fade-in {
            animation: fade-in 0.8s ease-out forwards;
        }
        
        .animate-fade-in-delay {
            animation: fade-in 0.8s ease-out 0.3s forwards;
            opacity: 0;
        }
    </style>
</div>
