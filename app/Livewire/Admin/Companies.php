<?php

namespace App\Livewire\Admin;

use App\Models\Company;
use Livewire\Component;
use Livewire\WithPagination;

class Companies extends Component
{
    use WithPagination;

    public $name;
    public $contact_name;
    public $phone;
    public $email;
    public $address;
    public $is_active = true;
    
    public $selected_id;
    public $search = '';

    protected $rules = [
        'name' => 'required|min:3',
        'contact_name' => 'nullable|string',
        'phone' => 'nullable|string',
        'email' => 'nullable|email',
        'address' => 'nullable|string',
        'is_active' => 'boolean',
    ];

    public function render()
    {
        $companies = Company::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('contact_name', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.companies', [
            'companies' => $companies,
        ])->layout('components.layouts.admin', ['header' => 'إدارة الشركات']);
    }

    public function create()
    {
        $this->reset(['name', 'contact_name', 'phone', 'email', 'address', 'is_active', 'selected_id']);
    }

    public function edit($id)
    {
        $record = Company::findOrFail($id);
        $this->selected_id = $id;
        $this->name = $record->name;
        $this->contact_name = $record->contact_name;
        $this->phone = $record->phone;
        $this->email = $record->email;
        $this->address = $record->address;
        $this->is_active = $record->is_active;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'contact_name' => $this->contact_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'is_active' => $this->is_active,
        ];

        if ($this->selected_id) {
            Company::find($this->selected_id)->update($data);
            session()->flash('message', 'تم تحديث بيانات الشركة بنجاح.');
        } else {
            Company::create($data);
            session()->flash('message', 'تم إضافة الشركة بنجاح.');
        }

        $this->reset(['name', 'contact_name', 'phone', 'email', 'address', 'is_active', 'selected_id']);
        $this->dispatch('close-modal');
    }

    public function delete($id)
    {
        Company::find($id)->delete();
        session()->flash('message', 'تم حذف الشركة بنجاح.');
    }
}
