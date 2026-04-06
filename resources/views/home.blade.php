@extends('layouts.app')

@section('content')
<!-- Header -->
<header id="site-header" class="site-header">
    <div class="container">
        <!-- Main nav -->
        <div class="mainbar">
            <div class="brand">
                <img src="{{ asset('assets/logo.png') }}" alt="this is logo" class="logo" />
            </div>

            <!-- Desktop Navigation -->
            <nav class="nav-desktop" aria-label="القائمة الرئيسية">
                <button class="nav-btn" data-scroll="hero">الرئيسية</button>
                <button class="nav-btn" data-scroll="about">من نحن</button>
                <button class="nav-btn" data-scroll="departments">أقسامنا</button>
                <button class="nav-btn" data-scroll="gallery">معرض الصور</button>
                <button class="nav-btn" data-scroll="map">موقعنا</button>
                <button class="nav-btn" data-scroll="contact">تواصل معنا</button>
            </nav>

            <!-- Mobile menu button -->
            <button id="menu-toggle" class="menu-toggle" aria-label="فتح/إغلاق القائمة" aria-expanded="false">
                <span id="menu-icon" aria-hidden="true">☰</span>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <nav id="menu-mobile" class="nav-mobile" aria-label="القائمة للموبايل">
            <button class="nav-btn mobile" data-scroll="hero">الرئيسية</button>
            <button class="nav-btn mobile" data-scroll="about">من نحن</button>
            <button class="nav-btn mobile" data-scroll="departments">أقسامنا</button>
            <button class="nav-btn mobile" data-scroll="gallery">معرض الصور</button>
            <button class="nav-btn mobile" data-scroll="map">موقعنا</button>
            <button class="nav-btn mobile" data-scroll="contact">تواصل معنا</button>
        </nav>
    </div>
</header>

<!-- Hero Section -->
<section id="hero">
    <!-- Slides will be injected by JS -->

    <!-- Prev Arrow -->
    <button class="nav-arrow nav-prev" id="prevBtn" aria-label="السابق">
        <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6" /></svg>
    </button>

    <!-- Next Arrow -->
    <button class="nav-arrow nav-next" id="nextBtn" aria-label="التالي">
        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6" /></svg>
    </button>

    <!-- Dots -->
    <div class="indicators" id="indicators"></div>
</section>

