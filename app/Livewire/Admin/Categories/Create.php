<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Livewire\Component;

class Create extends Component
{
    public $name = '';
    public $description = '';
    public $is_active = true;

    protected $rules = [
        'name' => 'required|min:3|unique:categories,name',
        'description' => 'nullable|string',
        'is_active' => 'boolean',
    ];

    protected $messages = [
        'name.required' => 'اسم الصنف مطلوب',
        'name.min' => 'اسم الصنف يجب أن يكون 3 أحرف على الأقل',
        'name.unique' => 'اسم الصنف موجود مسبقاً',
    ];

    public function save()
    {
        $this->validate();

        Category::create([
            'name' => $this->name,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'تم إضافة الصنف بنجاح.');
        return redirect()->route('admin.categories.index');
    }

    public function render()
    {
        return view('livewire.admin.categories.create')
            ->layout('components.layouts.admin', ['header' => 'إضافة صنف جديد']);
    }
}
