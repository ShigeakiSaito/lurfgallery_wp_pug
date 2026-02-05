window.addEventListener('load', () => {
  // topMvSwiper
  const progressWrapper = document.querySelector('.mv-progressbars');

  const slides = document.querySelectorAll(
    '#topMvSwiper .swiper-slide:not(.swiper-slide-duplicate)'
  );

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

  // news swiper 
  const topNewsSwiper = new Swiper('#topNewsSwiper', {
    loop: true,
    speed: 800,
    pagination: {
      el: '.news-pagination',
      type: 'fraction',
    },
    navigation: {
      nextEl: '.news-button-next',
      prevEl: '.news-button-prev',
    },
  });
});