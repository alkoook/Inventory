<div class="min-h-screen bg-slate-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Info -->
            <div>
                <h1 class="text-3xl font-bold text-slate-900 mb-6">تواصل معنا</h1>
                <p class="text-slate-500 text-lg mb-8">
                    نحن هنا لمساعدتك. إذا كان لديك أي استفسار أو اقتراح، لا تتردد في التواصل معنا عبر النموذج أو معلومات الاتصال أدناه.
                </p>

                <div class="space-y-6">
                    <div class="flex items-start gap-4 p-6 bg-white rounded-xl shadow-sm border border-slate-200">
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 mb-1">اتصل بنا</h3>
                            <p class="text-slate-500">{{ $sitePhone ?? '+963 912 345 678' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-6 bg-white rounded-xl shadow-sm border border-slate-200">
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 mb-1">راسلنا عبر البريد</h3>
                            <p class="text-slate-500">{{ $siteEmail ?? 'support@inventory.com' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-6 bg-white rounded-xl shadow-sm border border-slate-200">
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 mb-1">زورنا في مقرنا</h3>
                            <p class="text-slate-500">{{ $siteAddress ?? 'دمشق، سوريا' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-8">
                <h2 class="text-2xl font-bold text-slate-900 mb-6">أرسل لنا رسالة</h2>
                
                @if (session()->has('message'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        {{ session('message') }}
                    </div>
                @endif

                <form wire:submit="save" class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-2">الاسم الكامل</label>
                        <input type="text" id="name" wire:model="name" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow">
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-2">البريد الإلكتروني</label>
                        <input type="email" id="email" wire:model="email" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow">
                        @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-slate-700 mb-2">الموضوع</label>
                        <input type="text" id="subject" wire:model="subject" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow">
                        @error('subject') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-slate-700 mb-2">الرسالة</label>
                        <textarea id="message" wire:model="message" rows="4" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow"></textarea>
                        @error('message') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-blue-200 hover:shadow-blue-300 transition-all transform hover:-translate-y-0.5">
                        إرسال الرسالة
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
