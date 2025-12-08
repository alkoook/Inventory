<?php

namespace App\Livewire\Client;

use App\Models\Company;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class CompanyDetails extends Component
{
    use WithPagination;

    public Company $company;

    public function mount(Company $company)
    {
        $this->company = $company;

        if (! $this->company->is_active) {
            abort(404);
        }
    }

    public function render()
    {
        $products = Product::query()
            ->where('company_id', $this->company->id)
            ->where('is_active', true)
            ->latest()
            ->paginate(12);

        return view('livewire.client.company-details', [
            'products' => $products,
        ])->layout('components.layouts.client');
    }
}
