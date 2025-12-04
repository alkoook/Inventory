<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Create extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $phone = '';
    public $address = '';
    public $national_id = '';
    public $role = '';

    public $roles = [];

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'phone' => 'nullable|numeric|min:10',
        'address' => 'nullable|string|min:10',
        'national_id' => 'nullable|numeric|min:9',
        'role' => 'required|exists:roles,name',   // مهم جداً!
    ];

    public function mount()
    {
        // جلب كل الرولز من Spatie
        $this->roles = Role::all();
    }

    public function save()
    {
        $this->validate();

        // إنشاء المستخدم بدون role
        $user = User::create([
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => Hash::make($this->password),
            'phone'    => $this->phone,
            'address'    => $this->address,
            'national_id'    => $this->national_id,

        ]);

        // تعيين الدور من Spatie
        $user->assignRole($this->role);

        session()->flash('message', 'تم إضافة المستخدم بنجاح.');
        return redirect()->route('admin.users.index');
    }

    public function render()
    {
        return view('livewire.admin.users.create', [
            'roles' => $this->roles
        ])->layout('components.layouts.admin', [
            'header' => 'إضافة مستخدم جديد'
        ]);
    }
}
