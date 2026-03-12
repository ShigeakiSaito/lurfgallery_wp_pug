document.addEventListener("DOMContentLoaded", () => {

  // ======================
  // menu toggle
  // ======================
  document.querySelectorAll('.js-menu-toggle').forEach((toggle) => {
    toggle.addEventListener('click', () => {
      toggle.classList.toggle('is-active');
      const menu = document.querySelector('.js-menu');
      if (menu) menu.classList.toggle('is-active');
      document.documentElement.classList.toggle('is-active');
    });
  });

  // ======================
  // fadeUp
  // ======================
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-active');
        observer.unobserve(entry.target);
      }
    });
  }, {
    rootMargin: '0px 0px -200px 0px',
  });

  document.querySelectorAll('.js-fade-up').forEach(el => {
    observer.observe(el);
  });

  // ======================
  // 共通Swiper
  // ======================
  function initMvSwiper(containerSelector, swiperSelector) {
    const container = document.querySelector(containerSelector);
    if (!container) return;

    const swiperEl = container.querySelector(swiperSelector);
    if (!swiperEl) return;

    const progressWrapper = container.querySelector('.mv-progressbars');
    const controllerWrapper = container.querySelector('.swiper-controller-wrapper');

    const slides = swiperEl.querySelectorAll(
      '.swiper-slide:not(.swiper-slide-duplicate)'
    );

    if (slides.length <= 1) {
      if (controllerWrapper) controllerWrapper.style.display = 'none';
      container.classList.add('is-single');
      return;
    }

    if (progressWrapper) {
      progressWrapper.innerHTML = '';

      slides.forEach(() => {
        const bar = document.createElement('div');
        bar.className = 'mv-progressbar';

        const span = document.createElement('span');
        bar.appendChild(span);

        progressWrapper.appendChild(bar);
      });
    }

    const progressBars = progressWrapper
      ? progressWrapper.querySelectorAll('.mv-progressbar span')
      : [];

    new Swiper(swiperEl, {
      loop: true,
      speed: 800,
      autoplay: {
        delay: 4000,
        disableOnInteraction: false,
      },
      navigation: {
        nextEl: container.querySelector('.mv-button-next'),
        prevEl: container.querySelector('.mv-button-prev'),
      },
      on: {
        autoplayTimeLeft(swiper, time, progress) {
          const active = swiper.realIndex;

          progressBars.forEach((bar, i) => {
            if (i < active) {
              bar.style.width = '100%';
            } else if (i === active) {
              bar.style.width = `${(1 - progress) * 100}%`;
            } else {
              bar.style.width = '0%';
            }
          });
        },
      },
    });
  }

  // 呼び出し
  initMvSwiper('.top__mv', '#topMvSwiper');
  initMvSwiper('.cafe__mv', '#cafeMvSwiper');


  // ======================
  // アコーディオン
  // ======================
  document.querySelectorAll('.js-ac-toggle').forEach(toggle => {
    const content = toggle.nextElementSibling;

    // 初期状態
    if (toggle.classList.contains('is-opened')) {
      content.style.height = content.scrollHeight + 'px';
    } else {
      content.style.height = '0px';
    }

    toggle.addEventListener('click', () => {
      const isOpen = toggle.classList.contains('is-opened');

      if (isOpen) {
        content.style.height = content.scrollHeight + 'px';
        requestAnimationFrame(() => {
          content.style.height = '0px';
        });
        toggle.classList.remove('is-opened');
      } else {
        toggle.classList.add('is-opened');
        content.style.height = content.scrollHeight + 'px';

        content.addEventListener('transitionend', () => {
          content.style.height = 'auto';
        }, { once: true });
      }
    });
  });  
});