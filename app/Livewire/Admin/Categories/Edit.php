<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Livewire\Component;

class Edit extends Component
{
    public $categoryId;
    public $name = '';
    public $description = '';
    public $is_active = true;

    public function mount($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->is_active = $category->is_active;
    }

    protected function rules()
    {
        return [
            'name' => 'required|min:3|unique:categories,name,' . $this->categoryId,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ];
    }

    protected $messages = [
        'name.required' => 'اسم الصنف مطلوب',
        'name.min' => 'اسم الصنف يجب أن يكون 3 أحرف على الأقل',
        'name.unique' => 'اسم الصنف موجود مسبقاً',
    ];

    public function save()
    {
        $this->validate();

        $category = Category::findOrFail($this->categoryId);
        $category->update([
            'name' => $this->name,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'تم تحديث الصنف بنجاح.');
        return redirect()->route('admin.categories.index');
    }

    public function render()
    {
        return view('livewire.admin.categories.edit')
            ->layout('components.layouts.admin', ['header' => 'تعديل الصنف']);
    }
}
