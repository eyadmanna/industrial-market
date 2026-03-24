/**
 * view_js.js - نسخة خفيفة تعتمد على بيانات Laravel فقط
 */

// ─────────────────────────────────────────────────────────────────────────────
// 1. استقبال البيانات من Laravel (بدون قيم افتراضية)
// ─────────────────────────────────────────────────────────────────────────────

// ننتظر شوي للتأكد من تحميل البيانات
console.log('🔄 Checking for LaravelData...');

// التحقق من وجود البيانات
if (!window.LaravelData) {
    console.error('❌ لم يتم تحميل بيانات Laravel');
    console.log('⏳ انتظار 500ms ثم إعادة المحاولة...');

    // إعادة المحاولة بعد نصف ثانية
    setTimeout(() => {
        if (window.LaravelData) {
            console.log('✅ تم تحميل البيانات بعد انتظار');
            initializeApp(window.LaravelData);
        } else {
            console.error('❌ بيانات الموقع غير متوفرة');
        }
    }, 500);

    throw new Error('بيانات الموقع غير متوفرة');
}

console.log('✅ LaravelData found, initializing...');
initializeApp(window.LaravelData);

// ─────────────────────────────────────────────────────────────────────────────
// 2. الدالة الرئيسية للتطبيق
// ─────────────────────────────────────────────────────────────────────────────
function initializeApp(laravelData) {
    const {
        sliderData,
        sections,
        galleries,
        contactData,
        mapData,
        features,
        about
    } = laravelData;

    console.log('📊 Data received:', {
        sliderData, sections, galleries, contactData, mapData, features, about
    });

    // ─────────────────────────────────────────────────────────────────────────────
    // 3. CORE UTILITIES & HELPERS
    // ─────────────────────────────────────────────────────────────────────────────

    const $ = (sel) => document.querySelector(sel);
    const $$ = (sel) => Array.from(document.querySelectorAll(sel));
    const byId = (id) => document.getElementById(id);

    /** Unified IntersectionObserver for scroll-reveal animations */
    const revealObserver = (function() {
        if (!("IntersectionObserver" in window)) return null;
        return new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("is-visible");
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });
    })();

    function applyReveals() {
        const els = $$(".js-reveal");
        if (!revealObserver) {
            els.forEach(el => el.classList.add("is-visible"));
            return;
        }
        els.forEach(el => revealObserver.observe(el));
    }

    /** Smooth scrolling to target section */
    function scrollToSection(id) {
        const el = byId(id);
        const header = byId("site-header");
        const mobileNav = byId("menu-mobile");

        // Close mobile navigation if open
        if (mobileNav?.classList.contains("open")) {
            mobileNav.classList.remove("open");
            const toggleBtn = byId("menu-toggle");
            const menuIcon = byId("menu-icon");
            if (toggleBtn) toggleBtn.setAttribute("aria-expanded", "false");
            if (menuIcon) menuIcon.textContent = "☰";
        }

        if (el) {
            const headerHeight = header ? header.getBoundingClientRect().height : 0;
            const offsetPosition = el.getBoundingClientRect().top + window.scrollY - headerHeight;
            window.scrollTo({ top: offsetPosition, behavior: "smooth" });
        }
    }

    window.scrollToSection = scrollToSection;

    // ─────────────────────────────────────────────────────────────────────────────
    // 4. FEATURE MODULES
    // ─────────────────────────────────────────────────────────────────────────────

    /* --- Navigation & Header --- */
    function initNavigation() {
        // Scroll Triggers
        $$("[data-scroll]").forEach(btn => {
            btn.addEventListener("click", (e) => {
                e.preventDefault();
                const targetId = btn.getAttribute("data-scroll");
                if (targetId) scrollToSection(targetId);
            });
        });

        // Mobile Menu Toggle
        const toggleBtn = byId("menu-toggle");
        const mobileNav = byId("menu-mobile");
        if (toggleBtn && mobileNav) {
            toggleBtn.addEventListener("click", () => {
                const isOpen = mobileNav.classList.toggle("open");
                toggleBtn.setAttribute("aria-expanded", String(isOpen));
                const menuIcon = byId("menu-icon");
                if (menuIcon) menuIcon.textContent = isOpen ? "✕" : "☰";
                if (isOpen) updateActiveLink();
            });
        }

        // Active Link Highlighting
        function updateActiveLink() {
            const sections = $$("section[id]");
            const navBtns = $$(".nav-btn");
            const header = byId("site-header");
            const headerHeight = header ? header.getBoundingClientRect().height : 0;

            let current = "";
            sections.forEach(sec => {
                if (window.scrollY >= (sec.offsetTop - headerHeight - 10)) {
                    current = sec.getAttribute("id");
                }
            });
            navBtns.forEach(btn => {
                btn.classList.toggle("active", btn.getAttribute("data-scroll") === current);
            });
        }

        window.addEventListener("scroll", updateActiveLink);
        updateActiveLink();

        // Admin View Check
        if (window.location.pathname.startsWith("/admin")) {
            const header = byId("site-header");
            if (header) header.style.display = "none";
        }
    }

    /* --- Hero Slider --- */
    function initHeroSlider() {
        const hero = byId("hero");
        const indicators = byId("indicators");
        if (!hero || !indicators || !sliderData?.length) return;

        let currentIdx = 0;
        let timer;

        // Render slides and dots
        sliderData.forEach((slide, i) => {
            const slideDiv = document.createElement("div");
            slideDiv.className = `slide ${i === 0 ? "active" : ""}`;
            slideDiv.innerHTML = `
                <div class="slide-bg" style="background-image:url(${slide.image})"></div>
                <div class="slide-content">
                    <div class="slide-text">
                        <h2 class="slide-title">${slide.title}</h2>
                        <p class="slide-subtitle">${slide.subtitle}</p>
                        <div class="slide-buttons">
                            <button class="btn btn-primary" onclick="scrollToSection('contact')">&#9658; تواصل معنا</button>
                            <button class="btn btn-secondary" onclick="scrollToSection('map')">&#9658; الوصول للموقع </button>
                        </div>
                    </div>
                </div>
            `;
            hero.insertBefore(slideDiv, byId("prevBtn"));

            const dot = document.createElement("button");
            dot.className = `dot ${i === 0 ? "active" : ""}`;
            dot.setAttribute("aria-label", `شريحة ${i + 1}`);
            dot.onclick = () => goTo(i);
            indicators.appendChild(dot);
        });

        function goTo(index) {
            const slides = $$(".slide"), dots = $$(".dot");
            if (!slides[currentIdx] || !dots[currentIdx]) return;

            slides[currentIdx].classList.remove("active");
            dots[currentIdx].classList.remove("active");
            currentIdx = (index + sliderData.length) % sliderData.length;
            slides[currentIdx].classList.add("active");
            dots[currentIdx].classList.add("active");
            startTimer();
        }

        function startTimer() {
            clearInterval(timer);
            timer = setInterval(() => goTo(currentIdx + 1), 5000);
        }

        // تعديل أزرار السلايدر للغة العربية (RTL)
        byId("prevBtn")?.addEventListener("click", (e) => {
            e.preventDefault();
            // في RTL، الزر الأيسر (prev) يذهب للتالي
            goTo(currentIdx + 1);
        });

        byId("nextBtn")?.addEventListener("click", (e) => {
            e.preventDefault();
            // في RTL، الزر الأيمن (next) يذهب للسابق
            goTo(currentIdx - 1);
        });
        startTimer();
    }

    /* --- About Section --- */
    function initAbout() {
        const title = byId("about-title");
        if (title) title.textContent = about?.title || "نبذة عن السوق";

        [1, 2, 3].forEach((n, i) => {
            const p = byId(`about-p${n}`);
            if (p) p.textContent = about?.paragraphs?.[i] || "";
        });

        const bar = byId("about-bar");
        if (bar && features?.length) {
            bar.innerHTML = "";
            features.forEach((feat, i) => {
                const item = document.createElement("div");
                item.className = "about-item js-reveal";
                item.style.setProperty("--delay", `${300 + i * 100}ms`);

                item.innerHTML = `
                    <div class="about-icon"><img src="${feat.icon}" alt="${feat.label}" /></div>
                    <p class="about-label">${feat.label}</p>
                `;
                bar.appendChild(item);
            });
        }
    }

