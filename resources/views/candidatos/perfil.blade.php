@extends('layoutscandidatos.app')

@section('title', 'Mi perfil')

@section('content')
    <div class="container">
        {{-- Alertas --}}
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Header con foto de perfil --}}
        <div class="profile-header">
            <div class="row align-items-center position-relative">
                <div class="col-auto">
                    @if ($candidate->photo_url)
                        <img src="{{ $candidate->photo_url }}" alt="{{ auth()->user()->name }}" class="profile-avatar">
                    @else
                        <div class="profile-avatar-placeholder">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif

                </div>

                <div class="col">
                    <h1 class="profile-name mb-1">{{ auth()->user()->name }}</h1>
                    <p class="profile-role mb-0">
                        <i class="bi bi-person-badge me-2"></i>Candidato
                    </p>

                    <div class="profile-stats">
                        <div class="profile-stat">
                            <span class="profile-stat-value">{{ $candidate->experience_years ?? 0 }}</span>
                            <span class="profile-stat-label">Años de experiencia</span>
                        </div>
                        <div class="profile-stat">
                            <span class="profile-stat-value">
                                @if ($candidate->cv_file)
                                    <i class="bi bi-check-circle-fill"></i>
                                @else
                                    <i class="bi bi-dash-circle"></i>
                                @endif
                            </span>
                            <span class="profile-stat-label">CV {{ $candidate->cv_file ? 'Cargado' : 'Pendiente' }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-auto">
                    <a href="{{ route('candidato.perfil.edit') }}" class="btn btn-light btn-lg">
                        <i class="bi bi-pencil-square me-2"></i>Editar perfil
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Columna principal --}}
            <div class="col-lg-8">
                {{-- Resumen profesional --}}
                @if ($candidate->summary)
                    <div class="info-card">
                        <div class="info-card-header">
                            <div class="info-card-icon">
                                <i class="bi bi-person-lines-fill"></i>
                            </div>
                            <h2 class="info-card-title">Resumen profesional</h2>
                        </div>
                        <div class="info-card-content">
                            <p class="mb-0 text-gray-700" style="line-height: 1.7;">{{ $candidate->summary }}</p>
                        </div>
                    </div>
                @endif

                {{-- Información académica y profesional --}}
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
                            <i class="bi bi-envelope me-2"></i>Email
                        </div>
                        <div class="info-value">
                            {{ auth()->user()->email }}
                        </div>
                    </div>
                </div>

                {{-- Enlaces y documentos --}}
                <div class="info-card">
                    <div class="info-card-header">
                        <div class="info-card-icon">
                            <i class="bi bi-link-45deg"></i>
                        </div>
                        <h2 class="info-card-title">Enlaces y documentos</h2>
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
                            <i class="bi bi-file-earmark-pdf me-2"></i>Currículum vitae
                        </div>
                        <div class="info-value">
                            @if ($candidate->cv_file)
                                <a href="{{ route('candidato.cv.ver', $candidate->id) }}" target="_blank"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i>Ver CV
                                </a>
                            @else
                                <span class="text-muted">No cargado</span>
                                <a href="{{ route('candidato.perfil.edit') }}" class="btn btn-sm btn-primary ms-2">
                                    <i class="bi bi-upload me-1"></i>Subir CV
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Estado del perfil --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 1rem;">
                    <div class="card-body p-4">
                        <h3 class="h6 mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle text-primary"></i>
                            Estado del perfil
                        </h3>

                        @php
                            $completeness = 0;
                            $total = 5;

                            if ($candidate->summary) {
                                $completeness++;
                            }
                            if ($candidate->experience_years) {
                                $completeness++;
                            }
                            if ($candidate->education) {
                                $completeness++;
                            }
                            if ($candidate->linkedin_url) {
                                $completeness++;
                            }
                            if ($candidate->cv_file) {
                                $completeness++;
                            }

                            $percentage = ($completeness / $total) * 100;
                        @endphp

                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small text-muted">Completado</span>
                                <span class="small fw-semibold">{{ round($percentage) }}%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar" role="progressbar"
                                    style="width: {{ $percentage }}%; background: linear-gradient(90deg, #1e40af, #06b6d4);"
                                    aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>

                        <ul class="list-unstyled small mb-0">
                            <li class="mb-2">
                                <i
                                    class="bi {{ $candidate->summary ? 'bi-check-circle-fill text-success' : 'bi-circle text-muted' }} me-2"></i>
                                Resumen profesional
                            </li>
                            <li class="mb-2">
                                <i
                                    class="bi {{ $candidate->experience_years ? 'bi-check-circle-fill text-success' : 'bi-circle text-muted' }} me-2"></i>
                                Años de experiencia
                            </li>
                            <li class="mb-2">
                                <i
                                    class="bi {{ $candidate->education ? 'bi-check-circle-fill text-success' : 'bi-circle text-muted' }} me-2"></i>
                                Educación
                            </li>
                            <li class="mb-2">
                                <i
                                    class="bi {{ $candidate->linkedin_url ? 'bi-check-circle-fill text-success' : 'bi-circle text-muted' }} me-2"></i>
                                Perfil de LinkedIn
                            </li>
                            <li class="mb-2">
                                <i
                                    class="bi {{ $candidate->cv_file ? 'bi-check-circle-fill text-success' : 'bi-circle text-muted' }} me-2"></i>
                                CV cargado
                            </li>
                        </ul>

                        @if ($percentage < 100)
                            <div class="alert alert-info mt-3 mb-0" style="font-size: 0.875rem;">
                                <i class="bi bi-lightbulb me-1"></i>
                                Completa tu perfil para aumentar tus oportunidades.
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Acciones rápidas --}}
                <div class="card border-0 shadow-sm" style="border-radius: 1rem;">
                    <div class="card-body p-4">
                        <h3 class="h6 mb-3">
                            <i class="bi bi-lightning-charge text-warning me-2"></i>
                            Acciones rápidas
                        </h3>

                        <div class="d-grid gap-2">
                            <a href="{{ route('jobs.public') }}" class="btn btn-primary">
                                <i class="bi bi-search me-2"></i>Explorar vacantes
                            </a>
                            <a href="{{ route('candidatos.dashboard') }}" class="btn btn-outline-primary">
                                <i class="bi bi-speedometer2 me-2"></i>Ver panel
                            </a>
                            <a href="{{ route('candidato.perfil.edit') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-pencil-square me-2"></i>Editar perfil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
