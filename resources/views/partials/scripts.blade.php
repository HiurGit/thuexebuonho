<script src="{{ asset('assets/vendor/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('assets/vendor/flatpickr/l10n/vn.js') }}"></script>
<script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

<script>
// ===== TOAST NOTIFICATION =====
var toastTimer;
window.showToast = function(msg, icon) {
  var el = document.getElementById('toast');
  if (!el) { alert(msg); return; }
  clearTimeout(toastTimer);
  document.getElementById('toast-msg').textContent = msg;
  var iconEl = document.getElementById('toast-icon');
  if (icon === 'success') {
    iconEl.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>';
    iconEl.classList.remove('text-amber-500'); iconEl.classList.add('text-app-accent');
  } else {
    iconEl.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>';
    iconEl.classList.remove('text-app-accent'); iconEl.classList.add('text-amber-500');
  }
  el.classList.remove('hidden');
  el.style.display = 'flex';
  toastTimer = setTimeout(function() { el.classList.add('hidden'); el.style.display = ''; }, 3000);
};

// Quick test on page load
document.addEventListener('DOMContentLoaded', function() {
  if (typeof showToast === 'function') {
    console.log('showToast ready');
    // Uncomment to test: showToast('Toast đang hoạt động');
  }
});
</script>

<script>
// ===== DRAWER =====
var menuBtn = document.getElementById('menu-btn') || document.getElementById('menu-toggle');
var drawerOverlay = document.getElementById('drawer-overlay');
var drawerPanel = document.getElementById('drawer-panel');
var drawerClose = document.getElementById('drawer-close');

function openDrawer() {
  if (!drawerOverlay || !drawerPanel) return;
  drawerOverlay.classList.remove('hidden');
  drawerPanel.classList.remove('hidden');
  requestAnimationFrame(function() {
    drawerOverlay.classList.remove('opacity-0', 'pointer-events-none');
    drawerPanel.classList.remove('translate-x-full');
  });
  document.body.style.overflow = 'hidden';
}

function closeDrawer() {
  if (!drawerOverlay || !drawerPanel) return;
  drawerOverlay.classList.add('opacity-0', 'pointer-events-none');
  drawerPanel.classList.add('translate-x-full');
  setTimeout(function() {
    drawerOverlay.classList.add('hidden');
    drawerPanel.classList.add('hidden');
  }, 300);
  document.body.style.overflow = '';
}

if (menuBtn && drawerOverlay && drawerPanel) {
  menuBtn.addEventListener('click', openDrawer);
  if (drawerClose) drawerClose.addEventListener('click', closeDrawer);
  drawerOverlay.addEventListener('click', closeDrawer);
}

// ===== DATE MODAL =====
var currentDateMode = 'one-day';
var currentDateBtn = null;
var datePicker = null;

function getDateEls() {
  return {
    modal: document.getElementById('date-modal'),
    title: document.getElementById('date-modal-title'),
    preview: document.getElementById('date-preview'),
    input: document.getElementById('date-picker-input'),
    holder: document.getElementById('date-picker-holder'),
    apply: document.getElementById('apply-date'),
    buoiBox: document.getElementById('hourly-buoi-box'),
    buoiInput: document.getElementById('hourly-selected-buoi')
  };
}

function fmtDate(d) {
  return new Intl.DateTimeFormat('vi-VN', { day: '2-digit', month: '2-digit', year: 'numeric' }).format(d);
}

function fmtOneDay(d) { return 'Từ 06:00, ' + fmtDate(d) + '<br>Đến 22:00, ' + fmtDate(d); }
function fmtRange(s, e) { return 'Từ 06:00, ' + fmtDate(s) + '<br>Đến 22:00, ' + fmtDate(e); }
function fmtHourly(d, b) {
  var lb = { sang: 'Sáng (6h-12h)', chieu: 'Chiều (12h-18h)', toi: 'Tối (18h-23h)' };
  return (lb[b] || 'Sáng') + ', ' + fmtDate(d);
}

function initPicker(mode, el) {
  if (datePicker) datePicker.destroy();
  var d = new Date(); d.setHours(0, 0, 0, 0);
  var t = new Date(d); t.setDate(t.getDate() + 1);
  var minSelectableDate = currentDateMode === 'hourly' ? d : t;
  datePicker = flatpickr(el.input, {
    appendTo: el.holder,
    inline: true,
    mode: mode,
    locale: flatpickr.l10ns.vn || Vietnamese,
    dateFormat: 'd/m/Y',
    minDate: minSelectableDate,
    onChange: function(dates) {
      if (!dates.length) { el.preview.innerHTML = 'Chưa có ngày'; return; }
      if (currentDateMode === 'one-day') el.preview.innerHTML = fmtOneDay(dates[0]);
      else if (currentDateMode === 'multi-range' || currentDateMode === 'multi-day') {
        el.preview.innerHTML = dates.length === 2 ? fmtRange(dates[0], dates[1]) : 'Từ 06:00, ' + fmtDate(dates[0]) + '<br>Đến 22:00, ...';
      } else if (currentDateMode === 'hourly') el.preview.innerHTML = fmtHourly(dates[0], el.buoiInput.value || 'sang');
    }
  });
  return datePicker;
}

function openDateModal(btn, mode) {
  currentDateBtn = btn;
  currentDateMode = mode;
  var el = getDateEls();
  var d = new Date(); d.setHours(0, 0, 0, 0);
  var t = new Date(d); t.setDate(t.getDate() + 1);

  el.modal.classList.remove('hidden');
  document.body.style.overflow = 'hidden';

  var titles = { 'one-day': 'Chọn ngày thuê 1 ngày', 'multi-day': 'Chọn khoảng ngày thuê', 'multi-range': 'Chọn khoảng ngày thuê', 'hourly': 'Chọn ngày và buổi thuê' };
  el.title.textContent = titles[mode] || 'Chọn ngày thuê';

  var isHourly = mode === 'hourly';
  el.buoiBox.classList.toggle('hidden', !isHourly);
  if (isHourly && !el.buoiInput.value) el.buoiInput.value = 'sang';

  var pickerMode = mode === 'multi-range' || mode === 'multi-day' ? 'range' : 'single';
  initPicker(pickerMode, el);

  if (mode === 'one-day') datePicker.setDate(t, true);
  else if (mode === 'multi-range' || mode === 'multi-day') datePicker.setDate([t, new Date(t.getFullYear(), t.getMonth(), t.getDate() + 2)], true);
  else if (mode === 'hourly') { datePicker.setDate(d, true); el.preview.innerHTML = fmtHourly(d, el.buoiInput.value || 'sang'); }

  datePicker.redraw();
}

document.querySelectorAll('[data-open-date]').forEach(function(btn) {
  btn.addEventListener('click', function(e) {
    e.preventDefault();
    openDateModal(this, this.dataset.openDate);
  });
});

document.querySelectorAll('[data-close-modal]').forEach(function(btn) {
  btn.addEventListener('click', function() {
    var modal = document.getElementById(this.dataset.closeModal + '-modal');
    if (modal) {
      modal.classList.add('hidden');
      document.body.style.overflow = '';
    }
  });
});

document.querySelectorAll('#hourly-buoi-box .buoi-option').forEach(function(btn) {
  btn.addEventListener('click', function() {
    var buoiInput = document.getElementById('hourly-selected-buoi');
    var buoiBox = document.getElementById('hourly-buoi-box');
    if (!buoiBox || !buoiInput) return;
    buoiBox.querySelectorAll('.buoi-option').forEach(function(b) {
      b.classList.remove('bg-[#5fcf86]');
      b.classList.add('bg-white');
      b.querySelector('p:first-child').classList.remove('text-white');
      b.querySelector('p:first-child').classList.add('text-app-ink');
      b.querySelector('p:last-child').classList.remove('text-white');
      b.querySelector('p:last-child').classList.add('text-app-muted');
    });
    this.classList.remove('bg-white');
    this.classList.add('bg-[#5fcf86]');
    this.querySelector('p:first-child').classList.remove('text-app-ink');
    this.querySelector('p:first-child').classList.add('text-white');
    this.querySelector('p:last-child').classList.remove('text-app-muted');
    this.querySelector('p:last-child').classList.add('text-white');
    buoiInput.value = this.dataset.buoi;

    var el = getDateEls();
    if (currentDateMode === 'hourly' && datePicker && datePicker.selectedDates.length) {
      el.preview.innerHTML = fmtHourly(datePicker.selectedDates[0], buoiInput.value);
    }
  });
});

