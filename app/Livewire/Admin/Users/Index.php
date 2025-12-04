<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $users = User::with('roles')  // لتحميل الأدوار بدون استعلامات إضافية
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.users.index', [
            'users' => $users,
        ])->layout('components.layouts.admin', [
            'header' => 'المستخدمين'
        ]);
    }

    public function delete($id)
    {
        if ($id == auth()->id()) {
            session()->flash('error', 'لا يمكنك حذف حسابك الخاص.');
            return;
        }

        $user = User::findOrFail($id);

        // إزالة الأدوار قبل الحذف (اختياري لكنه أنظف)
        $user->roles()->detach();

        $user->delete();

        session()->flash('message', 'تم حذف المستخدم بنجاح.');
    }
}
