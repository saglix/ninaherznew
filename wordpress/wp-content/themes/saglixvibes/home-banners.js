document.querySelectorAll('[data-site-home-banners]').forEach((root) => {
  const slides = Array.from(root.querySelectorAll('.site-home-banners__slide'));
  const dots = Array.from(root.querySelectorAll('[data-banner-dot]'));
  const prev = root.querySelector('[data-banner-prev]');
  const next = root.querySelector('[data-banner-next]');

  if (slides.length < 2) {
    return;
  }

  let activeIndex = 0;
  let pointerStartX = null;
  let pointerStartY = null;

  const showSlide = (nextIndex) => {
    activeIndex = (nextIndex + slides.length) % slides.length;

    slides.forEach((slide, index) => {
      const isActive = index === activeIndex;
      slide.classList.toggle('is-active', isActive);
      slide.setAttribute('aria-hidden', isActive ? 'false' : 'true');
    });

    dots.forEach((dot, index) => {
      const isActive = index === activeIndex;
      dot.classList.toggle('is-active', isActive);
      dot.setAttribute('aria-current', isActive ? 'true' : 'false');
    });
  };

  prev?.addEventListener('click', () => showSlide(activeIndex - 1));
  next?.addEventListener('click', () => showSlide(activeIndex + 1));

  dots.forEach((dot) => {
    dot.addEventListener('click', () => {
      showSlide(Number(dot.dataset.bannerDot));
    });
  });

  root.addEventListener('pointerdown', (event) => {
    pointerStartX = event.clientX;
    pointerStartY = event.clientY;
  });

  root.addEventListener('pointerup', (event) => {
    if (pointerStartX === null || pointerStartY === null) {
      return;
    }

    const diffX = event.clientX - pointerStartX;
    const diffY = event.clientY - pointerStartY;
    pointerStartX = null;
    pointerStartY = null;

    if (Math.abs(diffX) < 48 || Math.abs(diffX) < Math.abs(diffY)) {
      return;
    }

    showSlide(activeIndex + (diffX > 0 ? -1 : 1));
  });

  root.addEventListener('pointercancel', () => {
    pointerStartX = null;
    pointerStartY = null;
  });
});