function updateBookingDate() {
  var el = getDateEls();
  if (!datePicker || !datePicker.selectedDates.length) return;
  var dates = datePicker.selectedDates;
  var html = '';
  if (currentDateMode === 'one-day') html = fmtOneDay(dates[0]);
  else if (currentDateMode === 'multi-range' || currentDateMode === 'multi-day') html = dates.length >= 2 ? fmtRange(dates[0], dates[1]) : fmtOneDay(dates[0]);
  else html = fmtHourly(dates[0], el.buoiInput.value || 'sang');

  var target = currentDateBtn?.closest('.booking-panel')?.querySelector('[data-date-text]');
  if (target) {
    target.innerHTML = html;
    target.dataset.selected = '1';
    if (currentDateMode === 'hourly') {
      target.dataset.sessionType = el.buoiInput.value || 'sang';
    } else {
      delete target.dataset.sessionType;
    }
  }

  if ((currentDateMode === 'multi-range' || currentDateMode === 'multi-day') && dates.length >= 2) {
    var days = Math.round((dates[1] - dates[0]) / 86400000) + 1;
    updateCarDetailPrice('multi-day', days);
  }
}

var applyBtn = document.getElementById('apply-date');
if (applyBtn) {
  applyBtn.addEventListener('click', function() {
    var el = getDateEls();
    if (currentDateMode === 'hourly' && !el.buoiInput.value) { showToast('Vui lòng chọn buổi'); return; }
    if (!datePicker || !datePicker.selectedDates.length) { showToast('Vui lòng chọn ngày'); return; }

    updateBookingDate();

    el.modal.classList.add('hidden');
    document.body.style.overflow = '';
    el.buoiInput.value = '';
    el.buoiBox.querySelectorAll('.buoi-option').forEach(function(b) {
      b.classList.remove('bg-[#5fcf86]');
      b.classList.add('bg-white');
      b.querySelector('p:first-child').classList.remove('text-white');
      b.querySelector('p:first-child').classList.add('text-app-ink');
      b.querySelector('p:last-child').classList.remove('text-white');
      b.querySelector('p:last-child').classList.add('text-app-muted');
    });
  });
}

// ===== TAB SWITCHING =====
var allTabs = document.querySelectorAll('.banner-tab');

allTabs.forEach(function(tab) {
  tab.addEventListener('click', function() {
    var target = tab.dataset.tab;
    var isMobile = window.innerWidth < 1024;
    var wrapper = tab.closest('#desktop-wrapper, #mobile-wrapper');
    if (!wrapper) wrapper = document;
    var panelId = 'panel-' + target + (isMobile ? '-mobile' : '');
    var fallbackPanelId = 'panel-' + target;
    var scopedTabs = wrapper.querySelectorAll('.banner-tab');

    scopedTabs.forEach(function(t) {
      t.classList.remove('bg-app-accent', 'text-white');
      t.classList.add('bg-white', 'text-app-muted');
      if (t.dataset.tab === 'multi-day' && !t.classList.contains('border-x')) {
        t.classList.add('border-x', 'border-[#e5e5e3]');
      }
    });
    tab.classList.remove('bg-white', 'text-app-muted', 'border-x', 'border-[#e5e5e3]');
    tab.classList.add('bg-app-accent', 'text-white');
    
    var panelsStale = wrapper.querySelectorAll('.booking-panel');
    panelsStale.forEach(function(panel) { panel.classList.add('hidden'); });
    var panel = wrapper.querySelector('#' + panelId) || wrapper.querySelector('#' + fallbackPanelId);
    if (panel) panel.classList.remove('hidden');
    
    updateCarDetailPrice(target);
  });
});

function updateCarDetailPrice(tabMode, days) {
  var formTotal = document.getElementById('form-total');
  var formDuration = document.getElementById('form-duration');
  var bottomTotal = document.getElementById('bottom-total');
  var bottomDuration = document.getElementById('bottom-duration');
  if (!formTotal && !bottomTotal) return;
  var pricingSource = document.querySelector('[data-car-price-day]');
  var pricePerDay = pricingSource ? parseInt(pricingSource.dataset.carPriceDay || '650000', 10) : 650000;
  var pricePerSession = pricingSource ? parseInt(pricingSource.dataset.carPriceSession || '350000', 10) : 350000;
  var priceMultiDay = pricingSource ? parseInt(pricingSource.dataset.carPriceMultiDay || String(pricePerDay), 10) : pricePerDay;
  days = days || 1;
  var totalText, durationText;
  if (tabMode === 'hourly') { totalText = '350.000đ'; durationText = '1 buổi'; }
  else if (tabMode === 'multi-day') { totalText = (days * 650000).toLocaleString('vi-VN') + 'đ'; durationText = days + ' ngày'; }
  else { totalText = '650.000đ'; durationText = '1 ngày'; }
  if (formTotal) formTotal.textContent = totalText;
  if (formDuration) formDuration.textContent = durationText;
  if (bottomTotal) bottomTotal.textContent = totalText;
  if (bottomDuration) bottomDuration.textContent = durationText;
}

// Override the legacy hard-coded pricing so car-detail always uses real DB values.
updateCarDetailPrice = function(tabMode, days) {
  var formTotal = document.getElementById('form-total');
  var formDuration = document.getElementById('form-duration');
  var bottomTotal = document.getElementById('bottom-total');
  var bottomDuration = document.getElementById('bottom-duration');
  if (!formTotal && !bottomTotal) return;

  var pricingSource = document.querySelector('[data-car-price-day]');
  var pricePerDay = pricingSource ? parseInt(pricingSource.dataset.carPriceDay || '650000', 10) : 650000;
  var pricePerSession = pricingSource ? parseInt(pricingSource.dataset.carPriceSession || '350000', 10) : 350000;
  var priceMultiDay = pricingSource ? parseInt(pricingSource.dataset.carPriceMultiDay || String(pricePerDay), 10) : pricePerDay;

  days = days || 1;

  var totalText;
  var durationText;

  if (tabMode === 'hourly') {
    totalText = pricePerSession.toLocaleString('vi-VN') + 'đ';
    durationText = '1 buổi';
  } else if (tabMode === 'multi-day') {
    var dailyRate = days >= 3 ? priceMultiDay : pricePerDay;
    totalText = (days * dailyRate).toLocaleString('vi-VN') + 'đ';
    durationText = days + ' ngày';
  } else {
    totalText = pricePerDay.toLocaleString('vi-VN') + 'đ';
    durationText = '1 ngày';
  }

  if (formTotal) formTotal.textContent = totalText;
  if (formDuration) formDuration.textContent = durationText;
  if (bottomTotal) bottomTotal.textContent = totalText;
  if (bottomDuration) bottomDuration.textContent = durationText;
};

// ===== PHONE VALIDATION =====
function validatePhone(phone) {
  if (!phone || phone.length === 0) return 'Vui lòng nhập số điện thoại';
  var digitsOnly = phone.replace(/\D/g, '');
  if (phone !== digitsOnly) return 'Số điện thoại không hợp lệ ';
  if (digitsOnly.length < 10) return 'Số điện thoại thiếu số ';
  if (digitsOnly.length > 10) return 'Số điện thoại dư số ';
  return null;
}

// ===== THUÊ XE POPUP =====
// The legacy helper above stays in place for compatibility, but the functions
// below centralize the stricter validation used by booking flows.
function normalizePhone(phone) {
  return (phone || '').replace(/\D/g, '').slice(0, 10);
}

