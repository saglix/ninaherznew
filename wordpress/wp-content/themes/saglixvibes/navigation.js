const menuToggle = document.querySelector('.site-menu-toggle');
const siteHeader = document.querySelector('.site-header');

if (menuToggle && siteHeader) {
  menuToggle.addEventListener('click', () => {
    const isOpen = siteHeader.classList.toggle('is-menu-open');
    menuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
  });
}
