  <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
      <div class="container">
          <a class="navbar-brand fw-semibold text-brand" href="{{ route('jobs.public') }}">Hirewise</a>

          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navEmp"
              aria-controls="navEmp" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navEmp">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  {{-- Listado público (para revisar mercado) --}}
                  <li class="nav-item">
                      <a class="nav-link @if (request()->routeIs('jobs.public')) active @endif"
                          href="{{ route('jobs.public') }}">Vacantes</a>
                  </li>

                  {{-- CRUD de vacantes de la empresa --}}
                  <li class="nav-item">
                      <a class="nav-link @if (request()->routeIs('empresa.jobs.index')) active @endif"
                          href="{{ route('empresa.jobs.index') }}">Mis vacantes</a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link @if (request()->routeIs('empresa.jobs.create')) active @endif"
                          href="{{ route('empresa.jobs.create') }}">Publicar vacante</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link @if (request()->routeIs('empresa.company.*')) active @endif"
                          href="{{ route('empresa.company.show') }}">Mi empresa</a>
                  </li>

                  {{-- Si tienes dashboard de empresa --}}
                  <li class="nav-item">
                      <a class="nav-link @if (request()->routeIs('empresa.jobs.dashboard')) active @endif"
                          href="{{ route('empresa.jobs.dashboard') }}">Panel</a>
                  </li>
              </ul>

              <div class="d-flex align-items-center gap-3">
                  <span class="text-muted small">
                      {{ auth()->user()->name ?? '' }} <span class="badge bg-success-subtle text-success">Empresa</span>
                  </span>

                  <form method="POST" action="{{ route('logout') }}">
                      @csrf
                      <button class="btn btn-sm btn-outline-secondary">Salir</button>
                  </form>
              </div>
          </div>
      </div>
  </nav>
