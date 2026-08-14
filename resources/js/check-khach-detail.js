import Swiper from 'swiper';
import { Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';

const evidenceSwiperEl = document.getElementById('evidence-swiper');

if (!evidenceSwiperEl) {
    const lightboxEl = document.getElementById('evidence-lightbox');
    if (lightboxEl) lightboxEl.remove();
} else {
    new Swiper(evidenceSwiperEl, {
        modules: [Pagination],
        slidesPerView: 3,
        spaceBetween: 12,
        speed: 400,
        pagination: {
            el: '#evidence-pagination',
            clickable: true,
        },
    });

    const lightbox = document.getElementById('evidence-lightbox');
    const lightboxSwiperEl = document.getElementById('lightbox-swiper');
    const lightboxWrapper = lightboxSwiperEl ? lightboxSwiperEl.querySelector('.swiper-wrapper') : null;
    const slides = Array.prototype.slice.call(
        document.querySelectorAll('#evidence-swiper .swiper-slide img')
    );
    const srcs = slides.map((img) => img.getAttribute('src')).filter(Boolean);

    let lightboxSwiper = null;

    function buildLightboxSlides() {
        if (!lightboxWrapper) return;
        lightboxWrapper.innerHTML = srcs.map((src, i) => {
            return '<div class="swiper-slide !flex items-center justify-center">' +
                '<img src="' + src + '" alt="Bằng chứng ' + (i + 1) + '" class="max-h-[80vh] max-w-full object-contain">' +
                '</div>';
        }).join('');
    }

    function openLightbox(index) {
        if (!lightbox || srcs.length === 0) return;
        if (!lightboxSwiper) {
            buildLightboxSlides();
            lightboxSwiper = new Swiper('#lightbox-swiper', {
                slidesPerView: 1,
                spaceBetween: 0,
                speed: 300,
                pagination: {
                    el: '#lightbox-pagination',
                    clickable: true,
                },
            });
        }
        lightbox.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        lightboxSwiper.slideTo(index, 0);
    }

    function closeLightbox() {
        if (!lightbox) return;
        lightbox.classList.add('hidden');
        document.body.style.overflow = '';
    }

    document.addEventListener('click', function (e) {
        const img = e.target.closest('#evidence-swiper .swiper-slide img');
        if (img) {
            openLightbox(slides.indexOf(img));
            return;
        }
        if (e.target.closest('#lightbox-close')) {
            closeLightbox();
            return;
        }
        if (e.target.closest('#evidence-lightbox')) {
            if (!e.target.closest('#lightbox-swiper img') && !e.target.closest('#lightbox-pagination')) {
                closeLightbox();
            }
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeLightbox();
    });
}
