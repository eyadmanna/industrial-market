/**
 * view_js.js
 * Comprehensive Maintenance-First Refactor.
 * Clean modular structure tracking all site data and interactive features.
 */

// ─────────────────────────────────────────────────────────────────────────────
// 1. DATA SOURCES
// ─────────────────────────────────────────────────────────────────────────────

const headerData = {
  contact: {
    phone: "+966500000000",
    email: "info@example.com",
  },
};

const sliderData = [
  {
    image: "assets/first-hero.jpeg",
    title: "سوق العدد الصناعية",
    subtitle: "موقع واحد يضم نخبة من موردي العدد الصناعية",
  },
  {
    image: "assets/second-hero.jpeg",
    title: "أفضل سوق العدد الصناعية",
    subtitle: "نوفر لك أحدث العدد وأكثرها كفاءة من أبرز الموردين",
  },
  {
    image: "assets/first-hero.jpeg",
    title: "شركاء النجاح الصناعي",
    subtitle: "نربطك بأفضل موردي العدد الصناعية في المنطقة",
  },
];

const dataAbout = {
  title: "نبذة عن السوق",
  paragraphs: [
    "يقدم سوق العدد الصناعية خدمات متكاملة تشمل 14 قسم إلى أسماء.",
    "نهدف لتقديم كل ما يخدم عملاءنا في جهة واحدة، مع أفضل العدد الصناعية.",
    "مما يجعل السوق وجهة آمنة تلبي احتياجات القطاع الصناعي المتنوع.",
  ],
  features: [
    { label: "سهولة الوصول", icon: "assets/about-icon-one.png" },
    { label: "تنظيم واضح", icon: "assets/about-icon-two.png" },
    { label: "تخصصات متعددة", icon: "assets/about-icon-three.png" },
    { label: "موقع واحد", icon: "assets/about-icon-four.png" },
  ],
};

const DepartmentsData = [
  { id: 1, name: "عدد دق الخرسانة", icon: "assets/icon-one.png" },
  { id: 2, name: "أدوات وبنّاء", icon: "assets/icon-two.png" },
  { id: 3, name: "مكائن لحام", icon: "assets/icon-three.png" },
  { id: 4, name: "عدد أسفلت", icon: "assets/icon-four.png" },
  { id: 5, name: "عدد ميكانيكية", icon: "assets/icon-five.png" },
  { id: 6, name: "عدد سباكة", icon: "assets/icon-sex.png" },
  { id: 7, name: "عدد هيدروليك", icon: "assets/icon-seven.png" },
  { id: 8, name: "تحضير/رمل/قص", icon: "assets/icon-eight.png" },
  { id: 9, name: "عدد محلات", icon: "assets/icon-nine.png" },
  { id: 10, name: "سهولة الوصول", icon: "assets/icon-ten.png" },
  { id: 11, name: "عدد هيدروليك", icon: "assets/icon-seven.png" },
  { id: 12, name: "تحضير/رمل/قص", icon: "assets/icon-eight.png" },
  { id: 13, name: "عدد محلات", icon: "assets/icon-nine.png" },
  { id: 14, name: "سهولة الوصول", icon: "assets/icon-ten.png" },
];

const galleryData = [
  { id: 1, url: "assets/first-hero.jpeg", alt: "المعرض 1" },
  { id: 2, url: "assets/second-hero.jpeg", alt: "المعرض 2" },
  { id: 3, url: "assets/first-hero.jpeg", alt: "المعرض 3" },
  { id: 4, url: "assets/second-hero.jpeg", alt: "المعرض 4" },
  { id: 5, url: "assets/first-hero.jpeg", alt: "المعرض 5" },
  { id: 6, url: "assets/second-hero.jpeg", alt: "المعرض 6" },
];

