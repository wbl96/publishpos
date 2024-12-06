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

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <style>
        :root {
            --purple: #6747a6;
            --purple-hover: #553894;
            --orange: #F39F5A;
            --pink: #E8BCB9;
            --green: #517366;
            --green-hover: #456357;
            --light-green: #4CAF50;
            --expenses-red: #ff5757;
        }

        .auth-container {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--purple), var(--green));
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            font-family: 'Tajawal', sans-serif;
        }
        
        .auth-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(103, 71, 166, 0.2);
            width: 100%;
            max-width: 900px;
            padding: 2rem;
            display: flex;
            gap: 2rem;
        }

        .auth-left {
            flex: 1;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, var(--orange), var(--purple));
            border-radius: 15px;
            color: white;
        }

        .auth-right {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
            max-height: 600px;
        }
        
        .auth-logo {
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: var(--orange);
            font-size: 2.5rem;
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2);
        }

        .welcome-text {
            text-align: center;
            margin-bottom: 2rem;
        }

        .welcome-text h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: bold;
        }

        .welcome-text p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .auth-input {
            width: 100%;
            padding: 0.75rem 2.5rem 0.75rem 1rem !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 10px !important;
            transition: all 0.3s ease;
            margin-top: 0.5rem !important;
        }
        
        .auth-input:focus {
            border-color: var(--orange) !important;
            box-shadow: 0 0 0 3px rgba(243, 159, 90, 0.1) !important;
        }
        
        .auth-button {
            width: 100%;
            padding: 0.75rem !important;
            background: var(--orange) !important;
            color: white !important;
            border: none !important;
            border-radius: 10px !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
        }
        
        .auth-button:hover {
            background: var(--purple) !important;
            transform: translateY(-1px);
        }
        
        .input-icon {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--orange);
        }
        
        .auth-link {
            color: var(--purple);
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .auth-link:hover {
            color: var(--orange);
        }

        @media (max-width: 768px) {
            .auth-card {
                flex-direction: column;
                max-width: 400px;
            }
            
            .auth-left {
                padding: 1.5rem;
            }
            
            .auth-right {
                padding: 1.5rem;
            }
        }
    </style>

    <div class="auth-container">
        <div class="auth-card">
            <!-- القسم الأيسر - الترحيب -->
            <div class="auth-left">
                <div class="auth-logo">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="welcome-text">
                    <h1>انضم إلينا!</h1>
                    <p>قم بإنشاء حسابك الآن وابدأ في إدارة أعمالك بكل سهولة وفعالية.</p>
                </div>
            </div>

            <!-- القسم الأيمن - نموذج التسجيل -->
            <div class="auth-right">
                <form wire:submit="register">
                    <!-- Name -->
                    <div class="mb-4">
                        <label class="block font-medium mb-1" style="color: var(--green)">الاسم</label>
                        <div class="relative">
                            <i class="fas fa-user input-icon"></i>
                            <input wire:model="form.name" 
                                   type="text" 
                                   class="auth-input"
                                   placeholder="أدخل اسمك الكامل"
                                   required>
                        </div>
                        <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mb-4">
                        <label class="block font-medium mb-1" style="color: var(--green)">البريد الإلكتروني</label>
                        <div class="relative">
                            <i class="fas fa-envelope input-icon"></i>
                            <input wire:model="form.email" 
                                   type="email" 
                                   class="auth-input"
                                   placeholder="أدخل بريدك الإلكتروني"
                                   required>
                        </div>
                        <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label class="block font-medium mb-1" style="color: var(--green)">كلمة المرور</label>
                        <div class="relative">
                            <i class="fas fa-lock input-icon"></i>
                            <input wire:model="form.password" 
                                   type="password" 
                                   class="auth-input"
                                   placeholder="أدخل كلمة المرور"
                                   required>
                        </div>
                        <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-6">
                        <label class="block font-medium mb-1" style="color: var(--green)">تأكيد كلمة المرور</label>
                        <div class="relative">
                            <i class="fas fa-lock input-icon"></i>
                            <input wire:model="form.password_confirmation" 
                                   type="password" 
                                   class="auth-input"
                                   placeholder="أعد إدخال كلمة المرور"
                                   required>
                        </div>
                        <x-input-error :messages="$errors->get('form.password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="auth-button mb-4">
                        <i class="fas fa-user-plus ml-2"></i>
                        إنشاء حساب
                    </button>

                    <!-- Login Link -->
                    <div class="text-center">
                        <span style="color: var(--green)">لديك حساب بالفعل؟</span>
                        <a href="{{ route('login') }}" class="auth-link mr-1" wire:navigate>
                            تسجيل الدخول
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @endpush
</div>
