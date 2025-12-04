<?php

namespace App\Livewire\Admin\Companies;

use App\Models\Company;
use Livewire\Component;

class Create extends Component
{
    public $name = '';
    public $contact_name = '';
    public $phone = '';
    public $email = '';
    public $address = '';
    public $is_active = true;

    protected $rules = [
        'name' => 'required|min:3',
        'contact_name' => 'nullable|string',
        'phone' => 'nullable|string',
        'email' => 'nullable|email',
        'address' => 'nullable|string',
        'is_active' => 'boolean',
    ];

    protected $messages = [
        'name.required' => 'اسم الشركة مطلوب',
        'name.min' => 'اسم الشركة يجب أن يكون 3 أحرف على الأقل',
        'email.email' => 'البريد الإلكتروني غير صحيح',
    ];

    public function save()
    {
        $this->validate();

        Company::create([
            'name' => $this->name,
            'contact_name' => $this->contact_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'تم إضافة الشركة بنجاح.');
        return redirect()->route('admin.companies.index');
    }

    public function render()
    {
        return view('livewire.admin.companies.create')
            ->layout('components.layouts.admin', ['header' => 'إضافة شركة جديدة']);
    }
}
