<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Login extends Component
{
    public $email = '';

    public $password = '';

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    protected $messages = [
        'email.required' => 'البريد الإلكتروني مطلوب',
        'email.email' => 'البريد الإلكتروني غير صحيح',
        'password.required' => 'كلمة المرور مطلوبة',
        'password.min' => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل',
    ];

    public function login()
    {
        $this->validate();

        // تذكّر المستخدم معطل حالياً، فنستخدم false كقيمة ثابتة
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], false)) {
            session()->regenerate();

            $user = Auth::user();

            // باستخدام Spatie Roles
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }

            if ($user->hasRole('manager')) {
                return redirect()->route('admin.sales-invoices.create');
            }

            if ($user->hasRole('worker')) {
                return redirect()->route('admin.workers.my-invoices');
            }

            if ($user->hasRole('customer')) {
                return redirect()->route('client.catalog');
            }

            // لو ما عنده رول معروف، رجّعه على صفحة عامة أو صفحة خطأ
            return redirect()->route('client.catalog');
        }

        $this->addError('email', 'بيانات الدخول غير صحيحة.');
    }

    #[Layout('components.layouts.guest')]
    #[Title('تسجيل الدخول')]
    public function render()
    {
        return view('livewire.auth.login');
    }
}
