<?php

namespace App\Livewire\Admin;

use App\Models\Company;
use Livewire\Component;
use Livewire\WithPagination;

class Companies extends Component
{
    use WithPagination;

    public $name;
    public $email;
    public $phone;
    public $address;
    public $description;
    public $is_active = true;
    public $selected_id;
    public $search = '';

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'nullable|email',
        'phone' => 'nullable',
        'address' => 'nullable',
        'description' => 'nullable',
        'is_active' => 'boolean',
    ];

    public function render()
    {
        $companies = Company::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.companies', [
            'companies' => $companies
        ])->layout('components.layouts.admin', ['header' => 'إدارة الشركات']);
    }

    public function create()
    {
        $this->reset(['name', 'email', 'phone', 'address', 'description', 'is_active', 'selected_id']);
    }

    public function edit($id)
    {
        $record = Company::findOrFail($id);
        $this->selected_id = $id;
        $this->name = $record->name;
        $this->email = $record->email;
        $this->phone = $record->phone;
        $this->address = $record->address;
        $this->description = $record->description;
        $this->is_active = $record->is_active;
    }

    public function save()
    {
        $this->validate();

        if ($this->selected_id) {
            $record = Company::find($this->selected_id);
            $record->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);
            session()->flash('message', 'تم تحديث بيانات الشركة بنجاح.');
        } else {
            Company::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);
            session()->flash('message', 'تم إضافة الشركة بنجاح.');
        }

        $this->reset(['name', 'email', 'phone', 'address', 'description', 'is_active', 'selected_id']);
        $this->dispatch('close-modal');
    }

    public function delete($id)
    {
        Company::find($id)->delete();
        session()->flash('message', 'تم حذف الشركة بنجاح.');
    }
}
