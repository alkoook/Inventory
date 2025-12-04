<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Edit extends Component
{
    public $userId;

    public $name = '';
    public $email = '';
    public $password = '';

    public $address = '';
    public $phone = '';
    public $national_id = '';

    public $role = '';
    public $roles = [];

    public function mount($id)
    {
        $user = User::with('roles')->findOrFail($id);

        $this->roles = Role::all();

        $this->userId      = $user->id;
        $this->name        = $user->name;
        $this->email       = $user->email;

        $this->address     = $user->address;
        $this->phone       = $user->phone;
        $this->national_id = $user->national_id;

        $this->role = $user->roles->first()->name ?? ''; // جلب الدور الحالي من Spatie
    }

    protected function rules()
    {
        return [
            'name'        => 'required|min:3',
            'email'       => 'required|email|unique:users,email,' . $this->userId,
            'password'    => 'nullable|min:6',

            'address'     => 'nullable|string|max:255',
            'phone'       => 'nullable|string|max:255',
            'national_id' => 'nullable|string|max:255',

            'role'        => 'required|exists:roles,name',
        ];
    }

    public function save()
    {
        $this->validate();

        $user = User::findOrFail($this->userId);

        // تحديث الحقول الأساسية
        $data = [
            'name'        => $this->name,
            'email'       => $this->email,
            'address'     => $this->address,
            'phone'       => $this->phone,
            'national_id' => $this->national_id,
        ];

        // تحديث كلمة المرور إن وُجدت
        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        $user->update($data);

        // تحديث الدور من Spatie
        $user->syncRoles([$this->role]);

        session()->flash('message', 'تم تحديث المستخدم بنجاح.');
        return redirect()->route('admin.users.index');
    }

    public function render()
    {
        return view('livewire.admin.users.edit', [
            'roles' => $this->roles
        ])->layout('components.layouts.admin', [
            'header' => 'تعديل المستخدم'
        ]);
    }
}
