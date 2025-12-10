<?php

namespace App\Livewire\Admin\Companies;

use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public $companyId;
    public $name = '';
    public $contact_name = '';
    public $phone = '';
    public $email = '';
    public $address = '';
    public $is_active = true;
    public $image;
    public $oldImage;

    public function mount($id)
    {
        $company = Company::findOrFail($id);
        $this->companyId = $company->id;
        $this->name = $company->name;
        $this->contact_name = $company->contact_name;
        $this->phone = $company->phone;
        $this->email = $company->email;
        $this->address = $company->address;
        $this->is_active = $company->is_active;
        $this->oldImage = $company->image;
    }

    protected $rules = [
        'name' => 'required|min:3',
        'contact_name' => 'nullable|string',
        'phone' => 'nullable|string',
        'email' => 'nullable|email',
        'address' => 'nullable|string',
        'is_active' => 'boolean',
        'image' => 'nullable|image|max:10240',
    ];

    protected $messages = [
        'name.required' => 'اسم الشركة مطلوب',
        'name.min' => 'اسم الشركة يجب أن يكون 3 أحرف على الأقل',
        'email.email' => 'البريد الإلكتروني غير صحيح',
    ];

    public function save()
    {
        $this->validate();

        $company = Company::findOrFail($this->companyId);
        
        $imagePath = $this->oldImage;
        if ($this->image) {
            // Delete old image if exists
            if ($this->oldImage && Storage::disk('public')->exists($this->oldImage)) {
                Storage::disk('public')->delete($this->oldImage);
            }
            $imagePath = $this->image->store('companies', 'public');
        }

        $company->update([
            'name' => $this->name,
            'contact_name' => $this->contact_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'is_active' => $this->is_active,
            'image' => $imagePath,
        ]);

        session()->flash('message', 'تم تحديث الشركة بنجاح.');
        return redirect()->route('admin.companies.index');
    }

    public function render()
    {
        return view('livewire.admin.companies.edit')
            ->layout('components.layouts.admin', ['header' => 'تعديل الشركة']);
    }
}