const mapData = {
  locationLabel: "المنطقة - الصناعية - المدينة",
  directionsUrl: "https://www.google.com/maps/place/%D8%B3%D9%88%D9%82+%D8%A7%D9%84%D8%B9%D8%AF%D8%AF+%D8%A7%D9%84%D8%B5%D9%86%D8%A7%D8%B9%D9%8A%D8%A9%E2%80%AD/@21.5185334,39.2503431,17z/data=!3m1!4b1!4m6!3m5!1s0x15c3cd0087717f63:0x1e34227044a23ef8!8m2!3d21.5185334!4d39.2503431!16s%2Fg%2F11tcj73zc9!17m2!4m1!1e3!18m1!1e1?entry=ttu&g_ep=EgoyMDI2MDMwNC4xIKXMDSoASAFQAw%3D%3D",
  buildingImage: "assets/image-map.jpg",
  mapEmbedUrl: "https://www.google.com/maps?q=21.5185334,39.2503431&hl=ar&z=17&output=embed",
};

const contactData = {
  phone: "+966 50 553 5649",
  email: "info@itm-sa.com",
  addressLabel: "حي النخيل - جده - المملكة العربية السعودية",
  hours: [
    "الأحد - الخميس : 8:00 ص - 8:00 م",
    "السبت : 9:00 ص - 6:00 م",
  ],
};

// ─────────────────────────────────────────────────────────────────────────────
// 2. CORE UTILITIES & HELPERS
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

// ─────────────────────────────────────────────────────────────────────────────
// 3. FEATURE MODULES
// ─────────────────────────────────────────────────────────────────────────────

/* --- Navigation & Header --- */
function initNavigation() {
  // 1. Contact Links
  const phone = headerData.contact.phone;
  const email = headerData.contact.email;
  const phoneLink = byId("phone-link"), phoneText = byId("phone-text");
  const emailLink = byId("email-link"), emailText = byId("email-text");

  if (phoneLink) phoneLink.href = `tel:${phone}`;
  if (phoneText) phoneText.textContent = phone;
  if (emailLink) emailLink.href = `mailto:${email}`;
  if (emailText) emailText.textContent = email;

  // 2. Scroll Triggers
  $$("[data-scroll]").forEach(btn => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      const targetId = btn.getAttribute("data-scroll");
      if (targetId) scrollToSection(targetId);
    });
  });

  // 3. Mobile Menu Toggle
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

  // 4. Active Link Highlighting
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

  // 5. Admin View Check
  if (window.location.pathname.startsWith("/admin")) {
    const header = byId("site-header");
    if (header) header.style.display = "none";
  }
}

/* --- Hero Slider --- */
function initHeroSlider() {
  const hero = byId("hero");
  const indicators = byId("indicators");
  if (!hero || !indicators) return;

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
            <button class="btn btn-secondary" onclick="scrollToSection('map')">&#9658; اعرف الموقع</button>
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

  byId("prevBtn")?.addEventListener("click", (e) => { e.preventDefault(); goTo(currentIdx - 1); });
  byId("nextBtn")?.addEventListener("click", (e) => { e.preventDefault(); goTo(currentIdx + 1); });

  startTimer();
}

