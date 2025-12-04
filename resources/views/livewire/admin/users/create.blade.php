<div>
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            
            <!-- Header -->
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">إضافة مستخدم جديد</h2>
            </div>

            <!-- Form -->
            <form wire:submit="save" class="p-6 space-y-4">

                <!-- الاسم -->
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-700">
                        الاسم الكامل *
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        wire:model="name" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl 
                               focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="مثال: أحمد محمد"
                    >
                    @error('name') 
                        <span class="text-red-600 text-xs mt-1">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- البريد الإلكتروني -->
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-700">
                        البريد الإلكتروني *
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        wire:model="email" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl 
                               focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="example@mail.com"
                    >
                    @error('email') 
                        <span class="text-red-600 text-xs mt-1">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- كلمة المرور -->
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-700">
                        كلمة المرور *
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        wire:model="password" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl 
                               focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="••••••••"
                    >
                    @error('password') 
                        <span class="text-red-600 text-xs mt-1">{{ $message }}</span> 
                    @enderror
                </div>

                
                <!--  رقم الجوال -->
                <div>
                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-700">
                       رقم الجوال
                    </label>
                    <input 
                        type="text" 
                        id="phone" 
                        wire:model="phone" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl 
                               focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="09xxxxxxxx"
                    >
                    @error('phone') 
                        <span class="text-red-600 text-xs mt-1">{{ $message }}</span> 
                    @enderror
                </div>

                     
                <!--   العنوان  -->
                <div>
                    <label for="address" class="block mb-2 text-sm font-medium text-gray-700">
                      العنوان
                    </label>
                    
                    <input 
                        type="text" 
                        id="address" 
                        wire:model="address" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl 
                               focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="ريف دمشق / عربين / السوق "
                    >
                    @error('address') 
                        <span class="text-red-600 text-xs mt-1">{{ $message }}</span> 
                    @enderror
                </div>

                     <!--   رقم الهوية  -->
                <div>
                    <label for="national_id" class="block mb-2 text-sm font-medium text-gray-700">
                      العنوان
                    </label>
                    <input 
                        type="text" 
                        id="national_id" 
                        wire:model="national_id" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl 
                               focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="0333 0333 0333 0333 "
                    >
                    @error('national_id') 
                        <span class="text-red-600 text-xs mt-1">{{ $message }}</span> 
                    @enderror
                </div>


                <!-- الدور -->
                <div>
                    <label for="role" class="block mb-2 text-sm font-medium text-gray-700">
                        الدور *
                    </label>

                    <select 
                        id="role" 
                        wire:model="role" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl 
                               focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    >
                        <option value="">اختر دور المستخدم</option>
                        
                        @foreach($roles as $roleOption)
                            <option value="{{ $roleOption->name }}">
                                {{ $roleOption->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('role') 
                        <span class="text-red-600 text-xs mt-1">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <a 
                        href="{{ route('admin.users.index') }}" 
                        class="text-gray-700 bg-gray-100 hover:bg-gray-200 
                               focus:ring-4 focus:outline-none focus:ring-gray-300 
                               font-medium rounded-xl text-sm px-5 py-2.5 text-center transition-colors"
                    >
                        إلغاء
                    </a>

                    <button 
                        type="submit" 
                        class="text-white bg-blue-600 hover:bg-blue-700 
                               focus:ring-4 focus:outline-none focus:ring-blue-300 
                               font-medium rounded-xl text-sm px-5 py-2.5 text-center transition-colors"
                    >
                        حفظ
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
