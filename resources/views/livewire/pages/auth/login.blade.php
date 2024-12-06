<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();
        $userRole=Auth::user()->role;
        switch($userRole){
            case 1:
                $this->redirectIntended(default: route('admin', absolute: false), navigate: true);
                break;
            case 3:
                $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
                break;
            default:
                $this->redirect('/');
                break;
        }
    }
}; ?>

<div class="min-h-screen w-full">
    <style>
        :root {
            --primary: #2C3E50;
            --secondary: #E74C3C;
            --accent: #3498DB;
            --text: #ECF0F1;
            --dark: #2c3e50;
            --light: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Tajawal', sans-serif;
        }

        .login-page {
            min-height: 100vh;
            width: 100%;
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .login-image {
            background: linear-gradient(135deg, var(--primary) 0%, #34495e 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            padding: 2rem;
        }

        .login-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff10" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,186.7C384,213,480,235,576,213.3C672,192,768,128,864,128C960,128,1056,192,1152,208C1248,224,1344,192,1392,176L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
            background-repeat: no-repeat;
            background-position: bottom;
            background-size: cover;
            opacity: 0.1;
        }

        .login-image-content {
            text-align: center;
            color: var(--light);
            max-width: 500px;
            position: relative;
            z-index: 1;
        }

        .login-image-content i {
            font-size: 4rem;
            margin-bottom: 2rem;
            color: var(--light);
        }

        .login-image-content h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .login-image-content p {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        .login-content {
            background: var(--light);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-form {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-header h2 {
            font-size: 2rem;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: #666;
        }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group input {
            width: 100%;
            padding: 1rem 3rem 1rem 1rem;
            border: 2px solid #eee;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            color: var(--dark);
        }

        .input-group input:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .input-group i {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            transition: all 0.3s ease;
        }

        .input-group input:focus + i {
            color: var(--accent);
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 1.5rem 0;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #666;
        }

        .forgot-password {
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: #2980b9;
        }

        .login-button {
            width: 100%;
            padding: 1rem;
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .login-button:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }

        .register-link {
            text-align: center;
            color: #666;
        }

        .register-link a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
            margin-right: 0.5rem;
        }

        .register-link a:hover {
            color: #2980b9;
        }

        @media (max-width: 768px) {
            .login-page {
                grid-template-columns: 1fr;
            }

            .login-image {
                display: none;
            }

            .login-content {
                padding: 1rem;
            }
        }
    </style>

    <div class="login-page">
        <div class="login-image">
            <div class="login-image-content">
                <i class="fas fa-cloud"></i>
                <h1>وبل لحلول الأعمال</h1>
                <p>نظام متكامل لإدارة أعمالك بكفاءة عالية</p>
            </div>
        </div>

        <div class="login-content">
            <div class="login-form">
                <div class="form-header">
                    <h2>مرحباً بعودتك!</h2>
                    <p>قم بتسجيل الدخول للوصول إلى حسابك</p>
                </div>

                <form wire:submit="login">
                    <div class="input-group">
                        <input wire:model="form.email" 
                               type="email" 
                               placeholder="البريد الإلكتروني"
                               required>
                        <i class="fas fa-envelope"></i>
                    </div>
                    <x-input-error :messages="$errors->get('form.email')" class="mt-2" />

                    <div class="input-group">
                        <input wire:model="form.password" 
                               type="password" 
                               placeholder="كلمة المرور"
                               required>
                        <i class="fas fa-lock"></i>
                    </div>
                    <x-input-error :messages="$errors->get('form.password')" class="mt-2" />

                    <div class="remember-forgot">
                        <label class="remember-me">
                            <input wire:model="form.remember" type="checkbox">
                            <span>تذكرني</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" 
                               class="forgot-password" 
                               wire:navigate>
                                نسيت كلمة المرور؟
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="login-button">
                        <i class="fas fa-sign-in-alt ml-2"></i>
                        تسجيل الدخول
                    </button>

                    <div class="register-link">
                        <span>ليس لديك حساب؟</span>
                        <a href="{{ route('register') }}" wire:navigate>سجل الآن</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
