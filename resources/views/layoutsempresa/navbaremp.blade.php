<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('jobs.public') }}">
            <span class="brand-dot" style="width: 8px; height: 8px; background: linear-gradient(135deg, #1e40af, #8b5cf6); border-radius: 50%; display: inline-block;"></span>
            <span class="text-brand">Hirewise</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navEmp"
                aria-controls="navEmp" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navEmp">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                {{-- Dashboard --}}
                <li class="nav-item">
                    <a class="nav-link @if (request()->routeIs('empresa.jobs.dashboard')) active @endif"
                       href="{{ route('empresa.jobs.dashboard') }}">
                        <i class="bi bi-speedometer2 me-1"></i>
                        <span>Panel</span>
                    </a>
                </li>

                {{-- Mis vacantes --}}
                <li class="nav-item">
                    <a class="nav-link @if (request()->routeIs('empresa.jobs.index')) active @endif"
                       href="{{ route('empresa.jobs.index') }}">
                        <i class="bi bi-briefcase me-1"></i>
                        <span>Mis vacantes</span>
                    </a>
                </li>

                {{-- Publicar vacante --}}
                <li class="nav-item">
                    <a class="nav-link @if (request()->routeIs('empresa.jobs.create')) active @endif"
                       href="{{ route('empresa.jobs.create') }}">
                        <i class="bi bi-plus-circle me-1"></i>
                        <span>Publicar</span>
                    </a>
                </li>

                {{-- Mi empresa --}}
                <li class="nav-item">
                    <a class="nav-link @if (request()->routeIs('empresa.company.*')) active @endif"
                       href="{{ route('empresa.company.show') }}">
                        <i class="bi bi-building me-1"></i>
                        <span>Mi empresa</span>
                    </a>
                </li>

                {{-- Explorar vacantes --}}
                <li class="nav-item">
                    <a class="nav-link @if (request()->routeIs('jobs.public')) active @endif"
                       href="{{ route('jobs.public') }}">
                        <i class="bi bi-search me-1"></i>
                        <span>Explorar</span>
                    </a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3">
                <div class="d-none d-md-flex align-items-center gap-2">
                    <div class="d-flex flex-column align-items-end">
                        <span class="fw-semibold small text-gray-900" style="line-height: 1.2;">
                            {{ auth()->user()->name ?? 'Usuario' }}
                        </span>
                        <span class="badge bg-success-subtle text-success" style="font-size: 0.75rem;">
                            <i class="bi bi-building-check me-1"></i>Empresa
                        </span>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                        <i class="bi bi-box-arrow-right"></i>
                        <span class="d-none d-md-inline">Salir</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>