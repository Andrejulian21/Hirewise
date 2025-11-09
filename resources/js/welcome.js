// ========================================
// NAVBAR SCROLL EFFECT
// ========================================
let lastScroll = 0;
const navbar = document.querySelector('.navbar');

window.addEventListener('scroll', () => {
  const currentScroll = window.pageYOffset;
  
  // Añadir sombra al hacer scroll
  if (currentScroll > 50) {
    navbar.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.08)';
  } else {
    navbar.style.boxShadow = '0 1px 2px 0 rgb(0 0 0 / 0.05)';
  }
  
  lastScroll = currentScroll;
});

// ========================================
// SMOOTH SCROLL PARA ANCLAS
// ========================================
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    const href = this.getAttribute('href');
    
    // Ignorar anclas vacías o solo "#"
    if (!href || href === '#') return;
    
    const target = document.querySelector(href);
    if (target) {
      e.preventDefault();
      
      const navbarHeight = navbar.offsetHeight;
      const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - navbarHeight - 20;
      
      window.scrollTo({
        top: targetPosition,
        behavior: 'smooth'
      });
      
      // Cerrar el menú móvil si está abierto
      const navbarCollapse = document.querySelector('.navbar-collapse');
      if (navbarCollapse.classList.contains('show')) {
        const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
          toggle: true
        });
      }
    }
  });
});

// ========================================
// ANIMACIÓN DE PROGRESS BAR
// ========================================
const observerOptions = {
  threshold: 0.5,
  rootMargin: '0px'
};

const progressObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      const progressBar = entry.target.querySelector('.progress-bar');
      if (progressBar && !progressBar.classList.contains('animated')) {
        progressBar.classList.add('animated');
        // La animación se maneja con CSS transition
      }
    }
  });
}, observerOptions);

const heroCard = document.querySelector('.hero-card');
if (heroCard) {
  progressObserver.observe(heroCard);
}

// ========================================
// ANIMACIÓN DE ENTRADA PARA CARDS
// ========================================
const cardObserver = new IntersectionObserver((entries) => {
  entries.forEach((entry, index) => {
    if (entry.isIntersecting) {
      setTimeout(() => {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
      }, index * 100); // Efecto escalonado
      cardObserver.unobserve(entry.target);
    }
  });
}, observerOptions);

// Aplicar a todas las tarjetas de características y precios
document.querySelectorAll('.feature.card, .price.card').forEach(card => {
  card.style.opacity = '0';
  card.style.transform = 'translateY(20px)';
  card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
  cardObserver.observe(card);
});

// ========================================
// ANIMACIÓN DE NÚMEROS (OPCIONAL)
// ========================================
function animateNumber(element, target, duration = 1500) {
  const start = 0;
  const increment = target / (duration / 16);
  let current = start;
  
  const timer = setInterval(() => {
    current += increment;
    if (current >= target) {
      current = target;
      clearInterval(timer);
    }
    element.textContent = Math.floor(current);
  }, 16);
}

// Buscar elementos con atributo data-animate-number
const numberObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      const target = parseInt(entry.target.getAttribute('data-target'));
      if (target && !entry.target.classList.contains('animated')) {
        entry.target.classList.add('animated');
        animateNumber(entry.target, target);
      }
      numberObserver.unobserve(entry.target);
    }
  });
}, observerOptions);

document.querySelectorAll('[data-animate-number]').forEach(el => {
  numberObserver.observe(el);
});

// ========================================
// THEME TOGGLE (OPCIONAL - PARA FUTURO)
// ========================================
const initTheme = () => {
  const savedTheme = localStorage.getItem('theme') || 'light';
  document.documentElement.setAttribute('data-bs-theme', savedTheme);
};

// initTheme(); // Descomentar si quieres usar tema oscuro

// ========================================
// PREVENIR COMPORTAMIENTO POR DEFECTO EN ENLACES VACÍOS
// ========================================
document.querySelectorAll('a[href="#"]').forEach(link => {
  link.addEventListener('click', (e) => {
    e.preventDefault();
  });
});