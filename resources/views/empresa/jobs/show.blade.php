{{-- resources/views/jobs/show.blade.php --}}
@php
  // Layout dinámico según rol (como pediste)
  $layout = 'layouts.app';
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
  {{-- Flash --}}
  @if (session('status')) <div class="alert alert-success">{{ session('status') }}</div> @endif
  @if (session('error'))  <div class="alert alert-danger">{{ session('error') }}</div>  @endif

  <div class="row g-4">
    {{-- Columna principal --}}
    <div class="col-12 col-lg-8">
      <div class="card border-0 shadow-sm">
        <div class="card-body p-4 p-md-5">

          {{-- Encabezado --}}
          <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
            <div>
              <h1 class="h3 mb-1">{{ $job->title }}</h1>
              <div class="d-flex flex-wrap gap-2 align-items-center text-muted">
                <span class="fw-semibold">{{ optional($job->company)->name ?? 'Empresa' }}</span>
                @if(!empty($job->location))
                  <span>•</span>
                  <span class="badge bg-light text-secondary">
                    <i class="bi bi-geo-alt"></i> {{ $job->location }}
                  </span>
                @endif
                @if(!empty($job->status))
                  <span>•</span>
                  <span class="badge {{ $job->status === 'open' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                    {{ ucfirst($job->status) }}
                  </span>
                @endif
              </div>
            </div>

            {{-- CTA candidato --}}
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

          <hr class="my-4">

          {{-- Cuerpo --}}
          @if(!empty($job->description))
            <h2 class="h5">Descripción</h2>
            <p class="text-body">{{ $job->description }}</p>
          @endif

          @if(!empty($job->requirements))
            <h3 class="h6 mt-4">Requisitos</h3>
            <div class="text-body">{!! nl2br(e($job->requirements)) !!}</div>
          @endif

          {{-- Datos rápidos --}}
          <div class="row g-3 mt-3">
            @if(!is_null($job->salary_min) || !is_null($job->salary_max))
              <div class="col-12 col-md-6">
                <div class="p-3 rounded border bg-light">
                  <div class="text-muted small">Rango salarial</div>
                  <div class="fw-semibold">
                    @php
                      $min = $job->salary_min ? number_format($job->salary_min, 0, ',', '.') : null;
                      $max = $job->salary_max ? number_format($job->salary_max, 0, ',', '.') : null;
                    @endphp
                    @if($min && $max)
                      ${{ $min }} - ${{ $max }}
                    @elseif($min)
                      Desde ${{ $min }}
                    @elseif($max)
                      Hasta ${{ $max }}
                    @else
                      —
                    @endif
                  </div>
                </div>
              </div>
            @endif

            @if(!empty($job->created_at))
              <div class="col-12 col-md-6">
                <div class="p-3 rounded border bg-light h-100">
                  <div class="text-muted small">Publicada</div>
                  <div class="fw-semibold">{{ $job->created_at->format('Y-m-d') }}</div>
                </div>
              </div>
            @endif
          </div>

          <div class="mt-4">
            <a href="{{ route('jobs.public') }}" class="btn btn-outline-secondary">
              <i class="bi bi-arrow-left"></i> Volver al listado
            </a>
          </div>
        </div>
      </div>
    </div>

    {{-- Sidebar: Empresa --}}
    <div class="col-12 col-lg-4">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <h3 class="h6 mb-3">Empresa</h3>

          <div class="d-flex align-items-center gap-3 mb-3">
            {{-- Logo o inicial --}}
            <div class="rounded-circle d-flex align-items-center justify-content-center"
                 style="width:56px;height:56px;background:#eef2f6;">
              @if(optional($job->company)->logo)
                <img src="{{ asset('storage/'.$job->company->logo) }}"
                     alt="Logo"
                     class="rounded-circle"
                     style="width:56px;height:56px;object-fit:cover;">
              @else
                <span class="fw-bold text-brand">{{ strtoupper(substr(optional($job->company)->name ?? 'E', 0, 1)) }}</span>
              @endif
            </div>

            <div>
              <div class="fw-semibold mb-1">{{ optional($job->company)->name ?? 'Empresa' }}</div>
              @if(optional($job->company)->website)
                @php
                  $site = optional($job->company)->website;
                  $href = \Illuminate\Support\Str::startsWith($site, ['http://','https://']) ? $site : 'https://'.$site;
                @endphp
                <a href="{{ $href }}" target="_blank" rel="noopener" class="small text-decoration-none">
                  {{ $site }}
                </a>
              @endif
            </div>
          </div>

          @if(optional($job->company)->description)
            <p class="text-muted small mb-3">
              {{ \Illuminate\Support\Str::limit($job->company->description, 220) }}
            </p>
          @endif

          {{-- Más vacantes de esta empresa (usa filtro por query opcional) --}}
          @if($job->company_id)
            <a href="{{ route('jobs.public') }}?company={{ $job->company_id }}"
               class="btn btn-outline-primary w-100 mb-2">
              Más vacantes de esta empresa
            </a>
          @endif

          <a href="{{ route('jobs.public') }}" class="btn btn-light w-100">Explorar vacantes</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
