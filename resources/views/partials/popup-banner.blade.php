@if (!empty($popupBanner))
@php
  $popupVersion = optional($popupBanner->updated_at)->timestamp ?? $popupBanner->id;
  $popupStorageKey = 'htx_popup_' . $popupBanner->id . '_' . $popupVersion;
@endphp

<!-- ===== PROMO POPUP (thông báo quảng cáo trang chủ) ===== -->
<div id="promo-popup" class="modal-overlay fixed inset-0 z-[70] hidden bg-black/60 p-4 backdrop-blur-sm" role="dialog" aria-modal="true" aria-label="{{ $popupBanner->title }}">
  <div class="promo-popup-panel relative max-h-[88vh] w-full max-w-[420px] overflow-hidden rounded-2xl bg-white shadow-2xl sm:max-w-[520px]">
    <button type="button" id="promo-popup-close" class="absolute right-2 top-2 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-black/55 text-white shadow-lg transition-colors hover:bg-black/75" aria-label="Đóng thông báo">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
      </svg>
    </button>
    <img src="{{ asset($popupBanner->image) }}" alt="{{ $popupBanner->title }}" class="block max-h-[80vh] w-full object-contain">
  </div>
</div>

<style>
  #promo-popup:not(.hidden) {
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .promo-popup-panel {
    animation: promo-popup-in 0.3s cubic-bezier(0.16, 1, 0.3, 1) both;
  }
  @keyframes promo-popup-in {
    from { opacity: 0; scale: 0.96; }
    to { opacity: 1; scale: 1; }
  }
  @media (prefers-reduced-motion: reduce) {
    .promo-popup-panel { animation: none; }
  }
</style>

<script>
(function () {
  var POPUP_KEY = @json($popupStorageKey);
  var FORCE_SHOW = @json(!empty($popupForceShow));
  var REPEAT_MS = 3 * 24 * 60 * 60 * 1000; // hiện lại sau 3 ngày (đổi số 3 nếu cần)
  var overlay = document.getElementById('promo-popup');
  if (!overlay) return;

  var closeBtn = document.getElementById('promo-popup-close');

  function wasDismissed() {
    try {
      var ts = parseInt(window.localStorage.getItem(POPUP_KEY) || '0', 10);
      return !!ts && (Date.now() - ts) < REPEAT_MS;
    } catch (e) {
      return false;
    }
  }

  function closePopup() {
    if (overlay.classList.contains('hidden')) return;
    overlay.classList.add('hidden');
    document.body.style.overflow = '';
    if (!FORCE_SHOW) {
      try {
        window.localStorage.setItem(POPUP_KEY, String(Date.now()));
      } catch (e) {}
    }
  }

  function openPopup() {
    overlay.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    if (closeBtn) closeBtn.focus({ preventScroll: true });
  }

  if (!FORCE_SHOW && wasDismissed()) return;

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function () {
      setTimeout(openPopup, 800);
    });
  } else {
    setTimeout(openPopup, 800);
  }

  if (closeBtn) closeBtn.addEventListener('click', closePopup);
  overlay.addEventListener('click', function (e) {
    if (e.target === overlay) closePopup();
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && !overlay.classList.contains('hidden')) closePopup();
  });
})();
</script>
@endif
