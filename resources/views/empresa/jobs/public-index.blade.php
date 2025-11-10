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

@section('title', 'Vacantes abiertas')

@section('content')
<div class="container jobs-container py-4">
  
  {{-- Header --}}
  <div class="jobs-header">
    <div>
      <h1 class="jobs-title mb-2">
        <i class="bi bi-briefcase me-2" style="color: #1e40af;"></i>
        Vacantes abiertas
      </h1>
      <p class="text-muted mb-0">
        Encuentra la oportunidad perfecta para tu perfil profesional
      </p>
    </div>
    
    @auth
      @role('Candidato')
        <div class="d-flex gap-2">
          <a href="{{ route('candidato.perfil.show') }}" class="btn btn-outline-primary">
            <i class="bi bi-person-circle me-2"></i>Mi perfil
          </a>
        </div>
      @endrole
    @endauth
  </div>

  {{-- Estadísticas rápidas --}}
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="card border-0 shadow-sm h-100" style="border-radius: 1rem; background: linear-gradient(135deg, rgba(30, 64, 175, 0.05), rgba(139, 92, 246, 0.05));">
        <div class="card-body p-3 d-flex align-items-center gap-3">
          <div class="icon-bubble" style="width: 48px; height: 48px; background: linear-gradient(135deg, #1e40af, #3b82f6); color: white; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
            <i class="bi bi-briefcase"></i>
          </div>
          <div>
            <div class="h4 mb-0 fw-bold">{{ $jobs->count() }}</div>
            <small class="text-muted">Vacantes disponibles</small>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-md-4">
      <div class="card border-0 shadow-sm h-100" style="border-radius: 1rem; background: linear-gradient(135deg, rgba(6, 182, 212, 0.05), rgba(59, 130, 246, 0.05));">
        <div class="card-body p-3 d-flex align-items-center gap-3">
          <div class="icon-bubble" style="width: 48px; height: 48px; background: linear-gradient(135deg, #06b6d4, #3b82f6); color: white; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
            <i class="bi bi-building"></i>
          </div>
          <div>
            <div class="h4 mb-0 fw-bold"> {{ \App\Models\Company::count() }}</div>
            <small class="text-muted">Empresas activas</small>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-md-4">
      <div class="card border-0 shadow-sm h-100" style="border-radius: 1rem; background: linear-gradient(135deg, rgba(139, 92, 246, 0.05), rgba(168, 85, 247, 0.05));">
        <div class="card-body p-3 d-flex align-items-center gap-3">
          <div class="icon-bubble" style="width: 48px; height: 48px; background: linear-gradient(135deg, #8b5cf6, #a855f7); color: white; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
            <i class="bi bi-star"></i>
          </div>
          <div>
            <div class="h4 mb-0 fw-bold">IA</div>
            <small class="text-muted">Matching inteligente</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Listado de vacantes --}}
  @if($jobs->count() > 0)
    <div class="mb-3">
      @foreach ($jobs as $job)
        <a class="job-card" href="{{ route('jobs.show', $job) }}">
          <div class="job-card-header">
            <div class="flex-grow-1">
              {{-- Empresa badge --}}
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
              <h3 class="job-card-title">{{ $job->title }}</h3>
              
              {{-- Información básica --}}
              <div class="job-card-company">
                @if($job->location)
                  <span>
                    <i class="bi bi-geo-alt"></i>
                    {{ $job->location }}
                  </span>
                @endif
                
                @if($job->created_at)
                  <span>•</span>
                  <span>
                    <i class="bi bi-clock"></i>
                    Publicada hace {{ $job->created_at->diffForHumans() }}
                  </span>
                @endif
              </div>
            </div>
            
            {{-- Badge de estado --}}
            <div>
              @if(($job->status ?? 'open') === 'open')
                <span class="job-badge job-badge-status">
                  <i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i>
                  Abierta
                </span>
              @else
                <span class="job-badge job-badge-closed">
                  <i class="bi bi-lock"></i>
                  Cerrada
                </span>
              @endif
            </div>
          </div>

          {{-- Descripción resumida --}}
          @if($job->description)
            <p class="text-muted mb-0" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
              {{ $job->description }}
            </p>
          @endif

          {{-- Meta información --}}
          <div class="job-card-meta">
            @if($job->salary_min || $job->salary_max)
              <div class="job-card-meta-item">
                <i class="bi bi-cash-stack"></i>
                <span>
                  @if($job->salary_min && $job->salary_max)
                    ${{ number_format($job->salary_min, 0, ',', '.') }} - ${{ number_format($job->salary_max, 0, ',', '.') }}
                  @elseif($job->salary_min)
                    Desde ${{ number_format($job->salary_min, 0, ',', '.') }}
                  @else
                    Hasta ${{ number_format($job->salary_max, 0, ',', '.') }}
                  @endif
                </span>
              </div>
            @endif
            
            <div class="job-card-meta-item">
              <i class="bi bi-eye"></i>
              <span>Ver detalles</span>
            </div>
          </div>
        </a>
      @endforeach
    </div>

    {{-- Paginación --}}

  @else
    {{-- Estado vacío --}}
    <div class="text-center py-5">
      <div class="mb-4">
        <i class="bi bi-inbox" style="font-size: 4rem; color: #d1d5db;"></i>
      </div>
      <h3 class="h5 mb-2">No hay vacantes disponibles</h3>
      <p class="text-muted mb-4">
        Por el momento no hay ofertas activas. Vuelve pronto para ver nuevas oportunidades.
      </p>
      @auth
        @role('Empresa')
          <a href="{{ route('empresa.jobs.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Publicar primera vacante
          </a>
        @endrole
      @endauth
    </div>
  @endif
</div>
@endsection