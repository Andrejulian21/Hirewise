@extends('layoutsempresa.app')
@section('title', 'Perfil del candidato')

@section('content')
<div class="container py-4">
  {{-- Botón volver --}}
  <div class="mb-3">
    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">
      <i class="bi bi-arrow-left me-2"></i>Volver
    </a>
  </div>

  {{-- Header del candidato --}}
  <div class="candidate-profile-header">
    <div class="d-flex align-items-center gap-4 flex-wrap">
      <div>
        @if($candidate->photo_url)
          <img src="{{ $candidate->photo_url }}" 
               class="candidate-avatar" 
               alt="{{ optional($candidate->user)->name }}">
        @else
          <div class="candidate-avatar d-flex align-items-center justify-content-center" 
               style="background: linear-gradient(135deg, #06b6d4, #3b82f6);">
            <span style="font-size: 2rem; font-weight: 700; color: white;">
              {{ strtoupper(substr(optional($candidate->user)->name ?? 'C', 0, 1)) }}
            </span>
          </div>
        @endif
      </div>
      
      <div class="flex-grow-1">
        <h1 class="h3 mb-2 fw-bold">{{ optional($candidate->user)->name ?? 'Candidato' }}</h1>
        <div class="d-flex flex-wrap gap-3 align-items-center mb-2">
          <span class="d-flex align-items-center gap-2 text-muted">
            <i class="bi bi-envelope"></i>
            {{ optional($candidate->user)->email ?? 'Sin email' }}
          </span>
          
          @if($candidate->linkedin_url)
            <a href="{{ $candidate->linkedin_url }}" 
               target="_blank" 
               rel="noopener"
               class="d-flex align-items-center gap-2 text-decoration-none">
              <i class="bi bi-linkedin"></i>
              Ver LinkedIn
              <i class="bi bi-box-arrow-up-right"></i>
            </a>
          @endif
        </div>

        {{-- Badges de experiencia y educación --}}
        <div class="d-flex align-items-center gap-2 flex-wrap">
          <span class="badge bg-primary-subtle text-primary-emphasis">
            <i class="bi bi-briefcase me-1"></i>
            {{ $candidate->experience_years ?? 0 }} {{ ($candidate->experience_years ?? 0) == 1 ? 'año' : 'años' }} de experiencia
          </span>
          @if($candidate->education)
            <span class="badge bg-secondary-subtle text-secondary">
              <i class="bi bi-mortarboard me-1"></i>{{ $candidate->education }}
            </span>
          @endif
        </div>
      </div>
      
      <div>
        @if($candidate->cv_file)
          <a class="btn btn-primary btn-lg"
             href="{{ route('candidato.cv.ver', $candidate->id) }}" 
             target="_blank">
            <i class="bi bi-file-earmark-pdf me-2"></i>Ver CV
          </a>
        @else
          <button class="btn btn-light btn-lg" disabled>
            <i class="bi bi-file-earmark-x me-1"></i>Sin CV
          </button>
        @endif
      </div>
    </div>
  </div>

  {{-- Contenido principal --}}
  <div class="row g-4">
    {{-- Columna izquierda: Resumen y experiencia --}}
    <div class="col-lg-8">
      {{-- Resumen profesional --}}
      <div class="info-card">
        <div class="info-card-header">
          <div class="info-card-icon">
            <i class="bi bi-person-lines-fill"></i>
          </div>
          <h2 class="info-card-title">Resumen profesional</h2>
        </div>
        <div class="info-card-content">
          <p class="mb-0 text-gray-700" style="line-height: 1.7; white-space: pre-line;">
            {{ $candidate->summary ?: 'El candidato aún no ha agregado un resumen profesional.' }}
          </p>
        </div>
      </div>

      {{-- Información general --}}
      <div class="info-card">
        <div class="info-card-header">
          <div class="info-card-icon">
            <i class="bi bi-info-circle-fill"></i>
          </div>
          <h2 class="info-card-title">Información general</h2>
        </div>
        
        <div class="info-row">
          <div class="info-label">
            <i class="bi bi-briefcase me-2"></i>Experiencia
          </div>
          <div class="info-value">
            {{ $candidate->experience_years ?? 0 }} 
            {{ ($candidate->experience_years ?? 0) == 1 ? 'año' : 'años' }}
          </div>
        </div>

        <div class="info-row">
          <div class="info-label">
            <i class="bi bi-mortarboard me-2"></i>Educación
          </div>
          <div class="info-value">
            {{ $candidate->education ?: 'No especificado' }}
          </div>
        </div>

        <div class="info-row">
          <div class="info-label">
            <i class="bi bi-linkedin me-2"></i>LinkedIn
          </div>
          <div class="info-value">
            @if ($candidate->linkedin_url)
              <a href="{{ $candidate->linkedin_url }}" target="_blank" rel="noopener">
                {{ $candidate->linkedin_url }}
                <i class="bi bi-box-arrow-up-right ms-1"></i>
              </a>
            @else
              <span class="text-muted">No configurado</span>
            @endif
          </div>
        </div>

        <div class="info-row">
          <div class="info-label">
            <i class="bi bi-envelope me-2"></i>Email
          </div>
          <div class="info-value">
            {{ optional($candidate->user)->email }}
          </div>
        </div>
      </div>
    </div>

    {{-- Columna derecha: Información adicional --}}
    <div class="col-lg-4">
      {{-- Estado del perfil --}}
      <div class="company-card mb-4">
        <h3 class="h6 mb-3 d-flex align-items-center gap-2">
          <i class="bi bi-person-check text-primary"></i>
          Estado del perfil
        </h3>
        
        @php
          $fields = [
              'summary' => $candidate->summary,
              'experience_years' => $candidate->experience_years,
              'education' => $candidate->education,
              'linkedin_url' => $candidate->linkedin_url,
              'cv_file' => $candidate->cv_file,
          ];
          $completeness = collect($fields)->filter()->count();
          $percentage = ($completeness / count($fields)) * 100;
        @endphp
        
        <div class="mb-3">
          <div class="d-flex justify-content-between mb-2">
            <span class="small text-muted">Completado</span>
            <span class="small fw-semibold">{{ round($percentage) }}%</span>
          </div>
          <div class="progress" style="height: 10px;">
            <div class="progress-bar" 
                 style="width: {{ $percentage }}%; background: linear-gradient(90deg, #1e40af, #06b6d4);"
                 role="progressbar" 
                 aria-valuenow="{{ $percentage }}" 
                 aria-valuemin="0" 
                 aria-valuemax="100">
            </div>
          </div>
        </div>

        <ul class="list-unstyled small mb-0">
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
      </div>

      {{-- Acciones rápidas --}}
      <div class="company-card">
        <h3 class="h6 mb-3 d-flex align-items-center gap-2">
          <i class="bi bi-lightning-charge text-warning"></i>
          Acciones rápidas
        </h3>
        
        <div class="d-grid gap-2">
          <a href="{{ route('empresa.jobs.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-briefcase me-2"></i>Ver vacantes activas
          </a>
          <a href="{{ route('empresa.jobs.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-speedometer2 me-2"></i>Ir al panel
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection