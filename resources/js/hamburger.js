document.addEventListener('DOMContentLoaded', function () {
  const btn = document.getElementById('hamburgerBtn');
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebarOverlay');
  if (!btn || !sidebar || !overlay) return;

  const toggle = () => {
    const open = sidebar.classList.toggle('open');
    overlay.classList.toggle('visible', open);
    btn.setAttribute('aria-expanded', open ? 'true' : 'false');
  };

  btn.addEventListener('click', toggle);
  overlay.addEventListener('click', toggle);
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && sidebar.classList.contains('open')) toggle();
  });
});