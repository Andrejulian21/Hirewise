@php
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
  {{-- Flash messages --}}
  @if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle-fill me-2"></i>
      {{ session('status') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  
  @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-triangle-fill me-2"></i>
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  {{-- Botón volver --}}
  <div class="mb-3">
    <a href="{{ route('jobs.public') }}" class="btn btn-outline-secondary btn-sm">
      <i class="bi bi-arrow-left me-2"></i>Volver al listado
    </a>
  </div>

  <div class="row g-4">
    {{-- Columna principal --}}
    <div class="col-12 col-lg-8">
      {{-- Header de la vacante --}}
      <div class="job-detail-header">
        {{-- Badge de empresa --}}
        @if($job->company)
          <div class="job-company-badge">
            @if($job->company->logo)
              <img src="{{ asset('storage/'.$job->company->logo) }}" 
                   alt="{{ $job->company->name }}"
                   class="job-company-logo">
            @endif
            <span>{{ $job->company->name }}</span>
          </div>
        @endif

        {{-- Título --}}
        <h1 class="job-detail-title">{{ $job->title }}</h1>

        {{-- Badges de información --}}
        <div class="job-detail-badges">
          @if($job->location)
            <span class="job-badge job-badge-location">
              <i class="bi bi-geo-alt"></i>
              {{ $job->location }}
            </span>
          @endif
          
          @if($job->status ?? 'open')
            @if($job->status === 'open')
              <span class="job-badge job-badge-status">
                <i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i>
                Vacante abierta
              </span>
            @else
              <span class="job-badge job-badge-closed">
                <i class="bi bi-lock"></i>
                Vacante cerrada
              </span>
            @endif
          @endif

          @if($job->created_at)
            <span class="job-badge" style="background: rgba(107, 114, 128, 0.1); color: #4b5563;">
              <i class="bi bi-clock-history"></i>
              Publicada {{ $job->created_at->diffForHumans() }}
            </span>
          @endif
        </div>

        {{-- CTA para candidatos --}}
        @auth
          @role('Candidato')
            <div class="mt-4 pt-4 border-top">
              @if(($job->status ?? 'open') === 'open')
                <form action="{{ route('candidato.aplicar', $job) }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-send-fill me-2"></i>Postular a esta vacante
                  </button>
                </form>
                <p class="text-muted small mt-2 mb-0">
                  <i class="bi bi-info-circle me-1"></i>
                  Tu perfil será evaluado automáticamente por nuestra IA
                </p>
              @else
                <button class="btn btn-secondary btn-lg" disabled>
                  <i class="bi bi-lock-fill me-2"></i>Vacante cerrada
                </button>
                <p class="text-muted small mt-2 mb-0">
                  Esta vacante ya no está aceptando postulaciones
                </p>
              @endif
            </div>
          @endrole
        @else
          <div class="mt-4 pt-4 border-top">
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
              <i class="bi bi-person-plus me-2"></i>Regístrate para postular
            </a>
            <p class="text-muted small mt-2 mb-0">
              <i class="bi bi-info-circle me-1"></i>
              Crea una cuenta gratuita para aplicar a esta vacante
            </p>
          </div>
        @endauth
      </div>

      {{-- Descripción --}}
      @if($job->description)
        <div class="job-section">
          <h2 class="job-section-title">
            <i class="bi bi-file-text"></i>
            Descripción del puesto
          </h2>
          <div class="job-section-content">
            {{ $job->description }}
          </div>
        </div>
      @endif

      {{-- Requisitos --}}
      @if($job->requirements)
        <div class="job-section">
          <h2 class="job-section-title">
            <i class="bi bi-list-check"></i>
            Requisitos
          </h2>
          <div class="job-section-content">
            {!! nl2br(e($job->requirements)) !!}
          </div>
        </div>
      @endif

      {{-- Información adicional --}}
      <div class="job-section">
        <h2 class="job-section-title">
          <i class="bi bi-info-circle"></i>
          Información adicional
        </h2>
        
        <div class="job-info-grid">
          @if($job->salary_min || $job->salary_max)
            <div class="job-info-item">
              <div class="job-info-label">
                <i class="bi bi-cash-stack"></i>
                Rango salarial
              </div>
              <div class="job-info-value">
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
                  No especificado
                @endif
              </div>
            </div>
          @endif

          @if($job->created_at)
            <div class="job-info-item">
              <div class="job-info-label">
                <i class="bi bi-calendar-plus"></i>
                Fecha de publicación
              </div>
              <div class="job-info-value">
                {{ $job->created_at->format('d/m/Y') }}
              </div>
            </div>
          @endif

          @if($job->location)
            <div class="job-info-item">
              <div class="job-info-label">
                <i class="bi bi-geo-alt"></i>
                Ubicación
              </div>
              <div class="job-info-value">
                {{ $job->location }}
              </div>
            </div>
          @endif

          <div class="job-info-item">
            <div class="job-info-label">
              <i class="bi bi-lightning-charge"></i>
              Matching IA
            </div>
            <div class="job-info-value">
              Disponible
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Sidebar: Información de la empresa --}}
    <div class="col-12 col-lg-4">
      <div class="company-sidebar">
        <div class="company-card">
          <h3 class="h6 mb-3">
            <i class="bi bi-building me-2"></i>Acerca de la empresa
          </h3>

          <div class="company-header">
            {{-- Logo o inicial --}}
            <div class="company-logo-container">
              @if(optional($job->company)->logo)
                <img src="{{ asset('storage/'.$job->company->logo) }}"
                     alt="Logo {{ $job->company->name }}"
                     class="company-logo">
              @else
                <span class="company-logo-initial">
                  {{ strtoupper(substr(optional($job->company)->name ?? 'E', 0, 1)) }}
                </span>
              @endif
            </div>

            <div class="flex-grow-1">
              <div class="company-name">
                {{ optional($job->company)->name ?? 'Empresa' }}
              </div>
              @if(optional($job->company)->website)
                @php
                  $site = optional($job->company)->website;
                  $href = \Illuminate\Support\Str::startsWith($site, ['http://','https://']) ? $site : 'https://'.$site;
                @endphp
                <a href="{{ $href }}" target="_blank" rel="noopener" class="company-website">
                  {{ parse_url($href, PHP_URL_HOST) ?: $site }}
                  <i class="bi bi-box-arrow-up-right"></i>
                </a>
              @endif
            </div>
          </div>

          @if(optional($job->company)->description)
            <p class="company-description">
              {{ \Illuminate\Support\Str::limit($job->company->description, 200) }}
            </p>
          @endif

          {{-- Acciones --}}
          <div class="d-grid gap-2">

            <a href="{{ route('jobs.public') }}" class="btn btn-light w-100">
              <i class="bi bi-search me-2"></i>
              Explorar todas las vacantes
            </a>
          </div>

          {{-- Estadísticas de la empresa (opcional) --}}
          @if($job->company)
            <div class="mt-4 pt-3 border-top">
              <div class="small text-muted mb-2">
                <i class="bi bi-graph-up me-1"></i>
                Actividad reciente
              </div>
              <div class="d-flex justify-content-between text-center">
                <div>
                  <div class="fw-bold">{{ $job->company->jobs()->where('status', 'open')->count() }}</div>
                  <small class="text-muted">Vacantes activas</small>
                </div>
                <div class="vr"></div>
                <div>
                  <div class="fw-bold">{{ $job->company->jobs()->count() }}</div>
                  <small class="text-muted">Total publicadas</small>
                </div>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection