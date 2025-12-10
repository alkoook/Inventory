<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name = '';
    public $description = '';
    public $is_active = true;
    public $image;

    protected $rules = [
        'name' => 'required|min:3|unique:categories,name',
        'description' => 'nullable|string',
        'is_active' => 'boolean',
        'image' => 'nullable|image|max:10240',
    ];

    protected $messages = [
        'name.required' => 'اسم الصنف مطلوب',
        'name.min' => 'اسم الصنف يجب أن يكون 3 أحرف على الأقل',
        'name.unique' => 'اسم الصنف موجود مسبقاً',
    ];

    public function save()
    {
        $this->validate();

        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('categories', 'public');
        }

        Category::create([
            'name' => $this->name,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'image' => $imagePath,
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
