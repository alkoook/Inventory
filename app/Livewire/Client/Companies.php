<?php

namespace App\Livewire\Client;

use App\Models\Company;
use Livewire\Component;
use Livewire\WithPagination;

class Companies extends Component
{
    use WithPagination;

    public function render()
    {
        $companies = Company::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('livewire.client.companies', [
            'companies' => $companies,
        ])->layout('components.layouts.client');
    }
}
