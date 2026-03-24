window.addEventListener('load', () => {
  // topMvSwiper
  const mvContainer = document.querySelector('.top__mv');
  const progressWrapper = document.querySelector('.mv-progressbars');
  const controllerWrapper = document.querySelector('.top__mv .swiper-controller-wrapper');

  // 実スライドの枚数
  const swiperWrapper = document.querySelector('#topMvSwiper .swiper-wrapper');
  const slides = swiperWrapper
    ? swiperWrapper.querySelectorAll(':scope > .swiper-slide')
    : [];
  const slideCount = slides.length;

  // --- ここから枚数判定 ---
  if (slideCount <= 1) {
    // 1枚以下の時の処理
    if (controllerWrapper) controllerWrapper.style.display = 'none';
    if (mvContainer) mvContainer.classList.add('is-single');

  } else {
    // Swiper 12のloop modeは最低3枚必要なため、2枚の場合はDOMを複製
    if (slideCount === 2) {
      slides.forEach((slide) => {
        swiperWrapper.appendChild(slide.cloneNode(true));
      });
    }

    // プログレスバー生成（実スライド枚数分）
    progressWrapper.innerHTML = '';
    for (let i = 0; i < slideCount; i++) {
      const bar = document.createElement('div');
      bar.className = 'mv-progressbar';
      const span = document.createElement('span');
      bar.appendChild(span);
      progressWrapper.appendChild(bar);
    }

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
          const active = swiper.realIndex % slideCount;
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