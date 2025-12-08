<div class="w-full max-w-md">
    <!-- Card -->
    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl p-8 border border-slate-700/50" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3), 0 0 15px rgba(59, 130, 246, 0.1);">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-600 via-blue-500 to-red-500 rounded-2xl mb-4 shadow-lg overflow-hidden" style="box-shadow: 0 4px 25px rgba(59, 130, 246, 0.5), 0 2px 10px rgba(239, 68, 68, 0.3);">
                @if(file_exists(public_path('logo')) && is_dir(public_path('logo')))
                    @php
                        $logoFiles = glob(public_path('logo') . '/*.{jpg,jpeg,png,gif,svg,webp}', GLOB_BRACE);
                        $logoPath = !empty($logoFiles) ? 'logo/' . basename($logoFiles[0]) : null;
                    @endphp
                    @if($logoPath)
                        <img src="{{ asset($logoPath) }}" alt="Logo" class="w-full h-full object-cover">
                    @else
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    @endif
                @else
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                @endif
            </div>
            <h1 class="text-3xl font-bold text-gray-100 mb-2">نظام إدارة المخزون</h1>
            <p class="text-gray-400">مرحباً بك، قم بتسجيل الدخول للمتابعة</p>
        </div>

        <!-- Form -->
        <form wire:submit="login" class="space-y-6">
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                    البريد الإلكتروني
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input 
                        type="email" 
                        id="email" 
                        wire:model="email"
                        class="block w-full pr-10 pl-4 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
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
                <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                    كلمة المرور
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input 
                        type="password" 
                        id="password" 
                        wire:model="password"
                        class="block w-full pr-10 pl-4 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="••••••••"
                        autocomplete="current-password"
                    >
                </div>
                @error('password') 
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button 
                type="submit"
                class="w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-semibold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-slate-800"
                style="box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);"
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
            <p class="text-sm text-gray-400">
                لا تملك حساب؟ تواصل مع المسؤول
            </p>
        </div>
    </div>

    <!-- Additional Info -->
    <div class="mt-6 text-center">
        <p class="text-xs text-gray-500">
            © {{ date('Y') }} نظام إدارة المخزون. جميع الحقوق محفوظة.
        </p>
    </div>
</div>
