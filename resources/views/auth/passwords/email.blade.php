@extends('layouts.app')

@section('content')
<div class="reset-section">
    <div class="reset-container">
        <div class="reset-card">
            <div class="reset-logo">
                <img src="{{ asset('assets/logo.png') }}" alt="سوق العدد الصناعية" class="logo">
                <h2 class="reset-title">نسيت كلمة المرور</h2>
                <p class="reset-subtitle">أدخل بريدك الإلكتروني وسنرسل لك رابط إعادة التعيين</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="reset-field">
                    <label for="email" class="reset-label">البريد الإلكتروني</label>
                    <div class="reset-input-wrapper">
                        <span class="reset-input-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="#1e3a5f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M22 6L12 13L2 6" stroke="#1e3a5f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <input id="email" type="email"
                               class="reset-input @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}"
                               required autocomplete="email" autofocus
                               placeholder="أدخل بريدك الإلكتروني">
                    </div>
                    @error('email')
                        <span class="reset-error" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="reset-button">
                    <span class="btn-text">إرسال رابط إعادة التعيين</span>
                    <span class="btn-arrow">←</span>
                </button>
            </form>

            <div class="reset-footer">
                <a href="{{ route('login') }}" class="back-to-login">
                    <span class="arrow">→</span>
                    العودة لتسجيل الدخول
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Reset Password Section Styles */
.reset-section {
    min-height: 100vh;
    background: linear-gradient(135deg, #f5f7fa 0%, #e9edf5 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    direction: rtl;
    font-family: 'Cairo', sans-serif;
}

.reset-container {
    max-width: 480px;
    width: 100%;
}

.reset-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    padding: 40px;
    animation: slideUp 0.5s ease;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.reset-logo {
    text-align: center;
    margin-bottom: 30px;
}

.reset-logo .logo {
    width: 180px;
    height: auto;
    margin-bottom: 20px;
}

.reset-title {
    font-size: 28px;
    font-weight: 900;
    color: #1e3a5f;
    margin: 0 0 5px;
}

.reset-subtitle {
    font-size: 14px;
    color: #64748b;
    margin: 0;
}

/* Alert Styles */
.alert {
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 20px;
    font-size: 14px;
    text-align: center;
}

.alert-success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

.reset-field {
    margin-bottom: 25px;
}

.reset-label {
    display: block;
    font-size: 14px;
    font-weight: 700;
    color: #1e3a5f;
    margin-bottom: 8px;
}

.reset-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.reset-input-icon {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #1e3a5f;
    opacity: 0.7;
    z-index: 1;
}

.reset-input {
    width: 100%;
    padding: 15px 50px 15px 20px;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 16px;
    font-family: 'Cairo', sans-serif;
    transition: all 0.3s ease;
    background: white;
}

.reset-input:focus {
    outline: none;
    border-color: #f5a623;
    box-shadow: 0 0 0 3px rgba(245, 166, 35, 0.1);
}

.reset-input.is-invalid {
    border-color: #dc3545;
    background-color: #fff8f8;
}

.reset-error {
    display: block;
    font-size: 13px;
    color: #dc3545;
    margin-top: 5px;
    padding-right: 15px;
}

.reset-button {
    width: 100%;
    padding: 15px;
    background: linear-gradient(135deg, #1e3a5f 0%, #0f2a44 100%);
    border: none;
    border-radius: 12px;
    color: white;
    font-size: 18px;
    font-weight: 800;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(30, 58, 95, 0.3);
    margin-top: 20px;
}

.reset-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(30, 58, 95, 0.4);
}

.reset-button:active {
    transform: translateY(0);
}

.btn-arrow {
    font-size: 20px;
    line-height: 1;
}

.reset-footer {
    text-align: center;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #e2e8f0;
}

.back-to-login {
    color: #1e3a5f;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: color 0.3s ease;
}

.back-to-login:hover {
    color: #f5a623;
}

.back-to-login .arrow {
    font-size: 18px;
    transition: transform 0.3s ease;
}

.back-to-login:hover .arrow {
    transform: translateX(-5px);
}

/* Responsive */
@media (max-width: 768px) {
    .reset-card {
        padding: 30px 20px;
    }

    .reset-title {
        font-size: 24px;
    }

    .reset-logo .logo {
        width: 150px;
    }
}
</style>
@endpush
