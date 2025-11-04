
document.querySelectorAll('a[href^="#"]').forEach(a=>{
  a.addEventListener('click', e=>{
    const id = a.getAttribute('href');
    if(id.length > 1){
      e.preventDefault();
      document.querySelector(id)?.scrollIntoView({behavior:'smooth', block:'start'});
    }
  });
});

// Animación simple de la barra de compatibilidad del hero
window.addEventListener('load', ()=>{
  const bar = document.querySelector('.hero-card .progress-bar');
  if(!bar) return;
  const width = bar.style.width || '78%';
  bar.style.width = '0%';
  setTimeout(()=>{ bar.style.transition='width .9s ease'; bar.style.width = width; }, 200);
});
