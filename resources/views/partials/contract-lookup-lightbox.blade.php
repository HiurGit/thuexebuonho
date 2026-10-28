{{-- Swiper (self-contained cho trang tra cứu hợp đồng) --}}
<script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

<style>
  #contract-lightbox-swiper { width: 100%; }
  #contract-lightbox-swiper .swiper-wrapper { align-items: center; }
  #contract-lightbox-swiper .swiper-slide {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 50vh;
  }
  #contract-lightbox-swiper .swiper-slide img,
  #contract-lightbox-swiper .swiper-slide video {
    display: block;
    margin: 0 auto;
    max-height: 80vh;
    max-width: 100%;
    border-radius: 1rem;
  }
</style>

{{-- MEDIA LIGHTBOX --}}
<div id="contract-lightbox" class="fixed inset-0 z-[90] hidden items-center justify-center bg-black/80 px-4">
  <button id="contract-lightbox-close" type="button" class="absolute right-4 top-4 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-white/20 text-white transition-all hover:bg-white/30">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
  </button>
  <div class="flex max-h-[90vh] max-w-full flex-col items-center">
    <div class="relative w-full max-w-full">
      <button id="contract-lightbox-prev" type="button" class="contract-lightbox-nav absolute left-2 top-1/2 z-10 hidden h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-black/55 text-white transition-all hover:bg-black/70">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
      </button>
      <button id="contract-lightbox-next" type="button" class="contract-lightbox-nav absolute right-2 top-1/2 z-10 hidden h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-black/55 text-white transition-all hover:bg-black/70">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
      </button>
      <div id="contract-lightbox-swiper" class="swiper w-full max-w-full">
        <div id="contract-lightbox-swiper-wrapper" class="swiper-wrapper"></div>
      </div>
    </div>
  </div>
</div>

<script>
(function () {
  var lightbox = document.getElementById('contract-lightbox');
  var swiperEl = document.getElementById('contract-lightbox-swiper');
  var wrapper = document.getElementById('contract-lightbox-swiper-wrapper');
  var closeBtn = document.getElementById('contract-lightbox-close');
  var prevBtn = document.getElementById('contract-lightbox-prev');
  var nextBtn = document.getElementById('contract-lightbox-next');
  var navBtns = document.querySelectorAll('.contract-lightbox-nav');
  if (!lightbox || !swiperEl || !wrapper) return;

  var items = [];
  var current = 0;
  var swiper = null;

  function pauseVideos() {
    wrapper.querySelectorAll('video').forEach(function (v) { v.pause(); });
  }

  function playActive() {
    var slide = wrapper.querySelectorAll('.swiper-slide')[current];
    if (!slide) return;
    var video = slide.querySelector('video');
    if (video) { try { video.play().catch(function () {}); } catch (e) {} }
  }

  function syncMeta(idx) {
    if (!items.length) return;
    current = idx;
    pauseVideos();
    playActive();
  }

  function buildSlides() {
    wrapper.innerHTML = items.map(function (item) {
      var inner;
      if (item.type === 'video') {
        inner = '<video src="' + item.src + '" controls playsinline preload="metadata" class="max-h-[80vh] max-w-full rounded-2xl bg-black"></video>';
      } else {
        inner = '<img src="' + item.src + '" alt="' + (item.label || '') + '" class="max-h-[80vh] max-w-full rounded-2xl object-contain shadow-2xl">';
      }
      return '<div class="swiper-slide flex items-center justify-center">' + inner + '</div>';
    }).join('');
  }

  function initSwiper(index) {
    if (swiper) { swiper.destroy(true, true); swiper = null; }
    buildSlides();
    swiper = new Swiper(swiperEl, {
      initialSlide: index || 0,
      slidesPerView: 1,
      spaceBetween: 0,
      grabCursor: items.length > 1,
      on: {
        init: function () { syncMeta(this.activeIndex || 0); },
        slideChange: function () { syncMeta(this.activeIndex || 0); }
      }
    });
  }

  function open(index) {
    if (!items.length) return;
    navBtns.forEach(function (b) {
      b.classList.toggle('hidden', items.length <= 1);
      b.classList.toggle('flex', items.length > 1);
    });
    lightbox.classList.remove('hidden');
    lightbox.classList.add('flex');
    document.body.classList.add('overflow-hidden');
    requestAnimationFrame(function () { initSwiper(index || 0); });
  }

  function close() {
    if (swiper) { swiper.destroy(true, true); swiper = null; }
    pauseVideos();
    wrapper.innerHTML = '';
    lightbox.classList.add('hidden');
    lightbox.classList.remove('flex');
    document.body.classList.remove('overflow-hidden');
  }

  function showIndex(idx) {
    if (!items.length || !swiper) return;
    swiper.slideTo((idx + items.length) % items.length);
  }

  document.querySelectorAll('[data-media-item]').forEach(function (el, idx) {
    items.push({
      src: el.getAttribute('data-src'),
      type: el.getAttribute('data-type') || 'image',
      label: el.getAttribute('data-label') || ''
    });
    el.addEventListener('click', function () { open(idx); });
  });

  if (closeBtn) closeBtn.addEventListener('click', close);
  if (prevBtn) prevBtn.addEventListener('click', function (e) { e.stopPropagation(); showIndex(current - 1); });
  if (nextBtn) nextBtn.addEventListener('click', function (e) { e.stopPropagation(); showIndex(current + 1); });
  lightbox.addEventListener('click', function (e) { if (e.target === lightbox) close(); });
  document.addEventListener('keydown', function (e) {
    if (lightbox.classList.contains('hidden')) return;
    if (e.key === 'Escape') close();
    if (e.key === 'ArrowLeft') showIndex(current - 1);
    if (e.key === 'ArrowRight') showIndex(current + 1);
  });
})();
</script>
