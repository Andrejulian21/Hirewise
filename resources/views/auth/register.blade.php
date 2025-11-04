@extends('layouts.app')

@section('content')
<section class="auth-wrap">
  <p>
    a
  </p>
  <p>
    a
  </p>

  <div class="container">
    <div class="row g-4 align-items-center justify-content-center">
      <!-- Lado visual -->
      <div class="col-lg-6 d-none d-lg-block">
        <div class="auth-hero rounded-4 p-4 p-xl-5 shadow-sm">
          <span class="badge rounded-pill text-bg-light-subtle accent-badge mb-3">Crea tu cuenta</span>
          <h2 class="fw-bold mb-3">Empieza a contratar o postular en minutos</h2>
          <p class="text-secondary mb-0">
            Elige tu rol (Empresa o Candidato) y comienza a usar Hirewise con una experiencia simple y profesional.
          </p>
        </div>
      </div>

      <!-- Tarjeta de registro -->
      <div class="col-lg-7 col-xl-6">
        <div class="card auth-card shadow-sm border-0">
          <div class="card-body p-4 p-md-5">
            <h1 class="h4 fw-bold mb-2">Crear cuenta</h1>
            <p class="text-secondary mb-4">Regístrate con email o usa Google conservando tu rol.</p>

            {{-- Errores --}}
            @if ($errors->any())
              <div class="alert alert-danger py-2 small mb-4" role="alert">
                <ul class="mb-0 ps-3">
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
                <label for="name" class="form-label">Nombre</label>
                <input
                  id="name"
                  type="text"
                  name="name"
                  class="form-control form-control-lg"
                  placeholder="Tu nombre"
                  value="{{ old('name') }}"
                  required
                  autocomplete="name">
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                  id="email"
                  type="email"
                  name="email"
                  class="form-control form-control-lg"
                  placeholder="tucorreo@ejemplo.com"
                  value="{{ old('email') }}"
                  required
                  autocomplete="email">
              </div>

              <div class="mb-3">
                <label for="pwd" class="form-label">Contraseña</label>
                <div class="input-group input-group-lg">
                  <input
                    id="pwd"
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="••••••••"
                    required
                    autocomplete="new-password">
                  <button
                    type="button"
                    class="btn btn-outline-secondary"
                    onclick="
                      (function(btn){
                        var i = document.getElementById('pwd');
                        if(!i) return;
                        if(i.type === 'password'){ i.type='text'; btn.innerText='Ocultar'; }
                        else { i.type='password'; btn.innerText='Mostrar'; }
                        i.focus({preventScroll:true});
                      })(this);
                    ">
                    Mostrar
                  </button>
                </div>
              </div>

              <div class="mb-3">
                <label for="pwd2" class="form-label">Confirmar Contraseña</label>
                <div class="input-group input-group-lg">
                  <input
                    id="pwd2"
                    type="password"
                    name="password_confirmation"
                    class="form-control"
                    placeholder="••••••••"
                    required
                    autocomplete="new-password">
                  <button
                    type="button"
                    class="btn btn-outline-secondary"
                    onclick="
                      (function(btn){
                        var i = document.getElementById('pwd2');
                        if(!i) return;
                        if(i.type === 'password'){ i.type='text'; btn.innerText='Ocultar'; }
                        else { i.type='password'; btn.innerText='Mostrar'; }
                        i.focus({preventScroll:true});
                      })(this);
                    ">
                    Mostrar
                  </button>
                </div>
              </div>

              <div class="mb-4">
                <label for="role" class="form-label">Rol</label>
                <select id="role" name="role" class="form-select form-select-lg" required>
                  <option value="">-- Selecciona --</option>
                  <option value="Empresa"  @selected(old('role')==='Empresa')>Empresa</option>
                  <option value="Candidato"@selected(old('role')==='Candidato')>Candidato</option>
                </select>
              </div>

              <button type="submit" class="btn btn-primary btn-lg w-100">Registrarme</button>
            </form>

            <div class="separator my-4"><span> </span></div>

            {{-- Google según rol elegido (si no elige, links directos por rol) --}}
            <div class="d-grid gap-2">
              <a href="{{ route('auth.redirect.google', ['rol' => 'Empresa']) }}" class="btn btn-outline-dark btn-lg google-btn">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="" width="18" height="18" class="me-2">
                Continuar con Google (Empresa)
              </a>
              <a href="{{ route('auth.redirect.google', ['rol' => 'Candidato']) }}" class="btn btn-outline-dark btn-lg google-btn">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="" width="18" height="18" class="me-2">
                Continuar con Google (Candidato)
              </a>
            </div>

            <p class="mt-4 mb-0 text-center text-secondary">
              ¿Ya tienes cuenta?
              <a href="{{ route('login') }}" class="link-primary text-decoration-none">Inicia sesión</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
