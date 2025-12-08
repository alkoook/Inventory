<?php

namespace App\Livewire\Client;

use App\Models\Setting;
use Livewire\Component;

class ContactUs extends Component
{
    public $name;

    public $email;

    public $subject;

    public $message;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Here you would typically send an email or save to database
        // For now, we'll just show a success message

        session()->flash('message', 'تم استلام رسالتك بنجاح. سنتواصل معك قريباً.');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.client.contact-us', [
            'sitePhone' => Setting::get('site_phone'),
            'siteEmail' => Setting::get('site_email'),
            'siteAddress' => Setting::get('site_address'),
        ])->layout('components.layouts.client', ['title' => 'اتصل بنا - متجر المخزون']);
    }
}
