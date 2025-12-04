<?php

namespace App\Livewire\Admin\Companies;

use App\Models\Company;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $companies = Company::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orWhere('phone', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.companies.index', [
            'companies' => $companies,
        ])->layout('components.layouts.admin', ['header' => 'الشركات']);
    }

    public function delete($id)
    {
        Company::findOrFail($id)->delete();
        session()->flash('message', 'تم حذف الشركة بنجاح.');
    }
}
