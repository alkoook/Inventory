<div class="max-w-2xl mx-auto bg-slate-800 rounded-2xl border border-slate-700/50 shadow-xl p-6" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);">
    <h2 class="text-xl font-bold text-gray-100 mb-6">إضافة مستخدم جديد</h2>

    <form wire:submit="save" class="space-y-6">

        <!-- الاسم -->
        <div>
            <label for="name" class="block mb-2 text-sm font-medium text-gray-300">
                الاسم الكامل *
            </label>
            <input 
                type="text" 
                id="name" 
                wire:model="name" 
                class="bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all"
                placeholder="مثال: أحمد محمد"
            >
            @error('name') 
                <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> 
            @enderror
        </div>

        <!-- البريد الإلكتروني -->
        <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-300">
                البريد الإلكتروني *
            </label>
            <input 
                type="email" 
                id="email" 
                wire:model="email" 
                class="bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all"
                placeholder="example@mail.com"
            >
            @error('email') 
                <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> 
            @enderror
        </div>

        <!-- كلمة المرور -->
        <div>
            <label for="password" class="block mb-2 text-sm font-medium text-gray-300">
                كلمة المرور *
            </label>
            <input 
                type="password" 
                id="password" 
                wire:model="password" 
                class="bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all"
                placeholder="••••••••"
            >
            @error('password') 
                <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> 
            @enderror
        </div>

        <!-- رقم الجوال -->
        <div>
            <label for="phone" class="block mb-2 text-sm font-medium text-gray-300">
                رقم الجوال
            </label>
            <input 
                type="text" 
                id="phone" 
                wire:model="phone" 
                class="bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all"
                placeholder="09xxxxxxxx"
            >
            @error('phone') 
                <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> 
            @enderror
        </div>

        <!-- العنوان -->
        <div>
            <label for="address" class="block mb-2 text-sm font-medium text-gray-300">
                العنوان
            </label>
            <input 
                type="text" 
                id="address" 
                wire:model="address" 
                class="bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all"
                placeholder="ريف دمشق / عربين / السوق"
            >
            @error('address') 
                <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> 
            @enderror
        </div>

        <!-- رقم الهوية -->
        <div>
            <label for="national_id" class="block mb-2 text-sm font-medium text-gray-300">
                رقم الهوية
            </label>
            <input 
                type="text" 
                id="national_id" 
                wire:model="national_id" 
                class="bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all"
                placeholder="0333 0333 0333 0333"
            >
            @error('national_id') 
                <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> 
            @enderror
        </div>

        <!-- الدور -->
        <div>
            <label for="role" class="block mb-2 text-sm font-medium text-gray-300">
                الدور *
            </label>
            <select 
                id="role" 
                wire:model="role" 
                class="bg-slate-700/50 border border-slate-600 text-gray-100 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all"
            >
                <option value="">اختر دور المستخدم</option>
                @foreach($roles as $roleOption)
                    <option value="{{ $roleOption->name }}">
                        {{ $roleOption->name }}
                    </option>
                @endforeach
            </select>
            @error('role') 
                <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> 
            @enderror
        </div>

        <!-- Actions -->
        <div class="flex justify-end gap-3 pt-4 border-t border-slate-700/50">
            <a 
                href="{{ route('admin.users.index') }}" 
                class="bg-slate-700/50 hover:bg-slate-700 px-5 py-2.5 rounded-xl text-gray-300 transition duration-150"
            >
                إلغاء
            </a>
            <button 
                type="submit" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl transition duration-150 font-semibold shadow-lg"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove wire:target="save">حفظ</span>
                <span wire:loading wire:target="save">جاري الحفظ...</span>
            </button>
        </div>

    </form>
</div>
