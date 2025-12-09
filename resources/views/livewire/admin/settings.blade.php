<div>
    <div class="max-w-4xl mx-auto">
        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="mb-6 bg-blue-500/20 border border-blue-500/50 text-blue-400 px-4 py-3 rounded-lg flex items-center gap-2" style="box-shadow: 0 0 15px rgba(59, 130, 246, 0.2);">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('message') }}
            </div>
        @endif

        <div class="bg-slate-800 rounded-2xl border border-slate-700/50 shadow-xl overflow-hidden" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);">
            <div class="p-6 border-b border-slate-700/50 bg-slate-800">
                <h2 class="text-lg font-bold text-gray-100">إعدادات الموقع ومعلومات التواصل</h2>
                <p class="text-sm text-gray-400 mt-1">قم بتحديث المعلومات التي تظهر للزوار في الفوتر وصفحة اتصل بنا.</p>
            </div>
            
            <form wire:submit.prevent="save" class="p-6 space-y-6">
                <!-- General Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="site_name" class="block text-sm font-medium text-gray-300 mb-2">اسم الموقع</label>
                        <input type="text" id="site_name" wire:model="site_name" class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                        @error('site_name') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="site_email" class="block text-sm font-medium text-gray-300 mb-2">البريد الإلكتروني للدعم</label>
                        <input type="email" id="site_email" wire:model="site_email" class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                        @error('site_email') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="site_phone" class="block text-sm font-medium text-gray-300 mb-2">رقم الهاتف</label>
                        <input type="text" id="site_phone" wire:model="site_phone" class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                        @error('site_phone') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="site_address" class="block text-sm font-medium text-gray-300 mb-2">العنوان</label>
                        <input type="text" id="site_address" wire:model="site_address" class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                        @error('site_address') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- About Us -->
                <div>
                    <label for="about_us" class="block text-sm font-medium text-gray-300 mb-2">نبذة عن المتجر (من نحن)</label>
                    <textarea id="about_us" wire:model="about_us" rows="4" class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"></textarea>
                    @error('about_us') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Social Media -->
                <div class="pt-6 border-t border-slate-700/50">
                    <h3 class="text-md font-bold text-gray-100 mb-4">وسائل التواصل الاجتماعي</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="facebook_url" class="block text-sm font-medium text-gray-300 mb-2">Facebook URL</label>
                            <input type="url" id="facebook_url" wire:model="facebook_url" class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all" placeholder="https://facebook.com/...">
                            @error('facebook_url') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="twitter_url" class="block text-sm font-medium text-gray-300 mb-2">Twitter URL</label>
                            <input type="url" id="twitter_url" wire:model="twitter_url" class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all" placeholder="https://twitter.com/...">
                            @error('twitter_url') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="instagram_url" class="block text-sm font-medium text-gray-300 mb-2">Instagram URL</label>
                            <input type="url" id="instagram_url" wire:model="instagram_url" class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all" placeholder="https://instagram.com/...">
                            @error('instagram_url') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="linkedin_url" class="block text-sm font-medium text-gray-300 mb-2">LinkedIn URL</label>
                            <input type="url" id="linkedin_url" wire:model="linkedin_url" class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all" placeholder="https://linkedin.com/...">
                            @error('linkedin_url') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="whatsapp_number" class="block text-sm font-medium text-gray-300 mb-2">رقم WhatsApp</label>
                            <input type="text" id="whatsapp_number" wire:model="whatsapp_number" class="w-full px-4 py-2 bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all" placeholder="966501234567">
                            @error('whatsapp_number') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                            <p class="text-xs text-gray-400 mt-1">أدخل الرقم بدون رموز (مثال: 966501234567)</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end pt-6 border-t border-slate-700/50">
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-lg transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
