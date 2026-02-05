document.addEventListener("DOMContentLoaded", () => {
  // menu toggle
  document.querySelectorAll('.js-menu-toggle').forEach((toggle) => {
    toggle.addEventListener('click', () => {
      toggle.classList.toggle('is-active');
      const menu = document.querySelector('.js-menu');
      if (menu) {
        menu.classList.toggle('is-active');
      }
      document.documentElement.classList.toggle('is-active');
    });
  });

  // fadeUp
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
});