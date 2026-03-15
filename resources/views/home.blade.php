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
    <!-- Slides injected by JS from database -->

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
            <p id="about-p1">يضم السوق هنجرًا متكاملًا مقسمًا إلى <strong>{{ $sections->count() }} قسمًا</strong></p>
            <p id="about-p2">كل قسم متخصص ويُدار بشكل مستقل</p>
            <p id="about-p3">الهدف تعريف الزوار بالسوق ككيان جامع وتسهيل الوصول</p>
        </div>

        <!-- Feature bar -->
        <div id="about-bar" class="about-bar js-reveal">
            @foreach($features as $feature)
            <div class="about-bar-item">
                <span class="about-bar-icon">{{ $feature['icon'] }}</span>
                <span class="about-bar-text">{{ $feature['text'] }}</span>
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
                يضم السوق {{ $sections->count() }} قسمًا متنوعًا
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
                        @foreach($sections as $section)
                        <div class="swiper-slide">
                            <div class="dept-card">
                                <span class="dept-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                <div class="dept-icon">{{ $section->icon }}</div>
                                <h3 class="dept-title">{{ $section->name_ar }}</h3>
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
                    <div class="gallery-item">
                        <img src="{{ asset('storage/' . $gallery->image_path) }}"
                             alt="{{ $gallery->title_ar ?? 'صورة من السوق' }}">
                    </div>
                    @empty
                    <div class="gallery-item">
                        <img src="{{ asset('assets/media/sample1.jpg') }}" alt="صورة من السوق">
                    </div>
                    <div class="gallery-item">
                        <img src="{{ asset('assets/media/sample2.jpg') }}" alt="صورة من السوق">
                    </div>
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
        <div class="map-title-row js-reveal">
            <div class="map-line"></div>
            <h2 class="map-title">موقعنا</h2>
            <div class="map-line"></div>
        </div>

        <!-- Main block -->
        <div class="map-card js-reveal">
            <!-- Right side: image + CTA -->
            <div class="map-right">
                <div class="map-image-wrap">
                    <img id="map-building-image" class="map-building-image"
                         src="{{ asset('assets/media/building.jpg') }}"
                         alt="موقع السوق" />

                    <div class="map-image-overlay"></div>

                    <div class="map-location-label" id="map-location-label">
                        <span class="label-arrow">◀</span>
                        <span>{{ $settings['address'] }}</span>
                    </div>

                    <a id="map-directions-btn" class="map-directions-btn"
                       href="{{ $settings['map_link'] }}"
                       target="_blank" rel="noopener noreferrer">
                        <span class="btn-arrow">›</span>
                        <span>احصل على اتجاهات</span>
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
                            <input id="contact-name" type="text" name="name" placeholder="الاسم" required />
                        </div>
                        <div class="input-group">
                            <input id="contact-subject" type="text" name="subject" placeholder="الموضوع" />
                        </div>
                    </div>

                    <div class="input-group textarea-group">
                        <textarea id="contact-message" name="message" placeholder="الرسالة" required></textarea>
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
                <div class="contact-info-item">
                    <span class="info-icon">📞</span>
                    <span class="info-text">{{ $settings['phone'] }}</span>
                </div>
                <div class="contact-info-item">
                    <span class="info-icon">✉️</span>
                    <span class="info-text">{{ $settings['email'] }}</span>
                </div>
                <div class="contact-info-item">
                    <span class="info-icon">🕒</span>
                    <span class="info-text">{{ $settings['working_hours'] }}</span>
                </div>
                <div class="contact-info-item">
                    <span class="info-icon">📍</span>
                    <span class="info-text">{{ $settings['address'] }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="footer-container">
        <div class="footer-content">
            <!-- Social Icons -->
            <div class="footer-social">
                <a href="#" class="social-icon whatsapp">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2a10 10 0 0 0-8.7 15l-1.3 5 5-1.3A10 10 0 1 0 12 2Z"/>
                    </svg>
                </a>

                <a href="#" class="social-icon instagram">
                    <svg viewBox="0 0 24 24">
                        <rect x="4" y="4" width="16" height="16" rx="5"/>
                        <circle cx="12" cy="12" r="4"/>
                    </svg>
                </a>

                <a href="#" class="social-icon skype">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 4c4.4 0 8 3 8 7s-3.6 7-8 7-8-3-8-7 3.6-7 8-7z"/>
                    </svg>
                </a>
            </div>

            <!-- Footer Text -->
            <p class="footer-text">
                سوق العدد الصناعية - جميع الحقوق محفوظة © {{ date('Y') }}
            </p>
        </div>
    </div>
</footer>
@endsection

@push('scripts')
<script>
// تهيئة Swiper بعد تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    // Departments Swiper
    new Swiper('.deptsSwiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        navigation: {
            prevEl: '#depts-prev',
            nextEl: '#depts-next',
        },
        pagination: {
            el: '#depts-pagination',
            clickable: true,
        },
        breakpoints: {
            640: { slidesPerView: 2 },
            768: { slidesPerView: 3 },
            1024: { slidesPerView: 4 },
        }
    });

    // معالجة نموذج الاتصال
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const responseDiv = document.getElementById('form-message');

            try {
                const response = await fetch('{{ route("contact.send") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();

                if (data.success) {
                    responseDiv.innerHTML = '<div class="alert alert-success">تم إرسال رسالتك بنجاح</div>';
                    this.reset();
                } else {
                    responseDiv.innerHTML = '<div class="alert alert-error">حدث خطأ، حاول مرة أخرى</div>';
                }
            } catch (error) {
                responseDiv.innerHTML = '<div class="alert alert-error">حدث خطأ في الاتصال</div>';
            }
        });
    }
});
</script>
@endpush
