@extends('layouts.app')

@section('content')
    <section class="auth-wrap">
        <p>
            a
        </p>
        <p>
            a
        </p>
        <p>

        </p>
        <div class="container">
            <div class="row g-4 align-items-center justify-content-center">
                <!-- Lado visual -->
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="auth-hero rounded-4 p-4 p-xl-5 shadow-sm">
                        <span class="badge rounded-pill text-bg-light-subtle accent-badge mb-3">Bienvenido de nuevo</span>
                        <h2 class="fw-bold mb-3">Inicia sesión y continúa donde lo dejaste</h2>
                        <p class="text-secondary mb-0">
                            Accede a tu panel para gestionar vacantes, postulaciones y métricas de compatibilidad.
                        </p>
                    </div>
                </div>

                <!-- Tarjeta de login -->
                <div class="col-lg-5 col-xl-4">
                    <div class="card auth-card shadow-sm border-0">
                        <div class="card-body p-4 p-md-5">
                            <h1 class="h4 fw-bold mb-2">Iniciar sesión</h1>
                            <p class="text-secondary mb-4">Usa tus credenciales o continúa con Google.</p>

                            {{-- Errores --}}
                            @if ($errors->any())
                                <div class="alert alert-danger py-2 small mb-4" role="alert">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            {{-- Formulario --}}
                            <form method="POST" action="{{ route('login.store') }}" novalidate>
                                @csrf

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input id="email" type="email" name="email" class="form-control form-control-lg"
                                        placeholder="tucorreo@empresa.com" value="{{ old('email') }}" required
                                        autocomplete="email">
                                </div>

                                <div class="mb-3 position-relative">
                                    <label for="pwd" class="form-label">Contraseña</label>
                                    <div class="input-group input-group-lg">
                                        <input id="pwd" type="password" name="password" class="form-control"
                                            placeholder="••••••••" required autocomplete="current-password">

                                        <button type="button" class="btn btn-outline-secondary"
                                            aria-label="Mostrar u ocultar contraseña"
                                            onclick="
                                                  (function(btn){
                                                    var i = document.getElementById('pwd');
                                                    if(!i) return;
                                                    if(i.type === 'password'){
                                                      i.type = 'text';
                                                      btn.innerText = 'Ocultar';
                                                    }else{
                                                      i.type = 'password';
                                                      btn.innerText = 'Mostrar';
                                                    }
                                                    i.focus({preventScroll:true});
                                                  })(this);
                                                ">
                                            Mostrar
                                        </button>
                                    </div>
                                </div>



                                <button type="submit" class="btn btn-primary btn-lg w-100">Entrar</button>
                            </form>

                            <div class="separator my-4" ><span> </span></div>

                            <a href="{{ route('auth.redirect.google') }}"
                                class="btn btn-outline-dark btn-lg w-100 google-btn">
                                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt=""
                                    width="18" height="18" class="me-2">
                                Continuar con Google
                            </a>

                            <p class="mt-4 mb-0 text-center text-secondary">
                                ¿No tienes cuenta?
                                <a href="{{ route('register') }}" class="link-primary text-decoration-none">Regístrate</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('js/auth.js') }}"></script>
@endsection
