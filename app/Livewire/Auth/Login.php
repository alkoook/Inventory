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
    public $remember = false;

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

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();

            // Redirect based on user role
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('client.catalog');
            }
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