<!-- About Section -->
<section id="about" class="about">
    <div class="about-container">
        <!-- Title with lines -->
        <div class="section-title-wrap js-reveal">
            <div class="section-line"></div>
            <h2 id="about-title" class="section-title">نبذة عن السوق</h2>
            <div class="section-line"></div>
        </div>

        <!-- Description -->
        <div id="about-desc" class="section-subtitle js-reveal">
            <p>{{ $aboutDescription }}</p>
        </div>

        <!-- Feature bar -->
        <div id="about-bar" class="about-bar js-reveal">
            @foreach($features as $index => $feature)
            <div class="about-item js-reveal" style="--delay: {{ 300 + $index * 100 }}ms">
                <div class="about-icon">
                    <img src="{{ asset($feature['icon']) }}" alt="{{ $feature['label'] }}" />
                </div>
                <p class="about-label">{{ $feature['label'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Departments Section -->
<section id="departments" class="depts">
    <div class="dept-container">
        <div class="depts-wrap">
            <!-- Title row with lines -->
            <div class="section-title-wrap js-reveal">
                <div class="section-line"></div>
                <h2 class="section-title">أقسام السوق</h2>
                <div class="section-line"></div>
            </div>

            <p id="depts-subtitle" class="section-subtitle js-reveal">
                {{ $departmentsDescription }}
            </p>

            <!-- Slider area -->
            <div class="depts-slider-outer js-reveal">
                <!-- Navigation -->
                <button class="nav-arrow left" id="depts-prev" aria-label="السابق">
                    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6" /></svg>
                </button>
                <button class="nav-arrow right" id="depts-next" aria-label="التالي">
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6" /></svg>
                </button>

                <div class="depts-slider swiper deptsSwiper">
                    <div class="swiper-wrapper" id="depts-slider-wrapper">
                        @foreach($sections as $index => $section)
                        <div class="swiper-slide dept-slide js-reveal" style="--delay: {{ 220 + $index * 50 }}ms">
                            <div class="dept-card">
                                @if($section->image)
                                    <img class="dept-icon" src="{{ asset('storage/' . $section->image) }}"
                                        alt="{{ $section->name_ar }}" />
                                @else
                                    <div class="dept-icon dept-emoji">🏭</div>
                                @endif
                                <p class="dept-name">{{ $section->name_ar }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pagination -->
                <div class="swiper-pagination" id="depts-pagination"></div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section id="gallery" class="gallery-section">
    <div class="gallery-container">
        <!-- Title -->
        <div class="section-title-wrap js-reveal">
            <div class="section-line"></div>
            <h2 class="section-title">معرض الصور</h2>
            <div class="section-line"></div>
        </div>

        <!-- Slider -->
        <div class="gallery-slider-wrap js-reveal">
            <button id="gallery-prev" class="nav-arrow left" aria-label="السابق">
                <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6" /></svg>
            </button>

            <div class="gallery-viewport">
                <div id="gallery-track" class="gallery-track">
                    @forelse($galleries as $gallery)
                    <div class="gallery-slide">
                        <div class="gallery-card">
                            <img class="gallery-image" src="{{ asset('storage/' . $gallery->image_path) }}"
                                alt="{{ $gallery->title_ar ?? 'صورة من السوق' }}">
                        </div>
                    </div>
                    @empty
                    @foreach(range(1, 6) as $i)
                    <div class="gallery-slide">
                        <div class="gallery-card">
                            <img class="gallery-image" src="{{ asset('assets/media/placeholder.jpg') }}"
                                alt="صورة من السوق">
                        </div>
                    </div>
                    @endforeach
                    @endforelse
                </div>
            </div>

            <button id="gallery-next" class="nav-arrow right" aria-label="التالي">
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6" /></svg>
            </button>
        </div>
    </div>
</section>

<!-- Map Section -->
<section id="map" class="map-section">
    <div class="map-container">
        <!-- Title -->
        <div class="map-title-column js-reveal">
      <div class="map-title-row js-reveal">
        <div class="map-line"></div>
      <h2 class="map-title">موقعنا</h2>
      <div class="map-line"></div>
      </div>
      <div class="map-location-label" id="map-location-label">

            </div>
    </div>

        <!-- Main block -->
        <div class="map-card js-reveal">
            <!-- Right side: image + CTA -->
            <div class="map-right">
                <div class="map-image-wrap">
                    <img id="map-building-image" class="map-building-image"
                         src="{{ asset($mapData['building_image'] ?? 'assets/media/building.jpg') }}"
                         alt="موقع السوق" />

                    <div class="map-image-overlay"></div>

                   <a
                        id="map-directions-btn"
                        class="map-directions-btn"
                        href="https://maps.google.com/maps?q={{ $settings['map_location'] }}"
                        target="_blank" rel="noopener noreferrer">
                        <span class="btn-arrow">›</span>
                        <span> اضفط  للذهاب الموقع </span>
          </a>
                </div>
            </div>

            <!-- Left side: real map -->
            <div class="map-left">
                <div class="map-real-wrap js-reveal">
                    <iframe id="map-iframe"
                        src="https://maps.google.com/maps?q={{ $settings['map_location'] }}&output=embed"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="contact-section">
    <div class="contact-overlay"></div>

    <div class="contact-container">
        <!-- Title -->
        <div class="section-title-wrap js-reveal">
            <div class="section-line"></div>
            <h2 class="section-title">تواصل معنا</h2>
            <div class="section-line"></div>
        </div>

        <div class="contact-content">
            <!-- Right: Form -->
            <div class="contact-form-wrap js-reveal">
                <form id="contact-form" class="contact-form" novalidate>
                    @csrf
                    <div class="contact-form-row">
                        <div class="input-group">
                            <input id="contact-name" type="text" name="name"
                                placeholder="الاسم *"
                                required
                                minlength="3"
                                maxlength="255" />
                            <small class="field-hint" style="display: block; color: rgba(255,255,255,0.5); font-size: 12px; margin-top: 5px;">
                                الحد الأدنى 3 أحرف
                            </small>
                        </div>
                        <div class="input-group">
                            <input id="contact-phone" type="text" name="phone"
                                placeholder="رقم الجوال *"
                                required
                                minlength="10"
                                maxlength="20" />
                            <small class="field-hint" style="display: block; color: rgba(255,255,255,0.5); font-size: 12px; margin-top: 5px;">
                                مثال: 05xxxxxxxx
                            </small>
                        </div>
                    </div>

                    <div id="textarea-group" class="input-group textarea-group">
                        <textarea id="contact-message" name="message"
                                placeholder="الرسالة *"
                                required
                                minlength="10"></textarea>
                        <small class="field-hint" style="display: block; color: rgba(255,255,255,0.5); font-size: 12px; margin-top: 5px;">
                            الحد الأدنى 10 أحرف
                        </small>
                    </div>

                    <div class="contact-submit-row">
                        <button type="submit" class="contact-submit-btn">
                            <span class="btn-arrow">›</span>
                            <span>إرسال</span>
                        </button>
                    </div>
                    <div id="form-message" class="form-message"></div>
                </form>
            </div>

            <!-- Left: Info -->
            <div class="contact-info js-reveal" id="contact-info">
                <!-- الهاتف -->
                <div class="contact-info-item">
                    <div class="contact-info-value-icon">
                        <div class="contact-info-icon">

    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.86 19.86 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.86 19.86 0 0 1 2.08 4.18 2 2 0 0 1 4.06 2h3a2 2 0 0 1 2 1.72c.12.9.33 1.78.63 2.63a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.45-1.15a2 2 0 0 1 2.11-.45c.85.3 1.73.51 2.63.63A2 2 0 0 1 22 16.92z"></path>
    </svg>

                        </div>
                        <div class="contact-info-label">الهاتف</div>
                    </div>
                    <div class="contact-info-value-icon contact-value">
                        <div class="contact-info-value" style="direction:ltr">{{ $settings['phone'] }}</div>
                    </div>
                </div>

                <!-- البريد الإلكتروني -->
                <div class="contact-info-item">
                    <div class="contact-info-value-icon ">
                        <div class="contact-info-icon">
                            <svg width="34" height="34" viewBox="0 0 64 64" fill="none">
                                <rect x="10" y="16" width="44" height="32" fill="#f3f6fb" opacity=".95"/>
                                <path d="M12 18l20 16 20-16" stroke="#6c7c96" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="contact-info-label">البريد الإلكتروني</div>
                    </div>
                    <div class="contact-info-value-icon contact-value">
                        <div class="contact-info-value" style="direction:ltr">{{ $settings['email'] }}</div>
                    </div>
                </div>

                <!-- العنوان -->
                <div class="contact-info-item">
                    <div class="contact-info-value-icon contact-value">
                        <div class="contact-info-icon">
                            <svg width="34" height="34" viewBox="0 0 64 64" fill="none">
                                <path d="M32 10c-8 0-14 6-14 14 0 12 14 26 14 26s14-14 14-26c0-8-6-14-14-14Z" fill="#f5b400" stroke="#f3f6fb" stroke-width="3"/>
                                <circle cx="32" cy="24" r="5" fill="#f3f6fb"/>
                            </svg>
                        </div>
                        <div class="contact-info-label">{{ $settings['address'] }}</div>
                    </div>
                </div>

                <!-- وسائل التواصل الاجتماعي -->
                <div class="contact-info-item">
                    <div class="contact-info-value-icon">
                        <div class="contact-info-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="18" cy="5" r="3"></circle>
        <circle cx="6" cy="12" r="3"></circle>
        <circle cx="18" cy="19" r="3"></circle>
        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
        <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
    </svg>
                        </div>
                        <div class="contact-info-label">تابعونا على</div>
                    </div>
                    <div class="contact-info-value-icon contact-value">
                        <div class="social-links-flex">
                            <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="contact-social-btn facebook">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                                </svg>
                            </a>
                            <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="contact-social-btn instagram">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                </svg>
                            </a>

                           <a href="https://www.tiktok.com/@yourusername" target="_blank" rel="noopener noreferrer" class="contact-social-btn tiktok">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
        <path d="M19.589 6.686a4.793 4.793 0 0 1-3.77-1.88V14.2a5.379 5.379 0 1 1-5.379-5.379c.298 0 .59.027.874.077v2.802a2.575 2.575 0 1 0 1.63 2.4V2h2.875a4.8 4.8 0 0 0 3.77 1.88v2.806z"/>
    </svg>
</a>
                        </div>
                    </div>
                </div>

        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="footer-container">
        <div class="footer-content">


            <!-- Footer Text -->
            <p class="footer-text">
                سوق العدد الصناعية - جميع الحقوق محفوظة © {{ date('Y') }}
            </p>
        </div>
    </div>
</footer>
@endsection

@push('scripts')
<?php
// تجهيز البيانات في PHP أولاً
$processedSections = $sections->map(function($section) {
    return [
        'id' => $section->id,
        'name_ar' => $section->name_ar,
        'image' => $section->image ? asset('storage/' . $section->image) : null,
        'order' => $section->order
    ];
});

$processedGalleries = $galleries->map(function($gallery) {
    return [
        'id' => $gallery->id,
        'url' => $gallery->image_path ? asset('storage/' . $gallery->image_path) : null,
        'alt' => $gallery->title_ar ?? 'صورة من السوق'
    ];
});
?>

<script>
// تمرير البيانات المجهزة من Laravel إلى JavaScript
window.LaravelData = {
    sliderData: @json($sliderData),
    sections: @json($processedSections),
    galleries: @json($processedGalleries),
    contactData: @json($contactData),
    mapData: @json($mapData),
    features: @json($features),
    assetPath: '{{ asset('') }}'
};

console.log('✅ LaravelData loaded:', window.LaravelData);


document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contact-form');

    if (contactForm) {
        // دالة مساعدة لإظهار الإشعارات
        function showNotification(type, message, errors = null) {
            // إزالة أي إشعار سابق
            const oldNotification = document.querySelector('.custom-notification');
            if (oldNotification) {
                oldNotification.remove();
            }

            // إنشاء عنصر الإشعار
            const notification = document.createElement('div');
            notification.className = 'custom-notification';
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                left: 50%;
                transform: translateX(-50%);
                background: ${type === 'success' ? '#4CAF50' : '#f44336'};
                color: white;
                padding: 15px 30px;
                border-radius: 8px;
                z-index: 9999;
                font-size: 16px;
                font-weight: bold;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                direction: rtl;
                max-width: 90%;
                text-align: center;
                animation: slideDown 0.3s ease;
            `;

            // إضافة animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes slideDown {
                    from {
                        top: -100px;
                        opacity: 0;
                    }
                    to {
                        top: 20px;
                        opacity: 1;
                    }
                }
            `;
            document.head.appendChild(style);

            // محتوى الإشعار
            let messageHtml = (type === 'success' ? '✅ ' : '❌ ') + message;

            // إضافة الأخطاء إن وجدت
            if (errors) {
                messageHtml += '<br><small style="font-size: 14px; opacity: 0.9;">';
                Object.values(errors).forEach(error => {
                    messageHtml += '• ' + error[0] + '<br>';
                });
                messageHtml += '</small>';
            }

            notification.innerHTML = messageHtml;
            document.body.appendChild(notification);

            // إخفاء الإشعار بعد 5 ثواني
            setTimeout(() => {
                notification.style.animation = 'slideDown 0.3s reverse';
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        }

        // دالة لإزالة علامات التحقق القديمة
        function removeValidationStyles() {
            document.querySelectorAll('.input-group input, .input-group textarea').forEach(field => {
                field.style.borderColor = '';
                field.style.backgroundColor = '';
            });
        }

        // دالة لإظهار أخطاء التحقق
        function showValidationErrors(errors) {
            removeValidationStyles();

            // تحديد الحقول التي بها أخطاء
            const fieldMappings = {
                'name': 'contact-name',
                'phone': 'contact-phone',
                'message': 'contact-message'
            };

            Object.keys(errors).forEach(field => {
                const elementId = fieldMappings[field];
                if (elementId) {
                    const element = document.getElementById(elementId);
                    if (element) {
                        element.style.borderColor = '#f44336';
                        element.style.backgroundColor = 'rgba(244, 67, 54, 0.05)';
                    }
                }
            });
        }

        contactForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            // إزالة أنماط التحقق القديمة
            removeValidationStyles();

            // جمع البيانات
            const formData = new FormData();
            const name = document.getElementById('contact-name')?.value.trim() || '';
            const phone = document.getElementById('contact-phone')?.value.trim() || '';
            const message = document.getElementById('contact-message')?.value.trim() || '';

            formData.append('name', name);
            formData.append('phone', phone);
            formData.append('message', message);
            formData.append('_token', '{{ csrf_token() }}');

            // تعطيل الزر أثناء الإرسال
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="btn-arrow">⟳</span> <span>جاري الإرسال...</span>';
            submitBtn.disabled = true;

            try {
                const response = await fetch('{{ route("contact.send") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // نجاح الإرسال
                    showNotification('success', data.message);
                    contactForm.reset();
                } else {
                    // فشل الإرسال
                    if (data.errors) {
                        showNotification('error', 'يرجى تصحيح الأخطاء في النموذج');
                        showValidationErrors(data.errors);
                    } else {
                        showNotification('error', data.message || 'حدث خطأ في الإرسال');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('error', 'حدث خطأ في الاتصال بالخادم');
            } finally {
                // إعادة الزر لحالته الطبيعية
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });
    }
});
</script>
@endpush
