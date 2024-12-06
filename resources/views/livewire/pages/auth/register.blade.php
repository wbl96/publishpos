<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 3; // دور المستخدم العادي

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect('/dashboard', navigate: true);
    }
}; ?>

<div class="min-h-screen w-full">
    <div class="login-page">
        <div class="login-image">
            <div class="login-image-content">
                <i class="fas fa-cloud"></i>
                <h1>وبل لحلول الأعمال</h1>
                <p>انضم إلينا اليوم وابدأ في إدارة أعمالك بكفاءة عالية</p>
            </div>
        </div>

        <div class="login-content">
            <div class="login-form">
                <div class="form-header">
                    <h2>إنشاء حساب جديد</h2>
                    <p>أدخل بياناتك لإنشاء حساب جديد</p>
                </div>

                <form wire:submit="register">
                    <!-- اسم المستخدم -->
                    <div class="input-group">
                        <input wire:model="name" 
                               type="text" 
                               placeholder="اسم المستخدم"
                               required>
                        <i class="fas fa-user"></i>
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />

                    <!-- البريد الإلكتروني -->
                    <div class="input-group">
                        <input wire:model="email" 
                               type="email" 
                               placeholder="البريد الإلكتروني"
                               required>
                        <i class="fas fa-envelope"></i>
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />

                    <!-- كلمة المرور -->
                    <div class="input-group">
                        <input wire:model="password" 
                               type="password" 
                               placeholder="كلمة المرور"
                               required>
                        <i class="fas fa-lock"></i>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />

                    <!-- تأكيد كلمة المرور -->
                    <div class="input-group">
                        <input wire:model="password_confirmation" 
                               type="password" 
                               placeholder="تأكيد كلمة المرور"
                               required>
                        <i class="fas fa-lock"></i>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

                    <button type="submit" class="login-button">
                        <i class="fas fa-user-plus ml-2"></i>
                        إنشاء حساب
                    </button>

                    <div class="register-link">
                        <span>لديك حساب بالفعل؟</span>
                        <a href="{{ route('login') }}" wire:navigate>تسجيل الدخول</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
