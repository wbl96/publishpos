<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>وبل لحلول الأعمال</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
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
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background: var(--light);
            color: var(--dark);
            line-height: 1.6;
        }

        .navbar {
            background: var(--primary);
            padding: 1rem;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .nav-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--light);
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .nav-links {
            display: flex;
            gap: 1rem;
        }

        .nav-btn {
            color: var(--light);
            text-decoration: none;
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .login-btn {
            background: transparent;
            border: 2px solid var(--light);
        }

        .login-btn:hover {
            background: var(--light);
            color: var(--primary);
        }

        .register-btn {
            background: var(--secondary);
            border: 2px solid var(--secondary);
        }

        .register-btn:hover {
            background: #c0392b;
            border-color: #c0392b;
        }

        .hero {
            background: linear-gradient(135deg, var(--primary) 0%, #34495e 100%);
            padding: 6rem 0;
            text-align: center;
            color: var(--light);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
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

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 1rem;
            position: relative;
            z-index: 1;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.4rem;
            margin-bottom: 3rem;
            opacity: 0.9;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 4rem 1rem;
            background: var(--light);
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: var(--accent);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            color: var(--accent);
            background: #f8f9fa;
            width: 100px;
            height: 100px;
            line-height: 100px;
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            background: var(--accent);
            color: white;
            transform: rotateY(360deg);
        }

        .feature-title {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            font-weight: 600;
            color: var(--dark);
        }

        .feature-text {
            font-size: 1.1rem;
            color: #666;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .nav-content {
                flex-direction: column;
                gap: 1rem;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.2rem;
            }

            .features {
                grid-template-columns: 1fr;
                padding: 2rem 1rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="nav-content">
                <div class="logo">
                    <i class="fas fa-cloud"></i>
                    وبل لحلول الأعمال
                </div>
                <div class="nav-links">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="nav-btn">لوحة التحكم</a>
                        @else
                            <a href="{{ route('login') }}" class="nav-btn login-btn">تسجيل الدخول</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="nav-btn register-btn">حساب جديد</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <main>
        <section class="hero">
            <div class="hero-content">
                <h1 class="hero-title">حلول متكاملة لإدارة أعمالك</h1>
                <p class="hero-subtitle">نقدم لك أدوات احترافية لإدارة المبيعات، المخزون، والمصروفات بكفاءة عالية</p>
            </div>
        </section>

        <section class="container">
            <div class="features">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="feature-title">إدارة المبيعات</h3>
                    <p class="feature-text">نظام متطور لتتبع وإدارة المبيعات مع تقارير تفصيلية ورؤى تحليلية تساعدك في اتخاذ القرارات</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <h3 class="feature-title">إدارة المخزون</h3>
                    <p class="feature-text">تحكم كامل في المخزون مع نظام تنبيهات ذكي وإدارة فعالة للمنتجات والمستودعات</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <h3 class="feature-title">إدارة المصروفات</h3>
                    <p class="feature-text">نظام متكامل لتتبع وتحليل المصروفات مع تقارير مالية شاملة ومخططات بيانية احترافية</p>
                </div>
            </div>
        </section>
    </main>
</body>
</html>