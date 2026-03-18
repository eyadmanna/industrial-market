@extends('layouts.app')

@section('content')
<div class="reset-section">
    <div class="reset-container">
        <div class="reset-card">
            <!-- Logo -->
            <div class="reset-logo">
                <img src="{{ asset('assets/logo.png') }}" alt="سوق العدد الصناعية" class="logo">
                <h2 class="reset-title">إعادة تعيين كلمة المرور</h2>
                <p class="reset-subtitle">أدخل بريدك الإلكتروني وكلمة المرور الجديدة</p>
            </div>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Email Field -->
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
                               name="email" value="{{ $email ?? old('email') }}"
                               required autocomplete="email" autofocus
                               placeholder="أدخل بريدك الإلكتروني">
                    </div>
                    @error('email')
                        <span class="reset-error" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- New Password Field -->
                <div class="reset-field">
                    <label for="password" class="reset-label">كلمة المرور الجديدة</label>
                    <div class="reset-input-wrapper">
                        <span class="reset-input-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" stroke="#1e3a5f" stroke-width="2"/>
                                <path d="M7 11V7C7 4.24 9.24 2 12 2C14.76 2 17 4.24 17 7V11" stroke="#1e3a5f" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <input id="password" type="password"
                               class="reset-input @error('password') is-invalid @enderror"
                               name="password" required autocomplete="new-password"
                               placeholder="أدخل كلمة المرور الجديدة">
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            👁️
                        </button>
                    </div>
                    @error('password')
                        <span class="reset-error" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div class="reset-field">
                    <label for="password-confirm" class="reset-label">تأكيد كلمة المرور</label>
                    <div class="reset-input-wrapper">
                        <span class="reset-input-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" stroke="#1e3a5f" stroke-width="2"/>
                                <path d="M7 11V7C7 4.24 9.24 2 12 2C14.76 2 17 4.24 17 7V11" stroke="#1e3a5f" stroke-width="2" stroke-linecap="round"/>
                                <path d="M12 15V19" stroke="#1e3a5f" stroke-width="2" stroke-linecap="round"/>
                                <circle cx="12" cy="17" r="1" fill="#1e3a5f"/>
                            </svg>
                        </span>
                        <input id="password-confirm" type="password"
                               class="reset-input"
                               name="password_confirmation" required autocomplete="new-password"
                               placeholder="أعد إدخال كلمة المرور">
                        <button type="button" class="password-toggle" onclick="togglePassword('password-confirm')">
                            👁️
                        </button>
                    </div>
                </div>

                <!-- Password Strength Indicator -->
                <div class="password-strength" id="password-strength" style="display: none;">
                    <div class="strength-bar">
                        <div class="strength-fill" id="strength-fill"></div>
                    </div>
                    <span class="strength-text" id="strength-text"></span>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="reset-button">
                    <span class="btn-text">تأكيد وإعادة تعيين</span>
                    <span class="btn-arrow">←</span>
                </button>
            </form>

            <!-- Back to Login -->
            <div class="reset-footer">
                <a href="{{ route('login') }}" class="back-to-login">
                    <span class="arrow">→</span>
                    العودة لتسجيل الدخول
                </a>
            </div>
        </div>
    </div>
</div>

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
    padding: 15px 50px 15px 50px;
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

.reset-error {
    display: block;
    font-size: 13px;
    color: #dc3545;
    margin-top: 5px;
    padding-right: 15px;
}

/* Password Strength Indicator */
.password-strength {
    margin: -10px 0 20px;
    padding: 0 5px;
}

.strength-bar {
    height: 4px;
    background: #e2e8f0;
    border-radius: 2px;
    overflow: hidden;
    margin-bottom: 5px;
}

.strength-fill {
    height: 100%;
    width: 0;
    border-radius: 2px;
    transition: width 0.3s ease, background-color 0.3s ease;
}

.strength-fill.weak {
    background-color: #dc3545;
}

.strength-fill.medium {
    background-color: #f5a623;
}

.strength-fill.strong {
    background-color: #28a745;
}

.strength-text {
    font-size: 12px;
    color: #64748b;
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

@push('scripts')
<script>
function togglePassword(fieldId) {
    const passwordInput = document.getElementById(fieldId);
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);

    // تغيير شكل الزر
    const toggleBtn = event.target;
    toggleBtn.textContent = type === 'password' ? '👁️' : '👁️‍🗨️';
}

// Password strength checker
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const strengthDiv = document.getElementById('password-strength');
    const strengthFill = document.getElementById('strength-fill');
    const strengthText = document.getElementById('strength-text');

    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;

            if (password.length === 0) {
                strengthDiv.style.display = 'none';
                return;
            }

            strengthDiv.style.display = 'block';

            // Check password strength
            let strength = 0;
            let feedback = '';

            // Length check
            if (password.length >= 8) strength += 25;

            // Contains number
            if (/\d/.test(password)) strength += 25;

            // Contains lowercase
            if (/[a-z]/.test(password)) strength += 25;

            // Contains uppercase or special character
            if (/[A-Z]/.test(password) || /[^a-zA-Z0-9]/.test(password)) strength += 25;

            // Update UI
            strengthFill.style.width = strength + '%';

            if (strength <= 25) {
                strengthFill.className = 'strength-fill weak';
                strengthText.textContent = 'كلمة مرور ضعيفة';
            } else if (strength <= 50) {
                strengthFill.className = 'strength-fill weak';
                strengthText.textContent = 'كلمة مرور ضعيفة';
            } else if (strength <= 75) {
                strengthFill.className = 'strength-fill medium';
                strengthText.textContent = 'كلمة مرور متوسطة';
            } else {
                strengthFill.className = 'strength-fill strong';
                strengthText.textContent = 'كلمة مرور قوية';
            }
        });
    }
});
</script>
@endpush
@endsection
