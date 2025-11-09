// ========================================
// VALIDACIÓN EN TIEMPO REAL
// ========================================
const setupFormValidation = () => {
  const forms = document.querySelectorAll('form[novalidate]');
  
  forms.forEach(form => {
    const inputs = form.querySelectorAll('input[required], select[required]');
    
    inputs.forEach(input => {
      // Validación al perder el foco
      input.addEventListener('blur', () => {
        validateInput(input);
      });
      
      // Limpiar error al escribir
      input.addEventListener('input', () => {
        if (input.classList.contains('is-invalid')) {
          input.classList.remove('is-invalid');
        }
      });
    });
    
    // Validación al enviar
    form.addEventListener('submit', (e) => {
      let isValid = true;
      
      inputs.forEach(input => {
        if (!validateInput(input)) {
          isValid = false;
        }
      });
      
      // Si no es válido, prevenir envío y hacer scroll al primer error
      if (!isValid) {
        e.preventDefault();
        const firstInvalid = form.querySelector('.is-invalid');
        if (firstInvalid) {
          firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
          firstInvalid.focus();
        }
      }
    });
  });
};

// Función de validación individual
const validateInput = (input) => {
  const value = input.value.trim();
  const type = input.type;
  let isValid = true;
  
  // Validación de campo vacío
  if (input.hasAttribute('required') && !value) {
    isValid = false;
  }
  
  // Validación de email
  if (type === 'email' && value) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(value)) {
      isValid = false;
    }
  }
  
  // Validación de contraseña (mínimo 8 caracteres)
  if (input.name === 'password' && value && value.length < 8) {
    isValid = false;
  }
  
  // Validación de confirmación de contraseña
  if (input.name === 'password_confirmation') {
    const passwordInput = document.querySelector('input[name="password"]');
    if (passwordInput && value !== passwordInput.value) {
      isValid = false;
    }
  }
  
  // Aplicar clase de validación
  if (isValid) {
    input.classList.remove('is-invalid');
  } else {
    input.classList.add('is-invalid');
  }
  
  return isValid;
};

// ========================================
// INDICADOR DE FUERZA DE CONTRASEÑA
// ========================================
const setupPasswordStrength = () => {
  const passwordInputs = document.querySelectorAll('input[name="password"]');
  
  passwordInputs.forEach(input => {
    // Crear indicador si no existe
    let indicator = input.parentElement.parentElement.querySelector('.password-strength');
    
    if (!indicator && input.name === 'password' && !input.autocomplete.includes('current')) {
      indicator = document.createElement('div');
      indicator.className = 'password-strength mt-2';
      indicator.innerHTML = `
        <div class="d-flex gap-1 mb-1">
          <div class="strength-bar"></div>
          <div class="strength-bar"></div>
          <div class="strength-bar"></div>
          <div class="strength-bar"></div>
        </div>
        <small class="strength-text text-muted"></small>
      `;
      
      const parentGroup = input.closest('.mb-3, .mb-4');
      if (parentGroup) {
        parentGroup.appendChild(indicator);
      }
      
      // Agregar estilos
      if (!document.getElementById('password-strength-styles')) {
        const style = document.createElement('style');
        style.id = 'password-strength-styles';
        style.textContent = `
          .strength-bar {
            height: 4px;
            flex: 1;
            background: var(--color-gray-200);
            border-radius: 2px;
            transition: background 0.3s ease;
          }
          .strength-bar.active-weak { background: #ef4444; }
          .strength-bar.active-medium { background: #f59e0b; }
          .strength-bar.active-good { background: #10b981; }
          .strength-bar.active-strong { background: #059669; }
          .password-strength { opacity: 0; transition: opacity 0.3s ease; }
          .password-strength.show { opacity: 1; }
        `;
        document.head.appendChild(style);
      }
    }
    
    input.addEventListener('input', () => {
      if (!indicator) return;
      
      const value = input.value;
      const bars = indicator.querySelectorAll('.strength-bar');
      const text = indicator.querySelector('.strength-text');
      
      if (!value) {
        indicator.classList.remove('show');
        bars.forEach(bar => bar.className = 'strength-bar');
        return;
      }
      
      indicator.classList.add('show');
      
      // Calcular fuerza
      let strength = 0;
      if (value.length >= 8) strength++;
      if (value.length >= 12) strength++;
      if (/[a-z]/.test(value) && /[A-Z]/.test(value)) strength++;
      if (/\d/.test(value)) strength++;
      if (/[^a-zA-Z0-9]/.test(value)) strength++;
      
      // Normalizar a 4 niveles
      strength = Math.min(Math.ceil(strength / 1.5), 4);
      
      // Actualizar barras
      bars.forEach((bar, index) => {
        bar.className = 'strength-bar';
        if (index < strength) {
          if (strength === 1) bar.classList.add('active-weak');
          else if (strength === 2) bar.classList.add('active-medium');
          else if (strength === 3) bar.classList.add('active-good');
          else bar.classList.add('active-strong');
        }
      });
      
      // Actualizar texto
      const messages = ['Débil', 'Media', 'Buena', 'Fuerte'];
      const colors = ['text-danger', 'text-warning', 'text-success', 'text-success'];
      text.textContent = `Seguridad: ${messages[strength - 1] || 'Débil'}`;
      text.className = `strength-text ${colors[strength - 1] || 'text-danger'}`;
    });
  });
};

