<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Settings extends Component
{
    public $site_name;
    public $site_email;
    public $site_phone;
    public $site_address;
    public $about_us;

    // Social Media
    public $facebook_url;
    public $twitter_url;
    public $instagram_url;
    public $linkedin_url;

    public function mount()
    {
        $settings = Setting::first();
        if ($settings) {
            $this->site_name = $settings->site_name ?? 'Inventory System';
            $this->site_email = $settings->site_email ?? '';
            $this->site_phone = $settings->site_phone ?? '';
            $this->site_address = $settings->site_address ?? '';
            $this->about_us = $settings->about_us ?? '';

            $social = $settings->social_links ?? [];
            $this->facebook_url = $social['facebook'] ?? $settings->facebook_url ?? '';
            $this->twitter_url = $social['twitter'] ?? $settings->twitter_url ?? '';
            $this->instagram_url = $social['instagram'] ?? $settings->instagram_url ?? '';
            $this->linkedin_url = $settings->linkedin_url ?? '';
        } else {
            $this->site_name = 'Inventory System';
        }
    }

    public function save()
    {
        $this->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'nullable|email',
            'site_phone' => 'nullable|string',
            'site_address' => 'nullable|string',
            'about_us' => 'nullable|string',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
        ]);

        $data = [
            'site_name' => $this->site_name,
            'site_email' => $this->site_email,
            'site_phone' => $this->site_phone,
            'site_address' => $this->site_address,
            'about_us' => $this->about_us,
            'social_links' => [
                'facebook' => $this->facebook_url,
                'twitter' => $this->twitter_url,
                'instagram' => $this->instagram_url,
            ],
            'facebook_url' => $this->facebook_url,
            'twitter_url' => $this->twitter_url,
            'instagram_url' => $this->instagram_url,
            'linkedin_url' => $this->linkedin_url,
        ];

        $settings = Setting::first();
        if ($settings) {
            $settings->update($data);
        } else {
            Setting::create($data);
        }

        session()->flash('message', 'تم حفظ الإعدادات بنجاح.');
    }

    public function render()
    {
        return view('livewire.admin.settings')
            ->layout('components.layouts.admin', ['header' => 'إعدادات النظام']);
    }
}
