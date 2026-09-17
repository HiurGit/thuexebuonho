@php
    $htxMarqueeEnabled = \App\Models\Setting::get('marquee_enabled', '1') !== '0';
    $htxMarqueeText = \App\Models\Setting::get('marquee_text', 'QUÝ KHÁCH THUÊ XE CÀNG LÂU - GIÁ CÀNG TỐT!');
@endphp

@if($htxMarqueeEnabled && $htxMarqueeText !== '')
<div class="htx-marquee">
    <div class="htx-marquee-track">
        <span class="htx-marquee-item">{{ $htxMarqueeText }} <span class="htx-marquee-sep">★</span></span>
        <span class="htx-marquee-item">{{ $htxMarqueeText }} <span class="htx-marquee-sep">★</span></span>
    </div>
</div>
@endif