// ========================================
// AUTO-OCULTAR ALERTAS
// ========================================
const setupAutoHideAlerts = () => {
  const alerts = document.querySelectorAll('.alert');
  
  alerts.forEach(alert => {
    // Solo auto-ocultar alertas de éxito (si las hay en el futuro)
    if (alert.classList.contains('alert-success')) {
      setTimeout(() => {
        alert.style.transition = 'opacity 0.3s ease';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 300);
      }, 5000);
    }
  });
};

// ========================================
// ANIMACIÓN DE ENTRADA
// ========================================
const setupEntryAnimation = () => {
  const authCard = document.querySelector('.auth-card');
  const authHero = document.querySelector('.auth-hero');
  
  if (authCard) {
    authCard.style.opacity = '0';
    authCard.style.transform = 'translateY(20px)';
    
    setTimeout(() => {
      authCard.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
      authCard.style.opacity = '1';
      authCard.style.transform = 'translateY(0)';
    }, 100);
  }
  
  if (authHero) {
    authHero.style.opacity = '0';
    authHero.style.transform = 'translateX(-20px)';
    
    setTimeout(() => {
      authHero.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
      authHero.style.opacity = '1';
      authHero.style.transform = 'translateX(0)';
    }, 200);
  }
};

// ========================================
// PREVENIR DOBLE SUBMIT
// ========================================
const setupPreventDoubleSubmit = () => {
  const forms = document.querySelectorAll('form');
  
  forms.forEach(form => {
    form.addEventListener('submit', function(e) {
      const submitBtn = this.querySelector('button[type="submit"]');
      
      if (submitBtn && !submitBtn.disabled) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
          <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
          Procesando...
        `;
        
        // Re-habilitar después de 5 segundos por si hay error
        setTimeout(() => {
          submitBtn.disabled = false;
          submitBtn.innerHTML = submitBtn.getAttribute('data-original-text') || 'Enviar';
        }, 5000);
      }
    });
    
    // Guardar texto original del botón
    const submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn) {
      submitBtn.setAttribute('data-original-text', submitBtn.textContent);
    }
  });
};

// ========================================
// MEJORAR SELECT DE ROL CON ICONOS
// ========================================
const enhanceRoleSelect = () => {
  const roleSelect = document.querySelector('select[name="role"]');
  
  if (roleSelect) {
    const options = roleSelect.querySelectorAll('option');
    options.forEach(option => {
      if (option.value === 'Empresa') {
        option.textContent = '🏢 ' + option.textContent;
      } else if (option.value === 'Candidato') {
        option.textContent = '👤 ' + option.textContent;
      }
    });
  }
};

// ========================================
// INICIALIZACIÓN
// ========================================
document.addEventListener('DOMContentLoaded', () => {
  setupFormValidation();
  setupPasswordStrength();
  setupAutoHideAlerts();
  setupEntryAnimation();
  setupPreventDoubleSubmit();
  enhanceRoleSelect();
  
  // Agregar focus al primer input
  const firstInput = document.querySelector('input:not([type="hidden"])');
  if (firstInput) {
    setTimeout(() => firstInput.focus(), 300);
  }
});