function validatePhone(phone) {
  var digitsOnly = normalizePhone(phone);
  if (!digitsOnly.length) return 'Vui lòng nhập số điện thoại';
  if (digitsOnly.length !== 10) return 'Số điện thoại phải gồm đúng 10 số';
  if (digitsOnly.charAt(0) !== '0') return 'Số điện thoại phải bắt đầu bằng số 0';
  return null;
}

function setPhoneFieldError(phoneInput, errorMessage) {
  if (!phoneInput) return;

  var phoneField = phoneInput.closest('[data-phone-field]');
  var errorEl = phoneField ? phoneField.querySelector('[data-phone-error]') : null;

  phoneInput.setAttribute('aria-invalid', errorMessage ? 'true' : 'false');

  if (phoneField) {
    phoneField.classList.toggle('border-red-500', !!errorMessage);
    phoneField.classList.toggle('ring-1', !!errorMessage);
    phoneField.classList.toggle('ring-red-200', !!errorMessage);
  }

  if (errorEl) {
    errorEl.textContent = errorMessage || '';
    errorEl.classList.toggle('hidden', !errorMessage);
  }
}

function validatePhoneField(phoneInput, forceError) {
  if (!phoneInput) return false;

  var normalizedPhone = normalizePhone(phoneInput.value);
  if (phoneInput.value !== normalizedPhone) {
    phoneInput.value = normalizedPhone;
  }

  var errorMessage = null;
  if (forceError || normalizedPhone.length) {
    errorMessage = validatePhone(normalizedPhone);
  }

  setPhoneFieldError(phoneInput, errorMessage);

  return !errorMessage;
}

function initPhoneValidation() {
  document.querySelectorAll('[data-phone-input]').forEach(function(phoneInput) {
    if (phoneInput.dataset.phoneBound === '1') return;
    phoneInput.dataset.phoneBound = '1';

    phoneInput.addEventListener('input', function() {
      var normalizedPhone = normalizePhone(this.value);
      if (this.value !== normalizedPhone) {
        this.value = normalizedPhone;
      }
      validatePhoneField(this, this.dataset.phoneTouched === '1');
    });

    phoneInput.addEventListener('blur', function() {
      this.dataset.phoneTouched = '1';
      validatePhoneField(this, true);
    });
  });
}

function setSubmitButtonState(button, isLoading, loadingLabel) {
  if (!button) return;

  var labelEl = button.querySelector('[data-submit-label]');
  var spinnerEl = button.querySelector('[data-loading-icon]');
  var defaultLabel = button.dataset.defaultLabel || (labelEl ? labelEl.textContent : button.textContent);

  button.disabled = !!isLoading;
  button.setAttribute('aria-busy', isLoading ? 'true' : 'false');

  if (spinnerEl) {
    spinnerEl.classList.toggle('hidden', !isLoading);
  }

  if (labelEl) {
    labelEl.textContent = isLoading ? (loadingLabel || 'Đang gửi...') : defaultLabel;
  } else {
    button.textContent = isLoading ? (loadingLabel || 'Đang gửi...') : defaultLabel;
  }
}

function setModalSubmitStatus(modal, message, tone) {
  if (!modal) return;

  var statusEl = modal.querySelector('[id^="thuexe-submit-status"]');
  if (!statusEl) return;

  statusEl.textContent = message;
  statusEl.classList.remove('text-app-ink', 'text-app-accent', 'text-red-500');

  if (tone === 'success') statusEl.classList.add('text-app-accent');
  else if (tone === 'error') statusEl.classList.add('text-red-500');
  else statusEl.classList.add('text-app-ink');
}

function setModalSuccessMessage(modal, message) {
  if (!modal) return;

  var messageEl = modal.querySelector('[id^="thuexe-success-message"]');
  if (messageEl) {
    messageEl.textContent = message || 'Yêu cầu của bạn đã vào hệ thống. Nhân viên sẽ gọi lại sớm để xác nhận xe và thời gian thuê.';
  }
}

function normalizeVietnameseText(value) {
  return (value || '')
    .toLowerCase()
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '')
    .replace(/đ/g, 'd');
}

function resolveSessionTypeFromLabel(label) {
  var normalized = normalizeVietnameseText(label);
  if (normalized.indexOf('chieu') === 0) return 'chieu';
  if (normalized.indexOf('toi') === 0) return 'toi';
  return 'sang';
}

function getActiveBookingRoot() {
  var responsiveRoot = window.innerWidth >= 1024
    ? document.getElementById('desktop-wrapper')
    : document.getElementById('mobile-wrapper');

  return responsiveRoot || document;
}

function getActiveBookingPanel() {
  var bookingRoot = getActiveBookingRoot();
  return bookingRoot ? bookingRoot.querySelector('.booking-panel:not(.hidden)') : document.querySelector('.booking-panel:not(.hidden)');
}

window.openThueXePopup = function(btn) {
  console.log('openThueXePopup called');
  var panel = btn.closest('.booking-panel') || document.querySelector('.booking-panel:not(.hidden)');
  if (!panel) return;

  var phoneInput = panel.querySelector('input[type="tel"]');
  var phone = phoneInput ? normalizePhone(phoneInput.value) : '';
  if (phoneInput) {
    phoneInput.value = phone;
  }

  // Validate before opening modal
  var phoneError = validatePhone(phone);
  if (phoneError) {
    validatePhoneField(phoneInput, true);
    if (phoneInput) phoneInput.focus();
    return;
  }

  var dateBtn = panel.querySelector('[data-open-date]');
  var mode = dateBtn ? dateBtn.dataset.openDate : (currentDateMode || 'one-day');
  var dateTextEl = panel.querySelector('[data-date-text]');

  if (mode === 'hourly') {
    if (!dateTextEl || !dateTextEl.dataset.selected) {
      showToast('Vui lòng chọn ngày và buổi thuê');
      return;
    }
  } else if (mode === 'multi-day' || mode === 'multi-range') {
    if (!dateTextEl || !dateTextEl.dataset.selected) {
      showToast('Vui lòng chọn khoảng ngày thuê');
      return;
    }
  } else {
    if (!dateTextEl || !dateTextEl.dataset.selected) {
      showToast('Vui lòng chọn ngày thuê');
      return;
    }
  }

  var isMobile = window.innerWidth < 1024;
  var targetModal = document.getElementById(isMobile ? 'thuexe-modal-mobile' : 'thuexe-modal');
  var dateHtml = dateTextEl ? dateTextEl.innerHTML : '';
  var parts = dateHtml.split('<br>');
  var startPart = parts[0] ? parts[0].trim() : '';
  var endPart = parts.length > 1 ? parts[1].trim() : '';

  if (!targetModal) {
    targetModal = document.getElementById('thuexe-modal');
  }
  if (targetModal) {
    var suffix = isMobile ? '-mobile' : '';
    var targetTime = targetModal.querySelector('#thuexe-time' + suffix);
    var targetPhone = targetModal.querySelector('#thuexe-phone-display' + suffix);
    var targetStartRow = targetModal.querySelector('#thuexe-start-row' + suffix);
    var targetStartDisplay = targetModal.querySelector('#thuexe-start-display' + suffix);
    var targetStartLabel = targetStartRow ? targetStartRow.querySelector('span:first-child') : null;
    var targetEndRow = targetModal.querySelector('#thuexe-end-row' + suffix);
    var targetEndDisplay = targetModal.querySelector('#thuexe-end-display' + suffix);
    var targetDaysRow = targetModal.querySelector('#thuexe-days-row' + suffix);
    var targetDaysDisplay = targetModal.querySelector('#thuexe-days-display' + suffix);
    var targetHoursRow = targetModal.querySelector('#thuexe-hours-row' + suffix);
    var targetHoursDisplay = targetModal.querySelector('#thuexe-hours-display' + suffix);
    var targetHoursLabel = targetHoursRow ? targetHoursRow.querySelector('span:first-child') : null;

    targetHoursRow?.classList.add('hidden');
    targetDaysRow?.classList.add('hidden');
    targetEndRow?.classList.add('hidden');
    if (targetStartLabel) targetStartLabel.textContent = 'Th\u1eddi gian nh\u1eadn xe';
    if (targetHoursLabel) targetHoursLabel.textContent = 'Bu\u1ed5i';

    if (mode === 'hourly') {
      if (targetTime) targetTime.textContent = 'Thuê theo buổi';
      var buoiMatch = dateHtml.match(/^(.+), (.+)$/);
      if (targetStartLabel) targetStartLabel.textContent = 'Ng\u00e0y thu\u00ea';
      if (targetHoursLabel) targetHoursLabel.textContent = 'Bu\u1ed5i thu\u00ea';
      if (targetStartDisplay) {
        targetStartDisplay.textContent = buoiMatch
          ? buoiMatch[2]
          : 'Chưa chọn';
      }
      if (targetHoursDisplay) {
        targetHoursDisplay.textContent = buoiMatch ? buoiMatch[1] : 'Chưa chọn';
      }
      targetHoursRow?.classList.remove('hidden');
    } else {
      if (targetTime) {
        targetTime.textContent = (mode === 'multi-range' || mode === 'multi-day') ? 'Thuê nhiều ngày' : 'Thuê 1 ngày';
      }
      if (targetStartDisplay) {
        var startMatch = startPart.match(/Từ ([\d:,]+), (.+)/);
        targetStartDisplay.textContent = startMatch
          ? startMatch[1] + ', ' + startMatch[2]
          : (startPart || 'Chưa chọn');
      }
      if (targetEndDisplay) {
        var endMatch = endPart.match(/Đến ([\d:,]+), (.+)/);
        targetEndDisplay.textContent = endMatch
          ? endMatch[1] + ', ' + endMatch[2]
          : (endPart || 'Chưa chọn');
        targetEndRow?.classList.remove('hidden');
      }
        if (targetDaysDisplay) {
        if ((mode === 'multi-range' || mode === 'multi-day') && datePicker && datePicker.selectedDates.length === 2) {
          var days = Math.round((datePicker.selectedDates[1] - datePicker.selectedDates[0]) / 86400000) + 1;
          targetDaysDisplay.textContent = days + ' ngày';
        } else {
          targetDaysDisplay.textContent = '1 ngày';
        }
        targetDaysRow?.classList.remove('hidden');
      }
    }

    if (targetPhone) targetPhone.textContent = phone || 'Chưa nhập';

    // Store booking data on modal for submission
    targetModal.dataset.phone = phone;
    targetModal.dataset.rentalType = mode;
    targetModal.dataset.startDate = targetStartDisplay ? targetStartDisplay.textContent : '';
    targetModal.dataset.endDate = targetEndDisplay ? targetEndDisplay.textContent : '';
    targetModal.dataset.sessionType = dateTextEl && dateTextEl.dataset.sessionType
      ? dateTextEl.dataset.sessionType
      : (mode === 'hourly' ? resolveSessionTypeFromLabel(startPart) : '');

    targetModal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
  }
};

