<?php

namespace App\Livewire\Client;

use App\Models\Setting;
use Livewire\Component;

class AboutUs extends Component
{
    public function render()
    {
        $aboutUs = Setting::get('about_us', 'نظام متكامل لإدارة المخزون والمبيعات...');

        return view('livewire.client.about-us', [
            'aboutUs' => $aboutUs,
        ])->layout('components.layouts.client', ['title' => 'من نحن - متجر المخزون']);
    }
}
