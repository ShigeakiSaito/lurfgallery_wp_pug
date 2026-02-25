window.addEventListener('load', () => {
  // topMvSwiper
  const mvContainer = document.querySelector('.top__mv');
  const progressWrapper = document.querySelector('.mv-progressbars');
  const controllerWrapper = document.querySelector('.swiper-controller-wrapper');

  // 複製スライドを除いた実質的な枚数
  const slides = document.querySelectorAll(
    '#topMvSwiper .swiper-slide:not(.swiper-slide-duplicate)'
  );

  // --- ここから枚数判定 ---
  if (slides.length <= 1) {
    // 1枚以下の時の処理
    if (controllerWrapper) controllerWrapper.style.display = 'none';
    if (mvContainer) mvContainer.classList.add('is-single');
    
  } else {
    // 2枚以上ある時のみ、今までの処理を実行
    progressWrapper.innerHTML = '';
    slides.forEach(() => {
      const bar = document.createElement('div');
      bar.className = 'mv-progressbar';
      const span = document.createElement('span');
      bar.appendChild(span);
      progressWrapper.appendChild(bar);
    });

    const progressBars = progressWrapper.querySelectorAll('.mv-progressbar span');

    const topMvSwiper = new Swiper('#topMvSwiper', {
      loop: true,
      speed: 800,
      autoplay: {
        delay: 4000,
        disableOnInteraction: false,
      },
      navigation: {
        nextEl: '.mv-button-next',
        prevEl: '.mv-button-prev',
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

  // news swiper 
  const swiperEl = document.querySelector('#topNewsSwiper');
  const controller = document.querySelector('.top__newslist .swiper-controller-wrapper');
  const slideCount = swiperEl.querySelectorAll('#topNewsSwiper .swiper-slide').length;

  if (slideCount === 0) {
    swiperEl.innerHTML = '<p class="top__notice">There are currently no news updates.</p>';
    
    if (controller) {
      controller.classList.add('is-empty');
    }

  } else {
    const topNewsSwiper = new Swiper('#topNewsSwiper', {
      loop: slideCount > 1,
      speed: 800,
      pagination: slideCount > 1 ? {
        el: '.news-pagination',
        type: 'fraction',
      } : false,
      navigation: slideCount > 1 ? {
        nextEl: '.news-button-next',
        prevEl: '.news-button-prev',
      } : false,
    });
  }
});