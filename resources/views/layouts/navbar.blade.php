@php
  $home   = url('/');
  $onHome = request()->is('/'); // ajusta si tu ruta de welcome tiene nombre distinto
  $hrefCaracteristicas = $onHome ? '#caracteristicas' : "{$home}#caracteristicas";
  $hrefComoFunciona    = $onHome ? '#como-funciona'  : "{$home}#como-funciona";
  $hrefPlanes          = $onHome ? '#precios'        : "{$home}#precios";
@endphp

<nav class="navbar navbar-expand-lg bg-white border-bottom fixed-top">
  <div class="container">
    <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ $home }}">
      <span class="brand-dot"></span> Hirewise
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
        <li class="nav-item"><a class="nav-link" href="{{ $hrefCaracteristicas }}">Características</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ $hrefComoFunciona }}">Cómo funciona</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ $hrefPlanes }}">Planes</a></li>

        <li class="nav-item">
          <a class="btn btn-outline-primary px-3 me-lg-2" href="{{ route('login') }}">Iniciar sesión</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-primary px-3" href="{{ route('register') }}">Crear cuenta</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

{{-- Scroll suave solo en la portada (opcional, puro CSS) --}}
@if ($onHome)
<style>
  html { scroll-behavior: smooth; }
</style>
@endif