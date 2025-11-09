@extends('layouts.app')

@section('title', 'Iniciar sesión — Hirewise')

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
                            <i class="bi bi-arrow-return-left me-1"></i>Bienvenido de nuevo
                        </span>
                        <h2 class="fw-bold mb-3">Inicia sesión y continúa donde lo dejaste</h2>
                        <p class="text-secondary mb-4">
                            Accede a tu panel para gestionar vacantes, postulaciones y métricas de compatibilidad.
                        </p>
                        
                        <div class="d-flex gap-3 mt-4">
                            <div class="d-flex align-items-center gap-2">
                                <div class="icon-bubble" style="width: 40px; height: 40px; font-size: 1.125rem;">
                                    <i class="bi bi-shield-check"></i>
                                </div>
                                <div>
                                    <small class="d-block fw-semibold text-gray-900">Seguro</small>
                                    <small class="text-secondary">Datos protegidos</small>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center gap-2">
                                <div class="icon-bubble" style="width: 40px; height: 40px; font-size: 1.125rem;">
                                    <i class="bi bi-lightning-charge"></i>
                                </div>
                                <div>
                                    <small class="d-block fw-semibold text-gray-900">Rápido</small>
                                    <small class="text-secondary">Acceso inmediato</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta de login -->
                <div class="col-lg-5 col-xl-4">
                    <div class="card auth-card shadow-sm border-0">
                        <div class="card-body p-4 p-md-5">
                            <div class="text-center mb-4">
                                <div class="d-inline-flex align-items-center gap-2 mb-2">
                                    <span class="brand-dot"></span>
                                    <h1 class="h4 fw-bold mb-0">Hirewise</h1>
                                </div>
                                <p class="text-secondary mb-0">Inicia sesión en tu cuenta</p>
                            </div>

                            {{-- Errores --}}
                            @if ($errors->any())
                                <div class="alert alert-danger py-2 small mb-4" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            {{-- Formulario --}}
                            <form method="POST" action="{{ route('login.store') }}" novalidate>
                                @csrf

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
                                            placeholder="tucorreo@empresa.com" 
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
                                            placeholder="••••••••" 
                                            required 
                                            autocomplete="current-password">
                                        <button 
                                            type="button" 
                                            class="btn btn-outline-secondary"
                                            aria-label="Mostrar u ocultar contraseña"
                                            onclick="
                                                (function(btn){
                                                    var i = document.getElementById('pwd');
                                                    if(!i) return;
                                                    if(i.type === 'password'){
                                                        i.type = 'text';
                                                        btn.innerHTML = '<i class=\'bi bi-eye-slash\'></i>';
                                                    }else{
                                                        i.type = 'password';
                                                        btn.innerHTML = '<i class=\'bi bi-eye\'></i>';
                                                    }
                                                    i.focus({preventScroll:true});
                                                })(this);
                                            ">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar sesión
                                </button>
                            </form>

                            <div class="separator my-4"><span>o continúa con</span></div>

                            <a href="{{ route('auth.redirect.google') }}"
                                class="btn btn-outline-dark btn-lg w-100 google-btn">
                                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt=""
                                    width="18" height="18" class="me-2">
                                Continuar con Google
                            </a>

                            <p class="mt-4 mb-0 text-center text-secondary">
                                ¿No tienes cuenta?
                                <a href="{{ route('register') }}" class="link-primary text-decoration-none">
                                    Regístrate gratis
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