// ===== CAR-DETAIL CONFIRM MODAL =====
window.openConfirmModal = function() {
  var confirmModal = document.getElementById('confirm-modal');
  if (!confirmModal) return;
  var confirmCar = document.getElementById('confirm-car');
  var confirmDuration = document.getElementById('confirm-duration');
  var confirmPhone = document.getElementById('confirm-phone');
  var confirmStart = document.getElementById('confirm-start');
  var confirmEnd = document.getElementById('confirm-end');
  var confirmPickup = document.getElementById('confirm-pickup');
  var confirmTotal = document.getElementById('confirm-total');
  var confirmDaysRow = document.getElementById('confirm-days-row');
  var confirmDays = document.getElementById('confirm-days');
  var confirmHoursRow = document.getElementById('confirm-hours-row');
  var confirmHours = document.getElementById('confirm-hours');
  var confirmHoursLabel = confirmHoursRow ? confirmHoursRow.querySelector('span:first-child') : null;
  var confirmStartRow = confirmStart ? confirmStart.parentElement : null;
  var confirmStartLabel = confirmStartRow ? confirmStartRow.querySelector('span:first-child') : null;
  var confirmEndRow = confirmEnd ? confirmEnd.parentElement : null;

  if (confirmCar) confirmCar.textContent = document.querySelector('h1')?.textContent?.trim() || 'Mitsubishi Xpander';

  var activePanel = getActiveBookingPanel();
  if (!activePanel) return;

  var phoneInput = activePanel ? activePanel.querySelector('[data-phone-input], input[type="tel"]') : null;
  if (confirmPhone) confirmPhone.textContent = phoneInput && phoneInput.value.trim() ? phoneInput.value.trim() : 'Chưa nhập';

  var phoneError = phoneInput ? validatePhone(normalizePhone(phoneInput.value)) : 'Vui lòng nhập số điện thoại';
  if (!validatePhoneField(phoneInput, true)) {
    if (phoneInput) phoneInput.focus();
    return;
  }

  var phone = phoneInput ? normalizePhone(phoneInput.value) : '';
  if (confirmPhone) confirmPhone.textContent = phone || 'Chưa nhập';

  var dateBtn = activePanel ? activePanel.querySelector('[data-open-date]') : null;
  var dateEl = dateBtn ? dateBtn.querySelector('[data-date-text]') : null;
  var dateHtml = (dateEl ? dateEl.innerHTML : '').replace(/\s*→\s*/g, '<br>');
  var parts = dateHtml.split('<br>');
  var startPart = parts[0] ? parts[0].trim() : '';
  var endPart = parts[1] ? parts[1].trim() : '';
  var type = dateBtn ? dateBtn.dataset.openDate : 'one-day';

  confirmModal.dataset.phone = phone;
  confirmModal.dataset.rentalType = type || 'one-day';
  confirmModal.dataset.startDate = startPart || '';
  confirmModal.dataset.endDate = endPart || '';
  confirmModal.dataset.sessionType = '';
  if (type === 'hourly') {
    var buoiMatch = dateHtml.match(/^(.+),\s*(.+)$/);
    if (confirmStartLabel) confirmStartLabel.textContent = 'Ng\u00e0y thu\u00ea';
    if (confirmHoursLabel) confirmHoursLabel.textContent = 'Bu\u1ed5i thu\u00ea';
    var hourlyLabel = buoiMatch ? buoiMatch[1] : '';
    confirmModal.dataset.sessionType = resolveSessionTypeFromLabel(hourlyLabel);
  }
  var pickupBtn = activePanel ? activePanel.querySelector('.pickup-option.border-app-accent') : null;
  confirmModal.dataset.pickupType = pickupBtn && pickupBtn.classList.contains('pickup-delivery') ? 'delivery' : 'shop';

  if (confirmDaysRow) confirmDaysRow.classList.add('hidden');
  if (confirmHoursRow) confirmHoursRow.classList.add('hidden');
  if (confirmEndRow) confirmEndRow.classList.remove('hidden');
  if (confirmStartLabel) confirmStartLabel.textContent = 'Ng\u00e0y nh\u1eadn xe';
  if (confirmHoursLabel) confirmHoursLabel.textContent = 'Bu\u1ed5i';

  if (type === 'hourly') {
    if (confirmDuration) confirmDuration.textContent = 'Theo buổi';
    var buoiMatch = dateHtml.match(/^(.+),\s*(.+)$/);
    if (confirmStart) confirmStart.textContent = buoiMatch ? buoiMatch[2] : 'Chưa chọn';
    if (confirmHours) confirmHours.textContent = buoiMatch ? buoiMatch[1] : 'Chưa chọn';
    if (confirmEnd) confirmEnd.textContent = 'Chưa chọn';
    if (confirmEndRow) confirmEndRow.classList.add('hidden');
    if (confirmStartLabel) confirmStartLabel.textContent = 'Ng\u00e0y thu\u00ea';
    if (confirmHoursLabel) confirmHoursLabel.textContent = 'Bu\u1ed5i thu\u00ea';
    if (confirmHoursRow) confirmHoursRow.classList.remove('hidden');
  } else {
    if (confirmDuration) confirmDuration.textContent = (type === 'multi-day' || type === 'multi-range') ? 'Theo nhiều ngày' : 'Theo ngày';
    if (type === 'multi-day' || type === 'multi-range') {
      var startMatch = startPart.match(/Từ\s+([\d:,]+),\s*([\d\/]+)/);
      var endMatch = endPart.match(/Đến\s+([\d:,]+),\s*([\d\/]+)/);
      if (startMatch && endMatch && confirmDays) {
        var d1Parts = startMatch[2].split('/');
        var d2Parts = endMatch[2].split('/');
        var d1 = new Date(parseInt(d1Parts[2]), parseInt(d1Parts[1]) - 1, parseInt(d1Parts[0]));
        var d2 = new Date(parseInt(d2Parts[2]), parseInt(d2Parts[1]) - 1, parseInt(d2Parts[0]));
        var days = Math.round((d2 - d1) / 86400000) + 1;
        confirmDays.textContent = days + ' ngày';
      }
      if (confirmDaysRow) confirmDaysRow.classList.remove('hidden');
    } else {
      if (confirmDays) confirmDays.textContent = '1 ngày';
      if (confirmDaysRow) confirmDaysRow.classList.remove('hidden');
    }
    var startMatch = startPart.match(/Từ\s+([\d:,]+),\s*(.+)/);
    var endMatch = endPart.match(/Đến\s+([\d:,]+),\s*(.+)/);
    if (confirmStart) confirmStart.textContent = startMatch ? startMatch[1] + ', ' + startMatch[2] : (startPart || 'Chưa chọn');
    if (confirmEnd) confirmEnd.textContent = endMatch ? endMatch[1] + ', ' + endMatch[2] : (endPart || 'Chưa chọn');
  }

  var activePickup = activePanel ? activePanel.querySelector('.pickup-option.border-app-accent p:first-of-type') : null;
  if (confirmPickup) confirmPickup.textContent = activePickup ? activePickup.textContent.trim() : 'Nhận tại shop';

  var totalEl = document.getElementById('form-total') || document.getElementById('bottom-total');
  if (confirmTotal) confirmTotal.textContent = totalEl ? totalEl.textContent : '0đ';

  var confirmReview = document.getElementById('confirm-review');
  var confirmSuccess = document.getElementById('confirm-success');
  if (confirmReview) confirmReview.classList.remove('hidden');
  if (confirmSuccess) confirmSuccess.classList.add('hidden');

  confirmModal.classList.remove('hidden');
  document.body.style.overflow = 'hidden';
};

