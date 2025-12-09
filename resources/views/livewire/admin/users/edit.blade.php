<div>
    <div class="max-w-2xl mx-auto">
        <div class="bg-slate-800 rounded-2xl border border-slate-700/50 shadow-xl overflow-hidden" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);">

            <!-- Header -->
            <div class="p-6 border-b border-slate-700/50 bg-slate-800">
                <h2 class="text-xl font-bold text-gray-100">تعديل المستخدم</h2>
            </div>

            <!-- Form -->
            <form wire:submit="save" class="p-6 space-y-4">

                <!-- الاسم -->
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-300">الاسم الكامل *</label>
                    <input 
                        type="text" 
                        id="name" 
                        wire:model="name"
                        class="bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 text-sm rounded-xl 
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all"
                    >
                    @error('name') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- البريد الإلكتروني -->
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-300">البريد الإلكتروني *</label>
                    <input 
                        type="email" 
                        id="email" 
                        wire:model="email"
                        class="bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 text-sm rounded-xl 
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all"
                    >
                    @error('email') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- كلمة مرور جديدة (اختياري) -->
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-300">
                        كلمة المرور الجديدة (اختياري)
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        wire:model="password"
                        class="bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 text-sm rounded-xl 
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all"
                        placeholder="اتركه فارغاً للإبقاء على القديم"
                    >
                    @error('password') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- رقم الهاتف -->
                <div>
                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-300">رقم الهاتف</label>
                    <input 
                        type="text" 
                        id="phone" 
                        wire:model="phone"
                        class="bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 text-sm rounded-xl 
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all"
                        placeholder="09xxxxxxxx"
                    >
                    @error('phone') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- العنوان -->
                <div>
                    <label for="address" class="block mb-2 text-sm font-medium text-gray-300">العنوان</label>
                    <textarea 
                        id="address" 
                        wire:model="address"
                        rows="2"
                        class="bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 text-sm rounded-xl 
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all"
                        placeholder="مثال: دمشق - المزة - جانب الحديقة"
                    ></textarea>
                    @error('address') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- رقم الهوية -->
                <div>
                    <label for="national_id" class="block mb-2 text-sm font-medium text-gray-300">رقم الهوية</label>
                    <input 
                        type="text" 
                        id="national_id" 
                        wire:model="national_id"
                        class="bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 text-sm rounded-xl 
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all"
                    >
                    @error('national_id') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- الدور -->
                <div>
                    <label for="role" class="block mb-2 text-sm font-medium text-gray-300">
                        الدور *
                    </label>
                    <select 
                        id="role" 
                        wire:model="role" 
                        class="bg-slate-700/50 border border-slate-600 text-gray-100 text-sm rounded-xl 
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all"
                    >
                        <option value="">اختر دور المستخدم</option>

                        @foreach($roles as $roleOption)
                            <option value="{{ $roleOption->name }}">
                                {{ $roleOption->name }}
                            </option>
                        @endforeach

                    </select>
                    @error('role') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Actions -->
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-700/50">
                    <a 
                        href="{{ route('admin.users.index') }}" 
                        class="text-gray-300 bg-slate-700/50 hover:bg-slate-700 
                               focus:ring-4 focus:outline-none focus:ring-slate-500 
                               font-medium rounded-xl text-sm px-5 py-2.5 transition-colors"
                    >
                        إلغاء
                    </a>

                    <button 
                        type="submit" 
                        class="text-white bg-blue-600 hover:bg-blue-700 
                               focus:ring-4 focus:outline-none focus:ring-blue-500/50 
                               font-medium rounded-xl text-sm px-5 py-2.5 transition-all shadow-lg"
                        style="box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);"
                    >
                        حفظ التعديلات
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
