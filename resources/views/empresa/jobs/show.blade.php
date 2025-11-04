@php
  $layout = 'layouts.app'; // fallback si no hay sesión
  if (auth()->check()) {
    $u = auth()->user();
    if (method_exists($u, 'hasRole')) {
      $layout = $u->hasRole('Candidato') ? 'layoutscandidatos.app'
               : ($u->hasRole('Empresa') ? 'layoutsempresa.app' : 'layouts.app');
    }
  }
@endphp
@extends($layout)

@section('title', $job->title)

@section('content')
<div class="container py-4">
  {{-- Mensajes flash --}}
  @if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif
  @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card border-0 shadow-sm">
        <div class="card-body p-4 p-md-5">

          {{-- Encabezado --}}
          <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
            <div>
              <h1 class="h3 mb-1">{{ $job->title }}</h1>
              <div class="d-flex flex-wrap gap-2 align-items-center text-muted">
                <span class="fw-semibold">{{ optional($job->company)->name ?? 'Empresa' }}</span>
                <span>•</span>
                @if(!empty($job->location))
                  <span class="badge bg-light text-secondary">
                    <i class="bi bi-geo-alt"></i> {{ $job->location }}
                  </span>
                @endif
                @if(!empty($job->status))
                  <span class="badge {{ $job->status === 'open' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                    {{ ucfirst($job->status) }}
                  </span>
                @endif
              </div>
            </div>

            {{-- CTA para candidatos --}}
            @role('Candidato')
              <div class="text-md-end">
                @if(($job->status ?? 'open') === 'open')
                  <form action="{{ route('candidato.aplicar', $job) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                      <i class="bi bi-send"></i> Postular
                    </button>
                  </form>
                @else
                  <button class="btn btn-secondary" disabled>
                    <i class="bi bi-lock"></i> Vacante cerrada
                  </button>
                @endif
              </div>
            @endrole
          </div>

          {{-- Separador visual --}}
          <hr class="my-4">

          {{-- Información principal --}}
          <div class="row g-4">
            <div class="col-12 col-lg-8">

              {{-- Descripción --}}
              @if(!empty($job->description))
                <h2 class="h5">Descripción</h2>
                <p class="text-body">{{ $job->description }}</p>
              @endif

              {{-- Requisitos (si existe el campo) --}}
              @if(!empty($job->requirements))
                <h3 class="h6 mt-4">Requisitos</h3>
                <div class="text-body">
                  {!! nl2br(e($job->requirements)) !!}
                </div>
              @endif

              {{-- Skills (si tienes relación cargada más adelante puedes extender) --}}
              {{-- 
              @if($job->skills?->count())
                <h3 class="h6 mt-4">Habilidades clave</h3>
                <div class="d-flex flex-wrap gap-2">
                  @foreach($job->skills as $skill)
                    <span class="badge bg-primary-subtle text-primary">{{ $skill->name }}</span>
                  @endforeach
                </div>
              @endif 
              --}}
            </div>

            {{-- Aside con datos rápidos --}}
            <div class="col-12 col-lg-4">
              <div class="border rounded-3 p-3 bg-light">
                <h3 class="h6 mb-3">Detalles</h3>

                <dl class="row mb-0 small">
                  @if(!is_null($job->salary_min) || !is_null($job->salary_max))
                    <dt class="col-5 text-muted">Salario</dt>
                    <dd class="col-7">
                      @if(!is_null($job->salary_min))
                        ${{ number_format($job->salary_min, 0, ',', '.') }}
                      @endif
                      –
                      @if(!is_null($job->salary_max))
                        ${{ number_format($job->salary_max, 0, ',', '.') }}
                      @endif
                    </dd>
                  @endif

                  @if(!empty($job->location))
                    <dt class="col-5 text-muted">Ubicación</dt>
                    <dd class="col-7">{{ $job->location }}</dd>
                  @endif

                  @if(!empty($job->status))
                    <dt class="col-5 text-muted">Estado</dt>
                    <dd class="col-7">{{ ucfirst($job->status) }}</dd>
                  @endif

                  @if(!empty($job->created_at))
                    <dt class="col-5 text-muted">Publicada</dt>
                    <dd class="col-7">{{ $job->created_at->format('Y-m-d') }}</dd>
                  @endif
                </dl>
              </div>

              {{-- CTA secundario para candidatos (duplicado por conveniencia en mobile) --}}
              @role('Candidato')
                @if(($job->status ?? 'open') === 'open')
                  <form action="{{ route('candidato.aplicar', $job) }}" method="POST" class="d-grid mt-3 d-lg-none">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                      <i class="bi bi-send"></i> Postular
                    </button>
                  </form>
                @endif
              @endrole
            </div>
          </div>

          {{-- Back link --}}
          <div class="mt-4">
            <a href="{{ route('jobs.public') }}" class="btn btn-outline-secondary">
              <i class="bi bi-arrow-left"></i> Volver al listado
            </a>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
