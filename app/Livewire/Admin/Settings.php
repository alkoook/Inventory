<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;
<<<<<<< HEAD
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
=======

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
        $this->site_name = Setting::get('site_name', 'متجر المخزون');
        $this->site_email = Setting::get('site_email', 'support@inventory.com');
        $this->site_phone = Setting::get('site_phone', '+963 912 345 678');
        $this->site_address = Setting::get('site_address', 'دمشق، سوريا');
        $this->about_us = Setting::get('about_us', 'نظام متكامل لإدارة المخزون والمبيعات...');
        
        $this->facebook_url = Setting::get('facebook_url');
        $this->twitter_url = Setting::get('twitter_url');
        $this->instagram_url = Setting::get('instagram_url');
        $this->linkedin_url = Setting::get('linkedin_url');
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
    }

    public function save()
    {
        $this->validate([
            'site_name' => 'required|string|max:255',
<<<<<<< HEAD
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
=======
            'site_email' => 'required|email',
            'site_phone' => 'required|string',
            'site_address' => 'nullable|string',
            'about_us' => 'nullable|string',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
        ]);

        Setting::set('site_name', $this->site_name);
        Setting::set('site_email', $this->site_email);
        Setting::set('site_phone', $this->site_phone);
        Setting::set('site_address', $this->site_address);
        Setting::set('about_us', $this->about_us);
        
        Setting::set('facebook_url', $this->facebook_url);
        Setting::set('twitter_url', $this->twitter_url);
        Setting::set('instagram_url', $this->instagram_url);
        Setting::set('linkedin_url', $this->linkedin_url);

        session()->flash('message', 'تم حفظ الإعدادات بنجاح.');
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
    }

    public function render()
    {
<<<<<<< HEAD
        return view('livewire.admin.settings');
=======
        return view('livewire.admin.settings')
            ->layout('components.layouts.admin', ['header' => 'إعدادات النظام']);
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
    }
}