window.closeConfirmModal = function() {
  var confirmModal = document.getElementById('confirm-modal');
  if (confirmModal) {
    confirmModal.classList.add('hidden');
    document.body.style.overflow = '';
    var confirmReview = document.getElementById('confirm-review');
    var confirmSuccess = document.getElementById('confirm-success');
    if (confirmReview) confirmReview.classList.remove('hidden');
    if (confirmSuccess) confirmSuccess.classList.add('hidden');
  }
};

function closeOverlayModal(modal) {
  if (!modal) return;

  modal.classList.add('hidden');
  document.body.style.overflow = '';

  if (modal.id === 'confirm-modal') {
    var confirmReview = document.getElementById('confirm-review');
    var confirmSuccess = document.getElementById('confirm-success');
    if (confirmReview) confirmReview.classList.remove('hidden');
    if (confirmSuccess) confirmSuccess.classList.add('hidden');
    return;
  }

  var success = modal.querySelector('[id^="thuexe-success"]');
  var review = modal.querySelector('[id^="thuexe-review"]');
  if (success && review) {
    success.classList.add('hidden');
    review.classList.remove('hidden');
  }
  setModalSubmitStatus(modal, 'Sẵn sàng gửi yêu cầu');
  setSubmitButtonState(modal.querySelector('[id^="thuexe-submit"]'), false);
}

document.querySelectorAll('[id^="thuexe-close"], [id^="thuexe-back"]').forEach(btn => {
  btn.addEventListener('click', function() {
    const modal = this.closest('[id$="-modal"], [id$="-modal-mobile"]');
    closeOverlayModal(modal);
  });
});

document.querySelectorAll('[id^="thuexe-submit"]').forEach(btn => {
  btn.addEventListener('click', function() {
    const modal = this.closest('[id$="-modal"], [id$="-modal-mobile"]');
    if (!modal) return;

    var phone = normalizePhone(modal.dataset.phone || '');
    var rentalType = modal.dataset.rentalType || 'one-day';

    // Validate phone
    var phoneError = validatePhone(phone);
    if (phoneError) {
      var activePanel = getActiveBookingPanel();
      var phoneInput = activePanel ? activePanel.querySelector('[data-phone-input], input[type="tel"]') : null;
      validatePhoneField(phoneInput, true);
      if (phoneInput) phoneInput.focus();
      return;
    }

    if (rentalType === 'one-day' && (!modal.dataset.startDate || modal.dataset.startDate === 'Chưa chọn')) {
      showToast('Vui lòng chọn ngày thuê!');
      return;
    }
    if ((rentalType === 'multi-day' || rentalType === 'multi-range') && (!modal.dataset.startDate || modal.dataset.startDate === 'Chưa chọn' || !modal.dataset.endDate || modal.dataset.endDate === 'Chưa chọn')) {
      showToast('Vui lòng chọn khoảng ngày thuê!');
      return;
    }
    if (rentalType === 'hourly' && (!modal.dataset.startDate || modal.dataset.startDate === 'Chưa chọn')) {
      showToast('Vui lòng chọn ngày và buổi thuê!');
      return;
    }

    setModalSubmitStatus(modal, 'Đang gửi yêu cầu, vui lòng chờ...', 'default');
    setSubmitButtonState(this, true, 'Đang gửi...');

    var formData = new FormData();
    formData.append('phone', phone);
    formData.append('rental_type', rentalType);
    formData.append('start_date', modal.dataset.startDate || '');
    formData.append('end_date', modal.dataset.endDate || '');
    formData.append('session_type', modal.dataset.sessionType || '');
    formData.append('pickup_type', modal.dataset.pickupType || 'shop');
    formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content || '');

    fetch('{{ url("/booking/submit") }}', { method: 'POST', body: formData, headers: { 'Accept': 'application/json' } })
      .then(function(r) {
        return r.json().then(function(data) {
          if (!r.ok) {
            throw new Error(data.message || 'Có lỗi xảy ra, vui lòng thử lại.');
          }
          return data;
        });
      })
      .then(function(data) {
        if (data.success) {
          var review = modal.querySelector('[id^="thuexe-review"]');
          var success = modal.querySelector('[id^="thuexe-success"]');
          setModalSubmitStatus(modal, 'Gửi yêu cầu thành công.', 'success');
          setModalSuccessMessage(modal, data.message);
          if (review && success) { review.classList.add('hidden'); success.classList.remove('hidden'); }
        } else {
          setModalSubmitStatus(modal, data.message || 'Có lỗi xảy ra, vui lòng thử lại.', 'error');
          showToast(data.message || 'Có lỗi xảy ra, vui lòng thử lại.');
        }
      })
      .catch(function(error) {
        setModalSubmitStatus(modal, error.message || 'Lỗi kết nối, vui lòng thử lại.', 'error');
        showToast('Lỗi kết nối, vui lòng thử lại sau.');
      })
      .finally(function() {
        setSubmitButtonState(btn, false);
      });
  });
});

document.querySelectorAll('[id^="thuexe-done"]').forEach(btn => {
  btn.addEventListener('click', function() {
    const modal = this.closest('[id$="-modal"], [id$="-modal-mobile"]');
    closeOverlayModal(modal);
  });
});

