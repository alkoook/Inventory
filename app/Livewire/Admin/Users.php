<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $name;
    public $email;
    public $password;
    public $role = 'customer';
    
    public $selected_id;
    public $search = '';
    public $showModal = false;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'role' => 'required|in:admin,customer',
    ];

    protected $messages = [
        'name.required' => 'الاسم مطلوب',
        'name.min' => 'الاسم يجب أن يكون 3 أحرف على الأقل',
        'email.required' => 'البريد الإلكتروني مطلوب',
        'email.email' => 'البريد الإلكتروني غير صحيح',
        'email.unique' => 'البريد الإلكتروني مستخدم بالفعل',
        'password.required' => 'كلمة المرور مطلوبة',
        'password.min' => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل',
        'role.required' => 'الدور مطلوب',
    ];

    public function render()
    {
        $users = User::where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.users', [
            'users' => $users,
        ])->layout('components.layouts.admin', ['header' => 'إدارة المستخدمين']);
    }

    public function create()
    {
        $this->reset(['name', 'email', 'password', 'role', 'selected_id']);
        $this->role = 'customer';
        $this->showModal = true;
    }

    public function edit($id)
    {
        $record = User::findOrFail($id);
        $this->selected_id = $id;
        $this->name = $record->name;
        $this->email = $record->email;
        $this->password = ''; // Don't show password
        $this->role = $record->role;
        $this->showModal = true;
    }

    public function save()
    {
        $rules = $this->rules;
        
        if ($this->selected_id) {
            // When editing, email can be the same as current user
            $rules['email'] = 'required|email|unique:users,email,' . $this->selected_id;
            // Password is optional when editing
            $rules['password'] = 'nullable|min:6';
        }

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];

        // Only update password if provided
        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->selected_id) {
            User::find($this->selected_id)->update($data);
            session()->flash('message', 'تم تحديث المستخدم بنجاح.');
        } else {
            // For new users, password is required
            $data['password'] = Hash::make($this->password);
            User::create($data);
            session()->flash('message', 'تم إضافة المستخدم بنجاح.');
        }

        $this->reset(['name', 'email', 'password', 'role', 'selected_id']);
        $this->showModal = false;
    }

    public function delete($id)
    {
        // Prevent deleting yourself
        if ($id == auth()->id()) {
            session()->flash('error', 'لا يمكنك حذف حسابك الخاص.');
            return;
        }

        User::find($id)->delete();
        session()->flash('message', 'تم حذف المستخدم بنجاح.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['name', 'email', 'password', 'role', 'selected_id']);
    }
}
