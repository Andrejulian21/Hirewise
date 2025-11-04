{{-- Navbar Candidato --}}
<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
  <div class="container">
    <a class="navbar-brand fw-semibold text-brand" href="{{ route('jobs.public') }}">Hirewise</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navCand"
            aria-controls="navCand" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navCand">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link @if(request()->routeIs('jobs.public')) active @endif"
             href="{{ route('jobs.public') }}">Vacantes</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(request()->routeIs('candidato.perfil.*')) active @endif"
             href="{{ route('candidato.perfil.show') }}">Mi perfil</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(request()->routeIs('candidatos.dashboard')) active @endif"
             href="{{ route('candidatos.dashboard') }}">Panel</a>
        </li>
      </ul>

      <div class="d-flex align-items-center gap-3">
        <span class="text-muted small">
          {{ auth()->user()->name ?? '' }} <span class="badge bg-primary-subtle text-primary">Candidato</span>
        </span>

        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="btn btn-sm btn-outline-secondary">Salir</button>
        </form>
      </div>
    </div>
  </div>
</nav>