// ===== SWIPER =====
function initOnReady() {
  initPhoneValidation();

  var navSwiperEl = document.querySelector('.nav-swiper');
  var navSwiper = null;
  if (navSwiperEl && typeof Swiper !== "undefined" && !navSwiperEl.classList.contains('swiper-initialized')) {
    navSwiper = new Swiper(navSwiperEl, {
      slidesPerView: 'auto',
      spaceBetween: 5,
      freeMode: true,
      grabCursor: true,
      slidesOffsetBefore: 0,
      slidesOffsetAfter: 0,
    });
  } else if (navSwiperEl && navSwiperEl.swiper) {
    navSwiper = navSwiperEl.swiper;
  }

  var servicesSwiperEl = document.querySelector('.services-swiper');
  if (servicesSwiperEl && typeof Swiper !== 'undefined' && !servicesSwiperEl.classList.contains('swiper-initialized')) {
    new Swiper(servicesSwiperEl, {
      slidesPerView: 2,
      spaceBetween: 12,
      breakpoints: {
        480: { slidesPerView: 2.5 },
        640: { slidesPerView: 3.5 },
      },
    });
  }

  // Car detail gallery swiper
  var carGallerySwiperEl = document.querySelector('.car-gallery-swiper');
  if (carGallerySwiperEl && typeof Swiper !== 'undefined' && !carGallerySwiperEl.classList.contains('swiper-initialized')) {
    new Swiper(carGallerySwiperEl, {
      slidesPerView: 1,
      spaceBetween: 0,
      grabCursor: true,
      pagination: { el: '.car-gallery-pagination', clickable: true }
    });
  }

  // Pickup option toggle (car-detail)
  document.querySelectorAll('.pickup-option').forEach(function(btn) {
    btn.addEventListener('click', function() {
      var panel = this.closest('.booking-panel');
      if (!panel) return;
      panel.querySelectorAll('.pickup-option').forEach(function(opt) {
        opt.classList.remove('border-app-accent', 'bg-green-50');
        opt.classList.add('border-[#d9e1e7]', 'bg-white');
        var label = opt.querySelector('p:first-of-type');
        if (label) {
          label.classList.remove('text-app-accent');
          label.classList.add('text-slate-500');
        }
      });
      this.classList.remove('border-[#d9e1e7]', 'bg-white');
      this.classList.add('border-app-accent', 'bg-green-50');
      var activeLabel = this.querySelector('p:first-of-type');
      if (activeLabel) {
        activeLabel.classList.remove('text-slate-500');
        activeLabel.classList.add('text-app-accent');
      }
      var bottomPickup = document.getElementById('bottom-pickup');
      if (bottomPickup) {
        if (this.classList.contains('pickup-shop')) {
          bottomPickup.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-0.5 inline-block h-3.5 w-3.5 align-text-bottom text-app-accent"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>Nhận tại shop';
        } else {
          bottomPickup.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-0.5 inline-block h-3.5 w-3.5 align-text-bottom text-app-accent"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" /></svg>Giao xe tận nơi';
        }
      }
    });
  });

  // Confirm modal listeners (car-detail)
  var confirmModal = document.getElementById('confirm-modal');
  if (confirmModal) {
    document.getElementById('confirm-close')?.addEventListener('click', window.closeConfirmModal);
    document.getElementById('confirm-back')?.addEventListener('click', window.closeConfirmModal);
    document.getElementById('confirm-done')?.addEventListener('click', window.closeConfirmModal);
    document.getElementById('confirm-submit')?.addEventListener('click', function() {
      var modal = document.getElementById('confirm-modal');
      if (!modal) return;
      var confirmReview = document.getElementById('confirm-review');
      var confirmSuccess = document.getElementById('confirm-success');
      var phone = normalizePhone(modal.dataset.phone || '');
      var rentalType = modal.dataset.rentalType || 'one-day';

      var phoneError = validatePhone(phone);
      if (phoneError) {
        var activePanel = getActiveBookingPanel();
        var phoneInput = activePanel ? activePanel.querySelector('[data-phone-input], input[type="tel"]') : null;
        validatePhoneField(phoneInput, true);
        if (phoneInput) phoneInput.focus();
        return;
      }
      if (rentalType === 'one-day' && (!modal.dataset.startDate || modal.dataset.startDate === 'Chưa chọn')) { showToast('Vui lòng chọn ngày thuê!'); return; }
      if ((rentalType === 'multi-day' || rentalType === 'multi-range') && (!modal.dataset.startDate || modal.dataset.startDate === 'Chưa chọn' || !modal.dataset.endDate || modal.dataset.endDate === 'Chưa chọn')) { showToast('Vui lòng chọn khoảng ngày thuê!'); return; }
      if (rentalType === 'hourly' && (!modal.dataset.startDate || modal.dataset.startDate === 'Chưa chọn')) { showToast('Vui lòng chọn ngày và buổi thuê!'); return; }

      this.disabled = true;
      this.textContent = 'Đang gửi...';

      var formData = new FormData();
      formData.append('car_id', modal.dataset.carId || '');
      formData.append('car_name', document.getElementById('confirm-car')?.textContent?.trim() || '');
      formData.append('phone', phone);
      formData.append('rental_type', rentalType);
      formData.append('start_date', modal.dataset.startDate || '');
      formData.append('end_date', modal.dataset.endDate || '');
      formData.append('session_type', modal.dataset.sessionType || '');
      formData.append('pickup_type', modal.dataset.pickupType || 'shop');
      formData.append('total_price', (document.getElementById('confirm-total')?.textContent || '').replace(/\D/g, ''));
      formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content || '');

      var btn = this;
      fetch('{{ url("/booking/submit") }}', { method: 'POST', body: formData, headers: { 'Accept': 'application/json' } })
        .then(function(r) {
          return r.json().then(function(data) {
            if (!r.ok) {
              throw new Error(data.message || 'Có lỗi xảy ra, vui lòng thử lại.');
            }
            return data;
          });
        })
        .then(function(data) {
          if (data.success) {
            if (confirmReview && confirmSuccess) {
              confirmReview.classList.add('hidden');
              confirmSuccess.classList.remove('hidden');
            }
          } else {
            showToast(data.message || 'Có lỗi xảy ra, vui lòng thử lại.');
          }
        })
        .catch(function(error) {
          showToast('Lỗi kết nối, vui lòng thử lại sau.');
        })
        .finally(function() {
          btn.disabled = false;
          btn.textContent = 'Xác nhận đặt xe';
        });
    });
    confirmModal.addEventListener('click', function(e) {
      if (e.target === confirmModal) window.closeConfirmModal();
    });
  }

  // Mobile smooth scroll for nav links
  document.querySelectorAll('#mobile-wrapper .nav-swiper a[href^="#"]').forEach(function(link) {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      var target = document.querySelector('#mobile-wrapper ' + this.getAttribute('href'));
      if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  });

  // Mobile nav highlight on scroll
  var mobSections = document.querySelectorAll('#mobile-wrapper main section[id]');
  var mobNavLinks = document.querySelectorAll('#mobile-wrapper .nav-swiper a[href^="#"]');

  function getNavLink(id) {
    return document.querySelector('#mobile-wrapper .nav-swiper a[href="#' + id + '"]');
  }

  function centerNavSlide(slideEl) {
    if (!slideEl || !navSwiper) return;
    var idx = Array.from(navSwiper.slides).indexOf(slideEl);
    if (idx < 0) return;
    var slides = navSwiper.slides;
    var containerW = navSwiper.el.offsetWidth;
    var slideW = slides[idx].offsetWidth;
    var slideLeft = slides[idx].offsetLeft;
    var targetX = -(slideLeft - (containerW - slideW) / 2);
    var maxX = 0;
    var minX = -(navSwiper.wrapperEl.scrollWidth - containerW);
    targetX = Math.max(minX, Math.min(maxX, targetX));
    navSwiper.wrapperEl.style.transition = 'transform 200ms ease';
    navSwiper.setTranslate(targetX);
  }

  function updateMobNavHighlight() {
    var currentId = null;
    var threshold = 150;
    for (var i = mobSections.length - 1; i >= 0; i--) {
      var rect = mobSections[i].getBoundingClientRect();
      if (rect.top <= threshold) { currentId = mobSections[i].id; break; }
    }
    if (currentId) {
      mobNavLinks.forEach(function(a) {
        a.classList.remove('bg-app-accentSoft', 'text-app-accent');
        a.classList.add('text-app-muted');
      });
      var activeLink = getNavLink(currentId);
      if (activeLink) {
        activeLink.classList.remove('text-app-muted');
        activeLink.classList.add('bg-app-accentSoft', 'text-app-accent');
        centerNavSlide(activeLink.closest('.swiper-slide'));
      }
    }
  }

  var mobMainEl = document.querySelector('#mobile-wrapper main');
  if (mobMainEl && mobSections.length && mobNavLinks.length) {
    mobMainEl.addEventListener('scroll', function() {
      requestAnimationFrame(updateMobNavHighlight);
    });
    updateMobNavHighlight();
  }
}
document.addEventListener('DOMContentLoaded', initOnReady);

