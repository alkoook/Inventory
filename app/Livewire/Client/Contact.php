<?php

namespace App\Livewire\Client;

use App\Models\Setting;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.client')]
class Contact extends Component
{
    public function render()
    {
        $settings = Setting::first();
        return view('livewire.client.contact', [
            'settings' => $settings
        ])->layout('components.layouts.app');
    }
}
