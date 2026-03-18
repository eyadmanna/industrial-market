@extends('layouts.app')

@section('content')
<div class="login-section">
    <div class="login-container">
        <div class="login-card">
            <!-- Logo -->
            <div class="login-logo">
                <img src="{{ asset('assets/logo.png') }}" alt="سوق العدد الصناعية" class="logo">
                <h2 class="login-title">تسجيل الدخول</h2>
                <p class="login-subtitle">لوحة التحكم - سوق العدد الصناعية</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Field -->
                <div class="login-field">
                    <label for="email" class="login-label">البريد الإلكتروني</label>
                    <div class="login-input-wrapper">
                        <span class="login-input-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="#1e3a5f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M22 6L12 13L2 6" stroke="#1e3a5f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <input id="email" type="email"
                               class="login-input @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}"
                               required autocomplete="email" autofocus
                               placeholder="أدخل بريدك الإلكتروني">
                    </div>
                    @error('email')
                        <span class="login-error" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="login-field">
                    <label for="password" class="login-label">كلمة المرور</label>
                    <div class="login-input-wrapper">
                        <span class="login-input-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" stroke="#1e3a5f" stroke-width="2"/>
                                <path d="M7 11V7C7 4.24 9.24 2 12 2C14.76 2 17 4.24 17 7V11" stroke="#1e3a5f" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <input id="password" type="password"
                               class="login-input @error('password') is-invalid @enderror"
                               name="password" required autocomplete="current-password"
                               placeholder="أدخل كلمة المرور">
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            👁️
                        </button>
                    </div>
                    @error('password')
                        <span class="login-error" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="login-options">
                    <label class="remember-checkbox">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                        <span class="remember-text">تذكرني</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="forgot-link" href="{{ route('password.request') }}">
                            نسيت كلمة المرور؟
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="login-button">
                    <span class="btn-text">دخول</span>
                    <span class="btn-arrow">←</span>
                </button>
            </form>

            <!-- Back to Home -->
            <div class="login-footer">
                <a href="{{ route('home') }}" class="back-home">
                    <span class="arrow">→</span>
                    العودة للصفحة الرئيسية
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Login Section Styles */
.login-section {
    min-height: 100vh;
    background: linear-gradient(135deg, #f5f7fa 0%, #e9edf5 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    direction: rtl;
    font-family: 'Cairo', sans-serif;
}

.login-container {
    max-width: 480px;
    width: 100%;
}

.login-card {
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

.login-logo {
    text-align: center;
    margin-bottom: 30px;
}

.login-logo .logo {
    width: 180px;
    height: auto;
    margin-bottom: 20px;
}

.login-title {
    font-size: 28px;
    font-weight: 900;
    color: #1e3a5f;
    margin: 0 0 5px;
}

.login-subtitle {
    font-size: 14px;
    color: #64748b;
    margin: 0;
}

.login-field {
    margin-bottom: 25px;
}

.login-label {
    display: block;
    font-size: 14px;
    font-weight: 700;
    color: #1e3a5f;
    margin-bottom: 8px;
}

.login-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.login-input-icon {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #1e3a5f;
    opacity: 0.7;
    z-index: 1;
}

.login-input {
    width: 100%;
    padding: 15px 50px 15px 50px;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 16px;
    font-family: 'Cairo', sans-serif;
    transition: all 0.3s ease;
    background: white;
}

.login-input:focus {
    outline: none;
    border-color: #f5a623;
    box-shadow: 0 0 0 3px rgba(245, 166, 35, 0.1);
}

.login-input.is-invalid {
    border-color: #dc3545;
    background-color: #fff8f8;
}

.password-toggle {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    font-size: 18px;
    opacity: 0.6;
    transition: opacity 0.3s ease;
    z-index: 1;
}

.password-toggle:hover {
    opacity: 1;
}

.login-error {
    display: block;
    font-size: 13px;
    color: #dc3545;
    margin-top: 5px;
    padding-right: 15px;
}

.login-options {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 25px;
}

.remember-checkbox {
    display: flex;
    align-items: center;
    cursor: pointer;
    font-size: 14px;
    color: #1e3a5f;
    position: relative;
    padding-right: 30px;
}

.remember-checkbox input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
}

.checkmark {
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    height: 20px;
    width: 20px;
    background-color: #fff;
    border: 2px solid #e2e8f0;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.remember-checkbox:hover input ~ .checkmark {
    border-color: #f5a623;
}

.remember-checkbox input:checked ~ .checkmark {
    background-color: #f5a623;
    border-color: #f5a623;
}

.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

.remember-checkbox input:checked ~ .checkmark:after {
    display: block;
}

.remember-checkbox .checkmark:after {
    right: 6px;
    top: 2px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

.remember-text {
    margin-right: 5px;
}

.forgot-link {
    color: #f5a623;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    transition: color 0.3s ease;
}

.forgot-link:hover {
    color: #d48c1c;
    text-decoration: underline;
}

.login-button {
    width: 100%;
    padding: 15px;
    background: linear-gradient(135deg, #f5a623 0%, #e09412 100%);
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
    box-shadow: 0 4px 15px rgba(245, 166, 35, 0.3);
}

.login-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(245, 166, 35, 0.4);
}

.login-button:active {
    transform: translateY(0);
}

.btn-arrow {
    font-size: 20px;
    line-height: 1;
}

.login-footer {
    text-align: center;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #e2e8f0;
}

.back-home {
    color: #1e3a5f;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: color 0.3s ease;
}

.back-home:hover {
    color: #f5a623;
}

.back-home .arrow {
    font-size: 18px;
    transition: transform 0.3s ease;
}

.back-home:hover .arrow {
    transform: translateX(-5px);
}

/* Responsive */
@media (max-width: 768px) {
    .login-card {
        padding: 30px 20px;
    }

    .login-title {
        font-size: 24px;
    }

    .login-logo .logo {
        width: 150px;
    }
}
</style>
@endpush

@push('scripts')
<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);

    // تغيير شكل الزر (اختياري)
    const toggleBtn = document.querySelector('.password-toggle');
    toggleBtn.textContent = type === 'password' ? '👁️' : '👁️‍🗨️';
}
</script>
@endpush
@endsection