// ===== BOTTOM NAV ACTIVE =====
function initBottomNav() {
  var navItems = document.querySelectorAll("#bottom-nav .nav-item");
  if (!navItems.length) return;
  var currentPath = window.location.pathname;

  function setActiveNav(activeItem) {
    navItems.forEach(function(el) {
      el.classList.remove("text-app-accent");
      el.classList.add("text-app-muted");
    });
    if (activeItem) {
      activeItem.classList.remove("text-app-muted");
      activeItem.classList.add("text-app-accent");
    }
  }

  function openContactModal() {
    var isDesktop = window.innerWidth >= 1024;
    var modalId = isDesktop ? 'contact-desktop-modal' : 'contact-mobile-modal';
    var modal = document.getElementById(modalId);
    if (modal) {
      modal.classList.remove("hidden");
      document.body.style.overflow = "hidden";
    }
  }

  navItems.forEach(function(item) {
    var href = item.getAttribute("href");
    if (href && href !== "#") {
      var path = href.replace(window.location.origin, "");
      if (path === currentPath) {
        setActiveNav(item);
      }
    }
  });

  // Contact button: open modal directly
  var contactBtn = document.getElementById("nav-contact");
  if (contactBtn) {
    contactBtn.addEventListener("click", function(e) {
      e.preventDefault();
      e.stopPropagation();
      setActiveNav(this);
      openContactModal();
    });
  }

  // Other nav links with href="#": highlight only (no navigation needed)
  navItems.forEach(function(item) {
    var href = item.getAttribute("href");
    if (href !== "#") return;
    if (item.id === "nav-contact") return;
    item.addEventListener("click", function(e) {
      e.preventDefault();
      setActiveNav(this);
    });
  });
}
initBottomNav();

// ===== CONTACT MODAL: close on overlay click =====
[
  'date-modal',
  'contact-desktop-modal',
  'contact-mobile-modal',
  'thuexe-modal',
  'thuexe-modal-mobile',
  'confirm-modal'
].forEach(function(modalId) {
  var modal = document.getElementById(modalId);
  if (!modal) return;
  modal.addEventListener('click', function(e) {
    if (e.target !== modal) return;
    if (modalId === 'date-modal') {
      modal.classList.add('hidden');
      document.body.style.overflow = '';
      return;
    }
    closeOverlayModal(modal);
  });
});

// ===== IMAGE LIGHTBOX =====
(function() {
  var lightbox = document.getElementById('lightbox');
  var lightboxSwiperEl = document.getElementById('lightbox-swiper');
  var lightboxSwiperWrapper = document.getElementById('lightbox-swiper-wrapper');
  var lightboxLabel = document.getElementById('lightbox-label');
  var lightboxSub = document.getElementById('lightbox-sub');
  var lightboxCounter = document.getElementById('lightbox-counter');
  var lightboxClose = document.getElementById('lightbox-close');
  var lightboxPrev = document.getElementById('lightbox-prev');
  var lightboxNext = document.getElementById('lightbox-next');
  var navBtns = document.querySelectorAll('.lightbox-nav');
  if (!lightbox || !lightboxSwiperEl || !lightboxSwiperWrapper) return;

  var galleryImages = [];
  var galleryIndex = 0;
  var lightboxMode = null;
  var lightboxSwiper = null;

  function syncLightboxMeta(idx) {
    if (!galleryImages.length) return;
    galleryIndex = idx;
    var img = galleryImages[galleryIndex];
    if (lightboxLabel) lightboxLabel.textContent = img.label || img.alt || '';
    if (lightboxSub) {
      lightboxSub.textContent = img.sub || '';
      lightboxSub.classList.toggle('hidden', !img.sub);
    }
    if (lightboxCounter) {
      lightboxCounter.textContent = lightboxMode === 'gallery'
        ? (galleryIndex + 1) + ' / ' + galleryImages.length
        : '';
    }
  }

  function buildLightboxSlides() {
    lightboxSwiperWrapper.innerHTML = galleryImages.map(function(img) {
      return '<div class="swiper-slide flex items-center justify-center">' +
        '<img src="' + img.src + '" alt="' + (img.alt || '') + '" class="max-h-[80vh] max-w-full rounded-2xl object-contain shadow-2xl">' +
      '</div>';
    }).join('');
  }

  function initLightboxSwiper(initialIndex) {
    if (lightboxSwiper) {
      lightboxSwiper.destroy(true, true);
      lightboxSwiper = null;
    }

    buildLightboxSlides();

    lightboxSwiper = new Swiper(lightboxSwiperEl, {
      initialSlide: initialIndex || 0,
      slidesPerView: 1,
      spaceBetween: 0,
      grabCursor: galleryImages.length > 1,
      on: {
        init: function() {
          syncLightboxMeta(this.activeIndex || 0);
        },
        slideChange: function() {
          syncLightboxMeta(this.activeIndex || 0);
        }
      }
    });
  }

  function openLightbox(src, alt, label, sub, mode, index) {
    lightboxMode = mode || 'single';
    if (!galleryImages.length) {
      galleryImages = [{
        src: src,
        alt: alt || '',
        label: label || alt || '',
        sub: sub || ''
      }];
    }

    galleryIndex = typeof index === 'number' ? index : 0;
    navBtns.forEach(function(b) { b.classList.toggle('hidden', lightboxMode !== 'gallery' || galleryImages.length <= 1); });
    lightbox.classList.remove('hidden');
    lightbox.classList.add('flex');
    document.body.classList.add('overflow-hidden');
    requestAnimationFrame(function() {
      initLightboxSwiper(galleryIndex);
    });
  }

  function closeLightbox() {
    if (lightboxSwiper) {
      lightboxSwiper.destroy(true, true);
      lightboxSwiper = null;
    }
    lightboxSwiperWrapper.innerHTML = '';
    lightbox.classList.add('hidden');
    lightbox.classList.remove('flex');
    document.body.classList.remove('overflow-hidden');
    lightboxMode = null;
    galleryImages = [];
  }

  function showGalleryIndex(idx) {
    if (!galleryImages.length || !lightboxSwiper) return;
    var nextIndex = (idx + galleryImages.length) % galleryImages.length;
    lightboxSwiper.slideTo(nextIndex);
  }

  // Proof-card lightbox gallery (da-giao page)
  var proofCards = document.querySelectorAll('.proof-card');
  if (proofCards.length) {
    var proofGalleryImages = [];
    proofCards.forEach(function(card) {
      var img = card.querySelector('img');
      var labelEl = card.querySelector('p.font-extrabold');
      var subEl = card.querySelector('p.text-app-muted');
      if (!img || !labelEl || !subEl) return;
      proofGalleryImages.push({
        src: img.src,
        alt: img.alt || labelEl.textContent,
        label: labelEl.textContent,
        sub: subEl.textContent
      });
      img.addEventListener('click', function() {
        var idx = proofGalleryImages.findIndex(function(item) {
          return item.src === img.src && item.label === labelEl.textContent;
        });
        galleryImages = proofGalleryImages.slice();
        openLightbox(
          img.src,
          img.alt || labelEl.textContent,
          labelEl.textContent,
          subEl.textContent,
          'gallery',
          idx >= 0 ? idx : 0
        );
      });
    });
  }

  // Car-detail gallery lightbox
  var carGalleryArea = document.getElementById('car-gallery-area');
  if (carGalleryArea) {
    galleryImages = [];
    carGalleryArea.querySelectorAll('img').forEach(function(img) {
      galleryImages.push({ src: img.src, alt: img.alt, label: img.alt, sub: '' });
      img.addEventListener('click', function() {
        var idx = galleryImages.findIndex(function(item) { return item.src === this.src; }.bind(this));
        openLightbox(this.src, this.alt, this.alt, '', 'gallery', idx >= 0 ? idx : 0);
      });
    });
  }

  if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
  if (lightboxPrev) lightboxPrev.addEventListener('click', function(e) { e.stopPropagation(); showGalleryIndex(galleryIndex - 1); });
  if (lightboxNext) lightboxNext.addEventListener('click', function(e) { e.stopPropagation(); showGalleryIndex(galleryIndex + 1); });
  lightbox.addEventListener('click', function(e) {
    if (e.target === lightbox) closeLightbox();
  });
  document.addEventListener('keydown', function(e) {
    if (lightbox.classList.contains('hidden')) return;
    if (e.key === 'Escape') closeLightbox();
    if (lightboxMode === 'gallery') {
      if (e.key === 'ArrowLeft') showGalleryIndex(galleryIndex - 1);
      if (e.key === 'ArrowRight') showGalleryIndex(galleryIndex + 1);
    }
  });
})();

