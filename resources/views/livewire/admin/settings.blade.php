<<<<<<< HEAD
<div class="min-h-screen bg-gray-900 text-white p-6">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-400 to-pink-600">
                System Settings
            </h1>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-500/10 border border-green-500 text-green-400 px-4 py-3 rounded mb-6 relative" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <div class="bg-gray-800 rounded-xl shadow-2xl border border-gray-700 p-6">
            <form wire:submit.prevent="save" class="space-y-6">
                <!-- General Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Site Name</label>
                        <input wire:model="site_name" type="text" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors">
                        @error('site_name') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Contact Email</label>
                        <input wire:model="email" type="email" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors">
                        @error('email') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Phone Number</label>
                        <input wire:model="phone" type="text" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors">
                        @error('phone') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Address</label>
                    <textarea wire:model="address" rows="3" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors"></textarea>
                    @error('address') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">About Us Content</label>
                    <textarea wire:model="about_us" rows="5" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors"></textarea>
                    @error('about_us') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Social Media -->
                <div class="border-t border-gray-700 pt-6">
                    <h3 class="text-lg font-semibold text-gray-300 mb-4">Social Media Links</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Facebook</label>
                            <input wire:model="facebook" type="text" placeholder="https://facebook.com/..." class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Twitter</label>
                            <input wire:model="twitter" type="text" placeholder="https://twitter.com/..." class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Instagram</label>
                            <input wire:model="instagram" type="text" placeholder="https://instagram.com/..." class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors">
=======
<div>
    <div class="max-w-4xl mx-auto">
        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('message') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-200 bg-slate-50">
                <h2 class="text-lg font-bold text-slate-900">إعدادات الموقع ومعلومات التواصل</h2>
                <p class="text-sm text-slate-500 mt-1">قم بتحديث المعلومات التي تظهر للزوار في الفوتر وصفحة اتصل بنا.</p>
            </div>
            
            <form wire:submit="save" class="p-6 space-y-6">
                <!-- General Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="site_name" class="block text-sm font-medium text-slate-700 mb-2">اسم الموقع</label>
                        <input type="text" id="site_name" wire:model="site_name" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('site_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="site_email" class="block text-sm font-medium text-slate-700 mb-2">البريد الإلكتروني للدعم</label>
                        <input type="email" id="site_email" wire:model="site_email" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('site_email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="site_phone" class="block text-sm font-medium text-slate-700 mb-2">رقم الهاتف</label>
                        <input type="text" id="site_phone" wire:model="site_phone" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('site_phone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="site_address" class="block text-sm font-medium text-slate-700 mb-2">العنوان</label>
                        <input type="text" id="site_address" wire:model="site_address" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('site_address') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- About Us -->
                <div>
                    <label for="about_us" class="block text-sm font-medium text-slate-700 mb-2">نبذة عن المتجر (من نحن)</label>
                    <textarea id="about_us" wire:model="about_us" rows="4" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    @error('about_us') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Social Media -->
                <div class="pt-6 border-t border-slate-100">
                    <h3 class="text-md font-bold text-slate-900 mb-4">وسائل التواصل الاجتماعي</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="facebook_url" class="block text-sm font-medium text-slate-700 mb-2">Facebook URL</label>
                            <input type="url" id="facebook_url" wire:model="facebook_url" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="https://facebook.com/...">
                            @error('facebook_url') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="twitter_url" class="block text-sm font-medium text-slate-700 mb-2">Twitter URL</label>
                            <input type="url" id="twitter_url" wire:model="twitter_url" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="https://twitter.com/...">
                            @error('twitter_url') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="instagram_url" class="block text-sm font-medium text-slate-700 mb-2">Instagram URL</label>
                            <input type="url" id="instagram_url" wire:model="instagram_url" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="https://instagram.com/...">
                            @error('instagram_url') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="linkedin_url" class="block text-sm font-medium text-slate-700 mb-2">LinkedIn URL</label>
                            <input type="url" id="linkedin_url" wire:model="linkedin_url" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="https://linkedin.com/...">
                            @error('linkedin_url') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
                        </div>
                    </div>
                </div>

<<<<<<< HEAD
                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg transform transition hover:scale-105">
                        Save Settings
=======
                <!-- Actions -->
                <div class="flex justify-end pt-6 border-t border-slate-100">
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        حفظ التغييرات
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
