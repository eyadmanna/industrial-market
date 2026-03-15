// Helpers
function qs(sel, root=document){ return root.querySelector(sel); }
function qsa(sel, root=document){ return Array.from(root.querySelectorAll(sel)); }

// Mobile menu
(function(){
  const btn = qs('#menuBtn');
  const nav = qs('#nav');
  if(!btn || !nav) return;
  btn.addEventListener('click', () => {
    const open = nav.classList.toggle('open');
    btn.setAttribute('aria-expanded', open ? 'true' : 'false');
  });
  qsa('a', nav).forEach(a => a.addEventListener('click', () => nav.classList.remove('open')));
})();

// Year
(function(){
  const y = qs('#year');
  if(y) y.textContent = new Date().getFullYear();
})();

// Hero auto background switch (between 2 photos)
(function(){
  const hero = qs('.hero');
  if(!hero) return;
  const imgs = ["assets/hero-1.jpg","assets/hero-2.jpg"];
  let i = 0;
  function setBg(){
    hero.style.setProperty('--hero-bg', `url('${imgs[i]}')`);
    i = (i + 1) % imgs.length;
  }
  setBg();
  setInterval(setBg, 5000);
})();

// Generic carousel (cards per view based on CSS grid-auto-columns)
function initCarousel(root, dotsKey){
  const viewport = qs('.car-viewport', root);
  const track = qs('.car-track', root);
  const btnPrev = qs('.prev', root);
  const btnNext = qs('.next', root);
  if(!viewport || !track) return;

  const cards = qsa('.sec-card', track);
  let index = 0;

  function cardsPerView(){
    // Read computed grid-auto-columns by comparing viewport width with first card width
    const first = cards[0];
    if(!first) return 1;
    const cardW = first.getBoundingClientRect().width;
    const vpW = viewport.getBoundingClientRect().width;
    const per = Math.max(1, Math.round(vpW / cardW));
    return per;
  }

  // Dots
  const dotsWrap = qs(`[data-dots="${dotsKey}"]`);
  function buildDots(){
    if(!dotsWrap) return;
    dotsWrap.innerHTML = '';
    const per = cardsPerView();
    const pages = Math.max(1, Math.ceil(cards.length / per));
    for(let p=0; p<pages; p++){
      const d = document.createElement('div');
      d.className = 'dot' + (p===0 ? ' active' : '');
      d.addEventListener('click', () => { index = p; update(); });
      dotsWrap.appendChild(d);
    }
  }

  function update(){
    const per = cardsPerView();
    const maxIndex = Math.max(0, Math.ceil(cards.length / per) - 1);
    index = Math.min(index, maxIndex);
    const move = index * (viewport.getBoundingClientRect().width);
    track.style.transform = `translateX(${-move}px)`;
    if(dotsWrap){
      qsa('.dot', dotsWrap).forEach((d, di) => d.classList.toggle('active', di === index));
    }
  }

  btnPrev && btnPrev.addEventListener('click', () => { index = Math.max(0, index - 1); update(); });
  btnNext && btnNext.addEventListener('click', () => { index = index + 1; update(); });

  // keyboard
  viewport.addEventListener('keydown', (e) => {
    if(e.key === 'ArrowLeft'){ index = index + 1; update(); }
    if(e.key === 'ArrowRight'){ index = Math.max(0, index - 1); update(); }
  });

  window.addEventListener('resize', () => { buildDots(); update(); });
  buildDots();
  update();
}

(function(){
  const c = qs('[data-carousel="sections"]');
  if(c) initCarousel(c, 'sections');
})();

// Gallery slider
(function(){
  const root = qs('#gallery');
  if(!root) return;
  const viewport = qs('.gallery-viewport', root);
  const track = qs('.gallery-track', root);
  const prev = qs('.g-btn.prev', root);
  const next = qs('.g-btn.next', root);
  if(!viewport || !track) return;

  const items = qsa('.g-item', track);
  let idx = 0;

  function perView(){
    const first = items[0];
    if(!first) return 1;
    const iw = first.getBoundingClientRect().width;
    const vw = viewport.getBoundingClientRect().width;
    return Math.max(1, Math.round(vw / iw));
  }

  function update(){
    const pv = perView();
    const max = Math.max(0, Math.ceil(items.length / pv) - 1);
    idx = Math.min(idx, max);
    const move = idx * viewport.getBoundingClientRect().width;
    track.style.transform = `translateX(${-move}px)`;
  }

  prev && prev.addEventListener('click', () => { idx = Math.max(0, idx - 1); update(); });
  next && next.addEventListener('click', () => { idx = idx + 1; update(); });

  window.addEventListener('resize', update);
  update();
})();

// Fake submit (UI only)
(function(){
  const btn = qs('#sendBtn');
  const note = qs('#formNote');
  if(!btn || !note) return;
  btn.addEventListener('click', () => {
    note.textContent = "تم استلام رسالتك (تجريبيًا) — يمكن ربط النموذج لاحقًا بـ Laravel.";
  });
})();
