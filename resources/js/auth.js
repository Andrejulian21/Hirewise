// Toggle mostrar/ocultar contraseña
document.addEventListener('DOMContentLoaded', () => {
  const btn = document.querySelector('.toggle-pass');
  const input = document.getElementById('password');
  const text = document.querySelector('.toggle-pass .toggle-text');

  if(btn && input && text){
    btn.addEventListener('click', () => {
      const isPassword = input.getAttribute('type') === 'password';
      input.setAttribute('type', isPassword ? 'text' : 'password');
      text.textContent = isPassword ? 'Ocultar' : 'Mostrar';
      input.focus();
    });
  }
});

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-toggle="password"]').forEach((btn) => {
    const input = document.getElementById(btn.dataset.target);
    if (!input) return;

    btn.addEventListener('click', () => {
      const isHidden = input.type === 'password';
      input.type = isHidden ? 'text' : 'password';

      const t = btn.querySelector('.toggle-text');
      if (t) t.textContent = isHidden ? 'Ocultar' : 'Mostrar';

      btn.setAttribute('aria-pressed', isHidden ? 'true' : 'false');
      input.focus({ preventScroll: true });
    });
  });
});