  <nav class="navbar navbar-expand-lg bg-white border-bottom fixed-top">
    <div class="container">
      <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="/">
        <span class="brand-dot"></span> Hirewise
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
          <li class="nav-item"><a class="nav-link" href="#caracteristicas">Características</a></li>
          <li class="nav-item"><a class="nav-link" href="#como-funciona">Cómo funciona</a></li>
          <li class="nav-item"><a class="nav-link" href="#precios">Planes</a></li>
          <li class="nav-item">
            <a class="btn btn-outline-primary px-3 me-lg-2" href="{{ route('login') }}">Iniciar sesión</a>
          </li>
          <p></p>
          <li class="nav-item">
            <a class="btn btn-primary px-3" href="{{ route('register') }}">Crear cuenta</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>