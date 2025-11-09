@extends('layoutscandidatos.app')
@section('title', 'Dashboard de Candidato')

@section('content')
<div class="container py-4">

  {{-- Header --}}
  <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
      <h1 class="h3 fw-bold mb-1">
        <i class="bi bi-speedometer2 me-2" style="color: #1e40af;"></i>
        Dashboard de Candidato
      </h1>
      <p class="text-muted mb-0">Resumen de tus postulaciones, compatibilidad y progreso.</p>
    </div>
    <a href="{{ route('jobs.public') }}" class="btn btn-primary">
      <i class="bi bi-search"></i> Explorar vacantes
    </a>
  </div>

  @php
      $avg = $avgScore ?: 0;
      $avgPercent = is_numeric($avg) ? max(0, min(100, (int) round($avg))) : 0;
  @endphp

  {{-- Estadísticas principales --}}
  <div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
      <div class="dashboard-card">
        <div class="d-flex align-items-center gap-3">
          <div class="dashboard-stat-icon">
            <i class="bi bi-send-fill"></i>
          </div>
          <div class="dashboard-stat">
            <div class="dashboard-stat-label">Postulaciones</div>
            <div class="dashboard-stat-value">{{ $totalApps }}</div>
          </div>
        </div>
        <div class="small text-muted mt-3">
          <i class="bi bi-info-circle me-1"></i>
          Enviadas hasta hoy
        </div>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="dashboard-card">
        <div class="d-flex align-items-center gap-3">
          <div class="dashboard-stat-icon" style="background: linear-gradient(135deg, rgba(6, 182, 212, 0.1), rgba(8, 145, 178, 0.1)); color: #06b6d4;">
            <i class="bi bi-stars"></i>
          </div>
          <div class="dashboard-stat">
            <div class="dashboard-stat-label">Compatibilidad</div>
            <div class="dashboard-stat-value">{{ $avgPercent }}%</div>
          </div>
        </div>
        <div class="progress mt-3">
          <div class="progress-bar" style="width: {{ $avgPercent }}%"></div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="dashboard-card">
        <div class="d-flex align-items-center gap-3">
          <div class="dashboard-stat-icon" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(217, 119, 6, 0.1)); color: #f59e0b;">
            <i class="bi bi-hourglass-split"></i>
          </div>
          <div class="dashboard-stat">
            <div class="dashboard-stat-label">En proceso</div>
            <div class="dashboard-stat-value">{{ $pendingApps ?? 0 }}</div>
          </div>
        </div>
        <div class="small text-muted mt-3">
          <i class="bi bi-info-circle me-1"></i>
          Vacantes en evaluación
        </div>
      </div>
    </div>
  </div>

  {{-- Gráfico de estado de postulaciones --}}
  @if($totalApps > 0)
  <div class="row g-4 mb-4">
    <div class="col-lg-8">
      {{-- Últimas postulaciones --}}
      <div class="card shadow-sm border-0" style="border-radius: 1rem;">
        <div class="card-body p-4">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="h5 mb-0 fw-semibold">
              <i class="bi bi-clock-history me-2" style="color: #06b6d4;"></i>
              Últimas postulaciones
            </h2>
          </div>

          @if($lastApps->count())
          <div class="table-responsive">
            <table class="table align-middle table-hover mb-0">
              <thead class="table-light">
                <tr>
                  <th>
                    <i class="bi bi-briefcase me-2"></i>Vacante
                  </th>
                  <th>
                    <i class="bi bi-building me-2"></i>Empresa
                  </th>
                  <th>
                    <i class="bi bi-star me-2"></i>Match
                  </th>
                  <th>
                    <i class="bi bi-calendar me-2"></i>Fecha
                  </th>
                </tr>
              </thead>
              <tbody>
                @foreach($lastApps as $a)
                  @php
                      $latestMatch = \App\Models\MatchScore::where('job_id',$a->job_id)
                          ->where('candidate_id',$a->candidate_id)
                          ->latest('analyzed_at')
                          ->first();
                  @endphp
                  <tr>
                    <td>
                      <a href="{{ route('jobs.show', $a->job) }}" class="fw-semibold text-decoration-none">
                        {{ $a->job->title }}
                      </a>
                      @if($a->job->location)
                        <div class="small text-muted">
                          <i class="bi bi-geo-alt me-1"></i>{{ $a->job->location }}
                        </div>
                      @endif
                    </td>
                    <td>
                      <span class="small">
                        {{ optional($a->job->company)->name ?? 'Empresa' }}
                      </span>
                    </td>
                    <td>
                      @if(is_numeric($a->score))
                        <div class="d-flex flex-column" style="max-width: 250px;">
                          <span class="badge bg-primary-subtle text-primary align-self-start mb-2">
                            <i class="bi bi-star-fill me-1"></i>
                            {{ (int) round($a->score) }}%
                          </span>
                          @if($latestMatch?->comment)
                            <span class="small text-muted" title="{{ $latestMatch->comment }}">
                              {{ Str::limit($latestMatch->comment, 60) }}
                            </span>
                          @endif
                        </div>
                      @else
                        <span class="badge bg-secondary-subtle text-secondary">
                          <i class="bi bi-clock-history me-1"></i>Pendiente
                        </span>
                      @endif
                    </td>
                    <td class="text-nowrap">
                      <span class="small text-muted">
                        <i class="bi bi-clock me-1"></i>
                        {{ $a->created_at->format('d/m/Y') }}
                      </span>
                      <div class="small text-muted">
                        {{ $a->created_at->format('H:i') }}
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @else
          <div class="text-center py-4 text-muted">
            <i class="bi bi-inbox" style="font-size: 3rem; color: #d1d5db;"></i>
            <p class="mt-3 mb-0">Sin postulaciones recientes</p>
          </div>
          @endif
        </div>
      </div>
    </div>

    {{-- Sidebar: Mejora tu perfil --}}
    <div class="col-lg-4">
      {{-- Estado del perfil --}}
      <div class="card border-0 shadow-sm mb-4" style="border-radius: 1rem;">
        <div class="card-body p-4">
          <h3 class="h6 mb-3 fw-semibold">
            <i class="bi bi-person-check me-2" style="color: #10b981;"></i>
            Estado del perfil
          </h3>
          
          @php
            $candidate = auth()->user()->candidate;
            $completeness = 0;
            $total = 5;
            
            if ($candidate->summary) $completeness++;
            if ($candidate->experience_years) $completeness++;
            if ($candidate->education) $completeness++;
            if ($candidate->linkedin_url) $completeness++;
            if ($candidate->cv_file) $completeness++;
            
            $percentage = ($completeness / $total) * 100;
          @endphp
          
          <div class="mb-3">
            <div class="d-flex justify-content-between mb-2">
              <span class="small text-muted">Completado</span>
              <span class="small fw-semibold">{{ round($percentage) }}%</span>
            </div>
            <div class="progress" style="height: 8px;">
              <div class="progress-bar" 
                   role="progressbar" 
                   style="width: {{ $percentage }}%; background: linear-gradient(90deg, #1e40af, #06b6d4);"
                   aria-valuenow="{{ $percentage }}" 
                   aria-valuemin="0" 
                   aria-valuemax="100">
              </div>
            </div>
          </div>

          <ul class="list-unstyled small mb-3">
            <li class="mb-2">
              <i class="bi {{ $candidate->summary ? 'bi-check-circle-fill text-success' : 'bi-circle text-muted' }} me-2"></i>
              Resumen profesional
            </li>
            <li class="mb-2">
              <i class="bi {{ $candidate->experience_years ? 'bi-check-circle-fill text-success' : 'bi-circle text-muted' }} me-2"></i>
              Experiencia
            </li>
            <li class="mb-2">
              <i class="bi {{ $candidate->education ? 'bi-check-circle-fill text-success' : 'bi-circle text-muted' }} me-2"></i>
              Educación
            </li>
            <li class="mb-2">
              <i class="bi {{ $candidate->linkedin_url ? 'bi-check-circle-fill text-success' : 'bi-circle text-muted' }} me-2"></i>
              LinkedIn
            </li>
            <li class="mb-2">
              <i class="bi {{ $candidate->cv_file ? 'bi-check-circle-fill text-success' : 'bi-circle text-muted' }} me-2"></i>
              CV cargado
            </li>
          </ul>

          @if($percentage < 100)
            <a href="{{ route('candidato.perfil.edit') }}" class="btn btn-outline-primary w-100">
              <i class="bi bi-pencil-square me-2"></i>Completar perfil
            </a>
          @else
            <div class="alert alert-success mb-0" style="font-size: 0.875rem;">
              <i class="bi bi-check-circle-fill me-1"></i>
              ¡Perfil completo!
            </div>
          @endif
        </div>
      </div>

      {{-- Acciones rápidas --}}
      <div class="card border-0 shadow-sm" style="border-radius: 1rem;">
        <div class="card-body p-4">
          <h3 class="h6 mb-3 fw-semibold">
            <i class="bi bi-lightning-charge me-2" style="color: #f59e0b;"></i>
            Acciones rápidas
          </h3>
          
          <div class="d-grid gap-2">
            <a href="{{ route('jobs.public') }}" class="btn btn-primary">
              <i class="bi bi-search me-2"></i>Buscar vacantes
            </a>
            <a href="{{ route('candidato.perfil.show') }}" class="btn btn-outline-primary">
              <i class="bi bi-person-circle me-2"></i>Ver mi perfil
            </a>
            <a href="{{ route('candidato.perfil.edit') }}" class="btn btn-outline-secondary">
              <i class="bi bi-pencil-square me-2"></i>Editar perfil
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  @else
  {{-- Estado vacío cuando no hay postulaciones --}}
  <div class="card border-0 shadow-sm" style="border-radius: 1rem;">
    <div class="card-body text-center py-5">
      <div class="mb-4">
        <i class="bi bi-inbox" style="font-size: 5rem; color: #d1d5db;"></i>
      </div>
      <h3 class="h5 mb-2 fw-semibold">Aún no tienes postulaciones</h3>
      <p class="text-muted mb-4">
        Comienza tu búsqueda explorando las vacantes disponibles. Tu próxima oportunidad te espera.
      </p>
      <a href="{{ route('jobs.public') }}" class="btn btn-primary btn-lg">
        <i class="bi bi-search me-2"></i>Explorar vacantes
      </a>
    </div>
  </div>
  @endif

  {{-- Consejos y mejoras --}}
  @if($avgPercent < 70 && $totalApps > 0)
  <div class="row mt-4">
    <div class="col-12">
      <div class="alert alert-info" style="border-left: 4px solid #06b6d4; border-radius: 1rem;">
        <div class="d-flex align-items-start gap-3">
          <i class="bi bi-lightbulb-fill" style="font-size: 2rem; color: #06b6d4;"></i>
          <div>
            <h4 class="alert-heading h6 fw-semibold mb-2">
              Mejora tu compatibilidad
            </h4>
            <p class="mb-2">
              Tu compatibilidad promedio es del {{ $avgPercent }}%. Aquí hay algunos consejos para mejorarla:
            </p>
            <ul class="mb-0 small">
              <li>Actualiza tu CV con palabras clave relevantes a las vacantes que buscas</li>
              <li>Completa tu perfil con toda tu experiencia y habilidades</li>
              <li>Revisa los requisitos de las vacantes antes de postular</li>
              <li>Mantén tu información de contacto actualizada</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif

</div>
@endsection