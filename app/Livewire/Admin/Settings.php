<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;

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
    public $whatsapp_number;

    public function mount()
    {
        $this->site_name     = Setting::get('site_name', 'Inventory System');
        $this->site_email    = Setting::get('site_email');
        $this->site_phone    = Setting::get('site_phone');
        $this->site_address  = Setting::get('site_address');
        $this->about_us      = Setting::get('about_us');

        $this->facebook_url  = Setting::get('facebook_url');
        $this->twitter_url   = Setting::get('twitter_url');
        $this->instagram_url = Setting::get('instagram_url');
        $this->linkedin_url  = Setting::get('linkedin_url');
        $this->whatsapp_number  = Setting::get('whatsapp_number');
    }

    public function save()
    {
        $this->validate([
            'site_name'     => 'nullable|string|max:255',
            'site_email'    => 'nullable|email',
            'site_phone'    => 'nullable|string',
            'site_address'  => 'nullable|string',
            'about_us'      => 'nullable|string',
            'facebook_url'  => 'nullable|url',
            'twitter_url'   => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'linkedin_url'  => 'nullable|url',
            'whatsapp_number'  => 'nullable|string',
        ]);

        Setting::set('site_name', $this->site_name);
        Setting::set('site_email', $this->site_email);
        Setting::set('site_phone', $this->site_phone);
        Setting::set('site_address', $this->site_address);
        Setting::set('about_us', $this->about_us);

        Setting::set('facebook_url', $this->facebook_url, 'social');
        Setting::set('twitter_url', $this->twitter_url, 'social');
        Setting::set('instagram_url', $this->instagram_url, 'social');
        Setting::set('linkedin_url', $this->linkedin_url, 'social');
        Setting::set('whatsapp_number', $this->whatsapp_number, 'social');

        session()->flash('message', 'تم حفظ الإعدادات بنجاح.');
    }

    public function render()
    {
        return view('livewire.admin.settings')
            ->layout('components.layouts.admin', ['header' => 'إعدادات النظام']);
    }
}
