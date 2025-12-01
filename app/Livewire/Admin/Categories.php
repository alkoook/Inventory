<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Categories extends Component
{
    use WithPagination;

    public $name;
    public $description;
    public $is_active = true;
    public $selected_id;
    public $search = '';

    protected $rules = [
        'name' => 'required|min:3',
        'description' => 'nullable',
        'is_active' => 'boolean',
    ];

    public function render()
    {
        $categories = Category::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.categories', [
            'categories' => $categories
        ])->layout('components.layouts.admin', ['header' => 'إدارة الأصناف']);
    }

    public function create()
    {
        $this->reset(['name', 'description', 'is_active', 'selected_id']);
    }

    public function edit($id)
    {
        $record = Category::findOrFail($id);
        $this->selected_id = $id;
        $this->name = $record->name;
        $this->description = $record->description;
        $this->is_active = $record->is_active;
    }

    public function save()
    {
        $this->validate();

        if ($this->selected_id) {
            $record = Category::find($this->selected_id);
            $record->update([
                'name' => $this->name,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);
            session()->flash('message', 'تم تحديث الصنف بنجاح.');
        } else {
            Category::create([
                'name' => $this->name,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);
            session()->flash('message', 'تم إضافة الصنف بنجاح.');
        }

        $this->reset(['name', 'description', 'is_active', 'selected_id']);
        $this->dispatch('close-modal');
    }

    public function delete($id)
    {
        Category::find($id)->delete();
        session()->flash('message', 'تم حذف الصنف بنجاح.');
    }
}
