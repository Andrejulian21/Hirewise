@extends('layouts.app')

@section('title', 'Crear cuenta — Hirewise')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
<section class="auth-wrap">
  <div class="container">
    <div class="row g-4 align-items-center justify-content-center">
      <!-- Lado visual -->
      <div class="col-lg-6 d-none d-lg-block">
        <div class="auth-hero rounded-4 p-4 p-xl-5 shadow-sm">
          <span class="badge rounded-pill text-bg-light-subtle accent-badge mb-3">
            <i class="bi bi-person-plus me-1"></i>Únete a Hirewise
          </span>
          <h2 class="fw-bold mb-3">Empieza a contratar o postular en minutos</h2>
          <p class="text-secondary mb-4">
            Elige tu rol (Empresa o Candidato) y comienza a usar Hirewise con una experiencia simple y profesional.
          </p>
          
          <div class="row g-3 mt-4">
            <div class="col-12">
              <div class="d-flex align-items-start gap-3 p-3 bg-white rounded-3">
                <div class="icon-bubble" style="width: 40px; height: 40px; font-size: 1.125rem;">
                  <i class="bi bi-building"></i>
                </div>
                <div>
                  <h6 class="fw-semibold mb-1">Para Empresas</h6>
                  <small class="text-secondary">Publica vacantes y encuentra el talento perfecto</small>
                </div>
              </div>
            </div>
            
            <div class="col-12">
              <div class="d-flex align-items-start gap-3 p-3 bg-white rounded-3">
                <div class="icon-bubble" style="width: 40px; height: 40px; font-size: 1.125rem;">
                  <i class="bi bi-person-badge"></i>
                </div>
                <div>
                  <h6 class="fw-semibold mb-1">Para Candidatos</h6>
                  <small class="text-secondary">Encuentra oportunidades que se ajusten a tu perfil</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tarjeta de registro -->
      <div class="col-lg-7 col-xl-6">
        <div class="card auth-card shadow-sm border-0">
          <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
              <div class="d-inline-flex align-items-center gap-2 mb-2">
                <span class="brand-dot"></span>
                <h1 class="h4 fw-bold mb-0">Hirewise</h1>
              </div>
              <p class="text-secondary mb-0">Crea tu cuenta gratuita</p>
            </div>

            {{-- Errores --}}
            @if ($errors->any())
              <div class="alert alert-danger py-2 small mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Revisa los siguientes errores:</strong>
                <ul class="mb-0 ps-3 mt-2">
                  @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            {{-- Formulario de registro --}}
            <form method="POST" action="{{ route('register.store') }}" novalidate>
              @csrf

              <div class="mb-3">
                <label for="name" class="form-label">Nombre completo</label>
                <div class="input-group input-group-lg">
                  <span class="input-group-text bg-white">
                    <i class="bi bi-person"></i>
                  </span>
                  <input
                    id="name"
                    type="text"
                    name="name"
                    class="form-control"
                    placeholder="Tu nombre completo"
                    value="{{ old('name') }}"
                    required
                    autocomplete="name">
                </div>
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group input-group-lg">
                  <span class="input-group-text bg-white">
                    <i class="bi bi-envelope"></i>
                  </span>
                  <input
                    id="email"
                    type="email"
                    name="email"
                    class="form-control"
                    placeholder="tucorreo@ejemplo.com"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email">
                </div>
              </div>

              <div class="mb-3">
                <label for="pwd" class="form-label">Contraseña</label>
                <div class="input-group input-group-lg">
                  <span class="input-group-text bg-white">
                    <i class="bi bi-lock"></i>
                  </span>
                  <input
                    id="pwd"
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Mínimo 8 caracteres"
                    required
                    autocomplete="new-password">
                  <button
                    type="button"
                    class="btn btn-outline-secondary"
                    onclick="
                      (function(btn){
                        var i = document.getElementById('pwd');
                        if(!i) return;
                        if(i.type === 'password'){ 
                          i.type='text'; 
                          btn.innerHTML='<i class=\'bi bi-eye-slash\'></i>'; 
                        } else { 
                          i.type='password'; 
                          btn.innerHTML='<i class=\'bi bi-eye\'></i>'; 
                        }
                        i.focus({preventScroll:true});
                      })(this);
                    ">
                    <i class="bi bi-eye"></i>
                  </button>
                </div>
              </div>

              <div class="mb-3">
                <label for="pwd2" class="form-label">Confirmar contraseña</label>
                <div class="input-group input-group-lg">
                  <span class="input-group-text bg-white">
                    <i class="bi bi-lock-fill"></i>
                  </span>
                  <input
                    id="pwd2"
                    type="password"
                    name="password_confirmation"
                    class="form-control"
                    placeholder="Repite tu contraseña"
                    required
                    autocomplete="new-password">
                  <button
                    type="button"
                    class="btn btn-outline-secondary"
                    onclick="
                      (function(btn){
                        var i = document.getElementById('pwd2');
                        if(!i) return;
                        if(i.type === 'password'){ 
                          i.type='text'; 
                          btn.innerHTML='<i class=\'bi bi-eye-slash\'></i>'; 
                        } else { 
                          i.type='password'; 
                          btn.innerHTML='<i class=\'bi bi-eye\'></i>'; 
                        }
                        i.focus({preventScroll:true});
                      })(this);
                    ">
                    <i class="bi bi-eye"></i>
                  </button>
                </div>
              </div>

              <div class="mb-4">
                <label for="role" class="form-label">Tipo de cuenta</label>
                <select id="role" name="role" class="form-select form-select-lg" required>
                  <option value="">-- Selecciona tu rol --</option>
                  <option value="Empresa" @selected(old('role')==='Empresa')>🏢 Empresa</option>
                  <option value="Candidato" @selected(old('role')==='Candidato')>👤 Candidato</option>
                </select>
                <small class="text-secondary mt-2 d-block">
                  <i class="bi bi-info-circle me-1"></i>
                  Elige el rol que mejor se adapte a tus necesidades
                </small>
              </div>

              <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                <i class="bi bi-check-circle me-2"></i>Crear mi cuenta
              </button>
            </form>

            <div class="separator my-4"><span>o regístrate con</span></div>

            {{-- Google según rol elegido --}}
            <div class="d-grid gap-2">
              <a href="{{ route('auth.redirect.google', ['rol' => 'Empresa']) }}" class="btn btn-outline-dark btn-lg google-btn">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="" width="18" height="18" class="me-2">
                Google como Empresa
              </a>
              <a href="{{ route('auth.redirect.google', ['rol' => 'Candidato']) }}" class="btn btn-outline-dark btn-lg google-btn">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="" width="18" height="18" class="me-2">
                Google como Candidato
              </a>
            </div>

            <p class="mt-4 mb-0 text-center text-secondary">
              ¿Ya tienes cuenta?
              <a href="{{ route('login') }}" class="link-primary text-decoration-none">
                Inicia sesión
              </a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/auth.js') }}"></script>
@endpush