/* --- About Section --- */
function initAbout() {
  const title = byId("about-title");
  if (title) title.textContent = dataAbout.title;

  [1, 2, 3].forEach((n, i) => {
    const p = byId(`about-p${n}`);
    if (p) p.textContent = dataAbout.paragraphs[i] || "";
  });

  const bar = byId("about-bar");
  if (bar) {
    bar.innerHTML = "";
    dataAbout.features.forEach((feat, i) => {
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
  if (!wrapper) return;

  if (subtitle) {
    subtitle.textContent = `يضم السوق ${DepartmentsData.length} قسماً متخصصاً .. كل قسم مستقل ومتخصص في مجال عمل محدد`;
  }

  wrapper.innerHTML = "";
  DepartmentsData.forEach((dept, i) => {
    const slide = document.createElement("div");
    slide.className = "swiper-slide dept-slide js-reveal";
    slide.style.setProperty("--delay", `${220 + i * 50}ms`);
    slide.innerHTML = `
      <div class="dept-card">
        <img class="dept-icon" src="${dept.icon}" alt="${dept.name}" />
        <p class="dept-name">${dept.name}</p>
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
  if (!track) return;

  let currentIdx = 0;
  let autoplay;

  const countVisible = () => window.innerWidth <= 640 ? 1 : (window.innerWidth <= 1024 ? 2 : 3);
  const getMax = () => Math.max(0, galleryData.length - countVisible());

  track.innerHTML = galleryData.map(img => `
    <div class="gallery-slide">
      <div class="gallery-card"><img class="gallery-image" src="${img.url}" alt="${img.alt}"></div>
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

  if (label) label.innerHTML = `<span class="label-arrow">◀</span> <span>${mapData.locationLabel}</span>`;
  if (button) button.href = mapData.directionsUrl;
  if (iframe) iframe.src = mapData.mapEmbedUrl;
  if (image) image.src = mapData.buildingImage;
}

/* --- Contact Section --- */
function initContact() {
  const wrap = byId("contact-info");
  if (!wrap) return;

  const icons = {
    phone: `<svg width="34" height="34" viewBox="0 0 64 64" fill="none"><circle cx="32" cy="32" r="24" stroke="#f3f6fb" stroke-width="4" opacity=".9"/><path d="M25 18c2 12 9 20 21 28" stroke="#f3f6fb" stroke-width="5" stroke-linecap="round"/><path d="M40 39l6 7" stroke="#f3f6fb" stroke-width="5" stroke-linecap="round"/></svg>`,
    mail: `<svg width="34" height="34" viewBox="0 0 64 64" fill="none"><rect x="10" y="16" width="44" height="32" fill="#f3f6fb" opacity=".95"/><path d="M12 18l20 16 20-16" stroke="#6c7c96" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/></svg>`,
    pin: `<svg width="34" height="34" viewBox="0 0 64 64" fill="none"><path d="M32 10c-8 0-14 6-14 14 0 12 14 26 14 26s14-14 14-26c0-8-6-14-14-14Z" fill="#f5b400" stroke="#f3f6fb" stroke-width="3"/><circle cx="32" cy="24" r="5" fill="#f3f6fb"/></svg>`,
    time: `<svg width="34" height="34" viewBox="0 0 64 64" fill="none"><circle cx="32" cy="32" r="24" stroke="#f3f6fb" stroke-width="4"/><path d="M32 20v13l10 7" stroke="#f3f6fb" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/></svg>`,
  };

  wrap.innerHTML = `
    <div class="contact-info-item">
      <div class="contact-info-value-icon"><div class="contact-info-icon">${icons.phone}</div><div class="contact-info-label">الهاتف</div></div>
      <div class="contact-info-value-icon" id="contact-phone"><div class="contact-info-value" style="direction:ltr">${contactData.phone}</div><div class="contact-info-icon">${icons.phone}</div></div>
    </div>
    <div class="contact-info-item">
      <div class="contact-info-value-icon"><div class="contact-info-icon">${icons.pin}</div><div class="contact-info-label">${contactData.addressLabel}</div></div>
      <div class="contact-info-value-icon" id="contact-email"><div class="contact-info-value">${contactData.email}</div><div class="contact-info-icon">${icons.mail}</div></div>
    </div>
    <div class="contact-info-item">
      <div class="contact-info-value-icon"><div class="contact-info-icon">${icons.time}</div><div class="contact-info-value small">${contactData.hours.map(h => `<div>${h}</div>`).join("")}</div></div>
    </div>
  `;

  const form = byId("contact-form");
  form?.addEventListener("submit", (e) => {
    e.preventDefault();
    const name = byId("contact-name")?.value.trim();
    if (!name || !byId("contact-subject")?.value.trim() || !byId("contact-message")?.value.trim()) {
      return alert("يرجى تعبئة جميع الحقول");
    }
    alert("تم إرسال الرسالة بنجاح");
    form.reset();
  });
}

// ─────────────────────────────────────────────────────────────────────────────
// 4. MAIN INITIALIZATION
// ─────────────────────────────────────────────────────────────────────────────

function init() {
  initNavigation();
  initHeroSlider();
  initAbout();
  initDepartments();
  initGallery();
  initMap();
  initContact();
  
  // Apply scroll reveal animations to all marked elements
  applyReveals();
}

// Ensure execution when DOM is ready
if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", init);
} else {
  init();
}