/* --- Departments Section --- */
function initDepartments() {
    const wrapper = byId("depts-slider-wrapper");
    const subtitle = byId("depts-subtitle");
    if (!wrapper || !sections?.length) return;

    wrapper.innerHTML = "";
    sections.forEach((dept, i) => {
        const slide = document.createElement("div");
        slide.className = "swiper-slide dept-slide js-reveal";
        slide.style.setProperty("--delay", `${220 + i * 50}ms`);

        let imageHtml = '';
        if (dept.image) {
            imageHtml = `<img class="dept-icon" src="${dept.image}" alt="${dept.name_ar}" />`;
        } else {
            imageHtml = `<img class="dept-icon" src="${window.LaravelData.assetPath}assets/media/icon-sex.png" alt="${dept.name_ar}" />`;
        }

        slide.innerHTML = `
            <div class="dept-card">
                ${imageHtml}
                <p class="dept-name">${dept.name_ar}</p>
            </div>
        `;
        wrapper.appendChild(slide);
    });

    new Swiper(".deptsSwiper", {
        slidesPerView: 1,
        grid: { rows: 1, fill: 'row' },
        spaceBetween: 20,
        navigation: { nextEl: "#depts-next", prevEl: "#depts-prev" },
        pagination: { el: "#depts-pagination", clickable: true, dynamicBullets: true },
        breakpoints: {
            400: { slidesPerView: 2, grid: { rows: 1 } },
            640: { slidesPerView: 2, grid: { rows: 2 } },
            1024: { slidesPerView: 3, grid: { rows: 2 } },
            1200: { slidesPerView: 4, grid: { rows: 2 } },
        },
    });
}

    /* --- Gallery Section --- */
    function initGallery() {
        const track = byId("gallery-track");
        if (!track || !galleries?.length) return;

        let currentIdx = 0;
        let autoplay;

        const countVisible = () => window.innerWidth <= 640 ? 1 : (window.innerWidth <= 1024 ? 2 : 3);
        const getMax = () => Math.max(0, galleries.length - countVisible());

        track.innerHTML = galleries.map(img => `
            <div class="gallery-slide">
                <div class="gallery-card">
                    <img class="gallery-image" src="${img.url}" alt="${img.alt || 'صورة من السوق'}">
                </div>
            </div>
        `).join("");

        const update = () => {
            currentIdx = Math.min(Math.max(0, currentIdx), getMax());
            track.style.transform = `translateX(${currentIdx * (100 / countVisible())}%)`;
        };

        const next = () => { currentIdx = currentIdx >= getMax() ? 0 : currentIdx + 1; update(); };
        const prev = () => { currentIdx = currentIdx <= 0 ? getMax() : currentIdx - 1; update(); };

        byId("gallery-next")?.addEventListener("click", next);
        byId("gallery-prev")?.addEventListener("click", prev);

        const wrap = $(".gallery-slider-wrap");
        const start = () => { clearInterval(autoplay); autoplay = setInterval(next, 3000); };
        const stop = () => clearInterval(autoplay);

        if (wrap) {
            wrap.onmouseenter = stop;
            wrap.onmouseleave = start;
        }

        window.addEventListener("resize", update);
        update();
        start();
    }

    /* --- Map Section --- */
    function initMap() {
        const label = byId("map-location-label");
        const button = byId("map-directions-btn");
        const iframe = byId("map-iframe");
        const image = byId("map-building-image");

        if (label && mapData?.locationLabel) {
            label.innerHTML = `<span class="label-arrow">◀</span> <span>${mapData.locationLabel}</span>`;
        }

        if (button && mapData?.directionsUrl) {
            button.href = mapData.directionsUrl;
        }

        if (iframe && mapData?.mapEmbedUrl) {
            iframe.src = mapData.mapEmbedUrl;
        }

        if (image && mapData?.buildingImage) {
            image.src = mapData.buildingImage;
        }
    }

    /* --- Contact Section --- */
    function initContact() {
        const wrap = byId("contact-info");
        if (!wrap || !contactData) return;

        const icons = {
            phone: `<svg width="34" height="34" viewBox="0 0 64 64" fill="none"><circle cx="32" cy="32" r="24" stroke="#f3f6fb" stroke-width="4" opacity=".9"/><path d="M25 18c2 12 9 20 21 28" stroke="#f3f6fb" stroke-width="5" stroke-linecap="round"/><path d="M40 39l6 7" stroke="#f3f6fb" stroke-width="5" stroke-linecap="round"/></svg>`,
            mail: `<svg width="34" height="34" viewBox="0 0 64 64" fill="none"><rect x="10" y="16" width="44" height="32" fill="#f3f6fb" opacity=".95"/><path d="M12 18l20 16 20-16" stroke="#6c7c96" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/></svg>`,
            pin: `<svg width="34" height="34" viewBox="0 0 64 64" fill="none"><path d="M32 10c-8 0-14 6-14 14 0 12 14 26 14 26s14-14 14-26c0-8-6-14-14-14Z" fill="#f5b400" stroke="#f3f6fb" stroke-width="3"/><circle cx="32" cy="24" r="5" fill="#f3f6fb"/></svg>`,
            time: `<svg width="34" height="34" viewBox="0 0 64 64" fill="none"><circle cx="32" cy="32" r="24" stroke="#f3f6fb" stroke-width="4"/><path d="M32 20v13l10 7" stroke="#f3f6fb" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/></svg>`,
        };

        wrap.innerHTML = `
            <div class="contact-info-item">
                <div class="contact-info-value-icon">
                    <div class="contact-info-icon">${icons.phone}</div>
                    <div class="contact-info-label">الهاتف</div>
                </div>
                <div class="contact-info-value-icon" id="contact-phone">
                    <div class="contact-info-value" style="direction:ltr">${contactData.phone}</div>
                    <div class="contact-info-icon">${icons.phone}</div>
                </div>
            </div>
            <div class="contact-info-item">
                <div class="contact-info-value-icon">
                    <div class="contact-info-icon">${icons.pin}</div>
                    <div class="contact-info-label">${contactData.addressLabel}</div>
                </div>
                <div class="contact-info-value-icon" id="contact-email">
                    <div class="contact-info-value">${contactData.email}</div>
                    <div class="contact-info-icon">${icons.mail}</div>
                </div>
            </div>
            <div class="contact-info-item">
                <div class="contact-info-value-icon">
                    <div class="contact-info-icon">${icons.time}</div>
                    <div class="contact-info-value small">
                        ${contactData.hours?.map(h => `<div>${h}</div>`).join("")}
                    </div>
                </div>
            </div>
        `;

        const form = byId("contact-form");
    }

    // ─────────────────────────────────────────────────────────────────────────────
    // 5. MAIN INITIALIZATION
    // ─────────────────────────────────────────────────────────────────────────────

    initNavigation();
    initHeroSlider();
    initAbout();
    initDepartments();
    initGallery();
    initMap();
    initContact();
    applyReveals();

    console.log('🚀 Application initialized successfully');
}
