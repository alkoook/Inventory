<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Settings extends Component
{
    public $site_name;
    public $email;
    public $phone;
    public $address;
    public $about_us;
    public $facebook;
    public $twitter;
    public $instagram;

    public function mount()
    {
        $settings = Setting::first();
        if ($settings) {
            $this->site_name = $settings->site_name;
            $this->email = $settings->email;
            $this->phone = $settings->phone;
            $this->address = $settings->address;
            $this->about_us = $settings->about_us;
            $social = $settings->social_links ?? [];
            $this->facebook = $social['facebook'] ?? '';
            $this->twitter = $social['twitter'] ?? '';
            $this->instagram = $social['instagram'] ?? '';
        } else {
            $this->site_name = 'Inventory System';
        }
    }

    public function save()
    {
        $this->validate([
            'site_name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'about_us' => 'nullable|string',
        ]);

        $data = [
            'site_name' => $this->site_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'about_us' => $this->about_us,
            'social_links' => [
                'facebook' => $this->facebook,
                'twitter' => $this->twitter,
                'instagram' => $this->instagram,
            ],
        ];

        $settings = Setting::first();
        if ($settings) {
            $settings->update($data);
        } else {
            Setting::create($data);
        }

        session()->flash('message', 'Settings saved successfully.');
    }

    public function render()
    {
        return view('livewire.admin.settings');
    }
}