// ===== GUIDE & SEARCH (da-giao page) =====
(function() {
  // Guide toggle (desktop)
  var guideBtn = document.getElementById('guide-btn');
  var guidePopup = document.getElementById('guide-popup');
  if (guideBtn && guidePopup) {
    var guideOpen = false;
    guideBtn.addEventListener('click', function() {
      guideOpen = !guideOpen;
      guidePopup.classList.toggle('hidden', !guideOpen);
    });
  }

  // Mobile actions dropdown
  var mobileActionsToggle = document.getElementById('mobile-actions-toggle');
  var mobileActionsMenu = document.getElementById('mobile-actions-menu');
  if (mobileActionsToggle && mobileActionsMenu) {
    var actionsOpen = false;
    mobileActionsToggle.addEventListener('click', function(e) {
      e.stopPropagation();
      actionsOpen = !actionsOpen;
      mobileActionsMenu.classList.toggle('hidden', !actionsOpen);
      mobileActionsMenu.classList.toggle('flex', actionsOpen);
    });
    document.addEventListener('click', function(e) {
      if (!mobileActionsMenu.contains(e.target) && e.target !== mobileActionsToggle) {
        actionsOpen = false;
        mobileActionsMenu.classList.add('hidden');
        mobileActionsMenu.classList.remove('flex');
      }
    });
  }
  function closeMobileActionsMenu() {
    if (mobileActionsMenu) {
      actionsOpen = false;
      mobileActionsMenu.classList.add('hidden');
      mobileActionsMenu.classList.remove('flex');
    }
  }

  // Guide toggle (mobile)
  var guideBtnMobile = document.getElementById('guide-btn-mobile');
  var guidePopupMobile = document.getElementById('guide-popup-mobile');
  if (guideBtnMobile && guidePopupMobile) {
    var guideOpenMobile = false;
    guideBtnMobile.addEventListener('click', function() {
      closeMobileActionsMenu();
      guideOpenMobile = !guideOpenMobile;
      guidePopupMobile.classList.toggle('hidden', !guideOpenMobile);
    });
  }

  // Search toggle (desktop)
  var searchToggle = document.getElementById('search-toggle');
  var searchBar = document.getElementById('search-bar');
  var searchInput = document.getElementById('search-input');
  var searchClear = document.getElementById('search-clear');
  var searchEmpty = document.getElementById('search-empty');

  if (searchToggle && searchBar) {
    var searchOpen = false;
    searchToggle.addEventListener('click', function() {
      searchOpen = !searchOpen;
      searchBar.classList.toggle('hidden', !searchOpen);
      if (searchOpen) {
        setTimeout(function() { if (searchInput) searchInput.focus(); }, 100);
      } else {
        if (searchInput) searchInput.value = '';
        filterCards();
      }
    });
  }

  function filterCards() {
    var q = searchInput ? searchInput.value.toLowerCase().trim() : '';
    var cards = document.querySelectorAll('.proof-card');
    var found = false;
    cards.forEach(function(card) {
      var titleEl = card.querySelector('p.font-extrabold');
      var dateEl = card.querySelector('p.text-app-muted');
      if (!titleEl || !dateEl) return;
      var title = titleEl.textContent.toLowerCase();
      var date = dateEl.textContent.toLowerCase();
      var match = !q || title.indexOf(q) !== -1 || date.indexOf(q) !== -1;
      card.style.display = match ? '' : 'none';
      if (match) found = true;
    });
    if (searchEmpty) searchEmpty.classList.toggle('hidden', found || !q);
    if (searchClear) searchClear.classList.toggle('hidden', !q);
  }

  if (searchInput) searchInput.addEventListener('input', filterCards);
  if (searchClear) {
    searchClear.addEventListener('click', function() {
      if (searchInput) {
        searchInput.value = '';
        filterCards();
        searchInput.focus();
      }
    });
  }

  // Search toggle (mobile)
  var searchToggleMobile = document.getElementById('search-toggle-mobile');
  var searchBarMobile = document.getElementById('search-bar-mobile');
  var searchInputMobile = document.getElementById('search-input-mobile');
  var searchClearMobile = document.getElementById('search-clear-mobile');
  var searchEmptyMobile = document.getElementById('search-empty-mobile');

  if (searchToggleMobile && searchBarMobile) {
    var searchOpenMobile = false;
    searchToggleMobile.addEventListener('click', function() {
      closeMobileActionsMenu();
      searchOpenMobile = !searchOpenMobile;
      searchBarMobile.classList.toggle('hidden', !searchOpenMobile);
      if (searchOpenMobile) {
        setTimeout(function() { if (searchInputMobile) searchInputMobile.focus(); }, 100);
      } else {
        if (searchInputMobile) searchInputMobile.value = '';
        filterCardsMobile();
      }
    });
  }

  function filterCardsMobile() {
    var q = searchInputMobile ? searchInputMobile.value.toLowerCase().trim() : '';
    var cards = document.querySelectorAll('.proof-card');
    var found = false;
    cards.forEach(function(card) {
      var titleEl = card.querySelector('p.font-extrabold');
      var dateEl = card.querySelector('p.text-app-muted');
      if (!titleEl || !dateEl) return;
      var title = titleEl.textContent.toLowerCase();
      var date = dateEl.textContent.toLowerCase();
      var match = !q || title.indexOf(q) !== -1 || date.indexOf(q) !== -1;
      card.style.display = match ? '' : 'none';
      if (match) found = true;
    });
    if (searchEmptyMobile) searchEmptyMobile.classList.toggle('hidden', found || !q);
    if (searchClearMobile) searchClearMobile.classList.toggle('hidden', !q);
  }

  if (searchInputMobile) searchInputMobile.addEventListener('input', filterCardsMobile);
  if (searchClearMobile) {
    searchClearMobile.addEventListener('click', function() {
      if (searchInputMobile) {
        searchInputMobile.value = '';
        filterCardsMobile();
        searchInputMobile.focus();
      }
    });
  }
})();

// ===== LOGO CLICK: scroll to top on home, go home on other pages =====
(function() {
  var homePath = '{{ parse_url(route("index"), PHP_URL_PATH) }}' || '/';
  var isHome = window.location.pathname === homePath || window.location.pathname === '/' || window.location.pathname === '';
  if (!isHome) return;
  document.querySelectorAll('#logo-link, #logo-link-desktop').forEach(function(logo) {
    logo.addEventListener('click', function(e) {
      e.preventDefault();
      var mainEl = document.querySelector('#mobile-wrapper main') || document.querySelector('main');
      if (mainEl) {
        mainEl.scrollTo({ top: 0, behavior: 'smooth' });
      } else {
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }
    });
  });
})();
</script>


