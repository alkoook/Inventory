<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $categories = Category::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.categories.index', [
            'categories' => $categories,
        ])->layout('components.layouts.admin', ['header' => 'الأصناف']);
    }

    public function delete($id)
    {
        Category::findOrFail($id)->delete();
        session()->flash('message', 'تم حذف الصنف بنجاح.');
    }
}
