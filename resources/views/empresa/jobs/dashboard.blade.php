@extends('layoutsempresa.app')
@section('title', 'Dashboard empresa')

@section('content')
    <div class="container py-4">
        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-1 fw-bold">
                    <i class="bi bi-speedometer2 me-2" style="color: #1e40af;"></i>
                    Dashboard de Empresa
                </h1>
                <p class="text-muted mb-0">Resumen de vacantes y postulaciones recientes.</p>
            </div>
            <a href="{{ route('empresa.jobs.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Publicar vacante
            </a>
        </div>

        @php
            $avg = $avgScore ?: 0;
            $avgPercent = is_numeric($avg) ? max(0, min(100, (int) round($avg))) : 0;
        @endphp

        {{-- Estadísticas principales --}}
        <div class="row g-3 mb-4">
            <div class="col-12 col-md-3">
                <div class="dashboard-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="dashboard-stat-icon">
                            <i class="bi bi-briefcase-fill"></i>
                        </div>
                        <div class="dashboard-stat">
                            <div class="dashboard-stat-label">Total Vacantes</div>
                            <div class="dashboard-stat-value">{{ $jobsCount }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="dashboard-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="dashboard-stat-icon" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.1)); color: #10b981;">
                            <i class="bi bi-door-open-fill"></i>
                        </div>
                        <div class="dashboard-stat">
                            <div class="dashboard-stat-label">Abiertas</div>
                            <div class="dashboard-stat-value">{{ $openJobs }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="dashboard-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="dashboard-stat-icon" style="background: linear-gradient(135deg, rgba(6, 182, 212, 0.1), rgba(8, 145, 178, 0.1)); color: #06b6d4;">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="dashboard-stat">
                            <div class="dashboard-stat-label">Postulaciones</div>
                            <div class="dashboard-stat-value">{{ $appsCount }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="dashboard-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="dashboard-stat-icon" style="background: linear-gradient(135deg, rgba(168, 85, 247, 0.1), rgba(147, 51, 234, 0.1)); color: #a855f7;">
                            <i class="bi bi-star-fill"></i>
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
        </div>

        {{-- Top vacantes por postulaciones --}}
        <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h2 class="h5 mb-0 fw-semibold">
                        <i class="bi bi-trophy me-2" style="color: #f59e0b;"></i>
                        Top vacantes por postulaciones
                    </h2>
                    <a href="{{ route('empresa.jobs.index') }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-arrow-right"></i> Ver todas
                    </a>
                </div>

                @if ($topJobs->count())
                    <div class="table-responsive">
                        <table class="table align-middle table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>
                                        <i class="bi bi-briefcase me-2"></i>Título
                                    </th>
                                    <th>
                                        <i class="bi bi-toggle-on me-2"></i>Estado
                                    </th>
                                    <th class="text-end">
                                        <i class="bi bi-people me-2"></i>Postulaciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($topJobs as $j)
                                    <tr>
                                        <td>
                                            <a href="{{ route('jobs.show', $j) }}" class="fw-semibold text-decoration-none">
                                                {{ $j->title }}
                                            </a>
                                            @if($j->location)
                                                <div class="small text-muted">
                                                    <i class="bi bi-geo-alt me-1"></i>{{ $j->location }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($j->status === 'open')
                                                <span class="badge bg-success-subtle text-success">
                                                    <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>
                                                    Abierta
                                                </span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary">
                                                    <i class="bi bi-lock me-1"></i>
                                                    Cerrada
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <span class="badge bg-primary-subtle text-primary-emphasis" style="font-size: 1rem;">
                                                {{ $j->applications_count }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-inbox" style="font-size: 3rem; color: #d1d5db;"></i>
                        <p class="mt-3 mb-0">Sin datos por ahora. Publica tu primera vacante para comenzar.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Últimas postulaciones --}}
        <div class="card shadow-sm border-0" style="border-radius: 1rem;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h2 class="h5 mb-0 fw-semibold">
                        <i class="bi bi-clock-history me-2" style="color: #06b6d4;"></i>
                        Últimas postulaciones
                    </h2>
                </div>

                @if ($lastApps->count())
                    <div class="table-responsive">
                        <table class="table align-middle table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>
                                        <i class="bi bi-person me-2"></i>Candidato
                                    </th>
                                    <th>
                                        <i class="bi bi-briefcase me-2"></i>Vacante
                                    </th>
                                    <th>
                                        <i class="bi bi-star me-2"></i>Compatibilidad
                                    </th>
                                    <th>
                                        <i class="bi bi-file-text me-2"></i>CV
                                    </th>
                                    <th>
                                        <i class="bi bi-calendar me-2"></i>Fecha
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lastApps as $a)
                                    @php
                                        $candidate = $a->candidate ?? null;
                                        $candidateUser = $candidate?->user;
                                        $ms = \App\Models\MatchScore::where('job_id', $a->job_id)
                                            ->where('candidate_id', $a->candidate_id)
                                            ->latest('analyzed_at')
                                            ->first();
                                    @endphp

                                    <tr>
                                        <td>
                                            <a href="{{ route('empresa.candidatos.show', $a->candidate_id) }}"
                                               class="fw-semibold text-decoration-none">
                                                {{ $candidateUser->name ?? 'Sin nombre' }}
                                            </a>
                                            @if($candidateUser?->email)
                                                <div class="small text-muted">
                                                    <i class="bi bi-envelope me-1"></i>{{ $candidateUser->email }}
                                                </div>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('jobs.show', $a->job) }}" class="text-decoration-none">
                                                {{ $a->job->title }}
                                            </a>
                                        </td>

                                        <td>
                                            @if (is_numeric($a->score))
                                                <div class="d-flex flex-column" style="max-width: 300px;">
                                                    <span class="badge bg-primary-subtle text-primary align-self-start mb-2">
                                                        <i class="bi bi-star-fill me-1"></i>
                                                        {{ (int) round($a->score) }}%
                                                    </span>

                                                    @if ($ms && filled($ms->comment))
                                                        <span class="small text-muted" title="{{ $ms->comment }}">
                                                            {{ \Illuminate\Support\Str::limit($ms->comment, 80) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted small">Pendiente</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($candidate?->cv_file)
                                                <a href="{{ route('candidato.cv.ver', $candidate->id) }}" 
                                                   target="_blank"
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye me-1"></i>Ver CV
                                                </a>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary">
                                                    <i class="bi bi-file-x"></i> Sin CV
                                                </span>
                                            @endif
                                        </td>

                                        <td class="text-nowrap">
                                            <span class="small text-muted">
                                                <i class="bi bi-clock me-1"></i>
                                                {{ $a->created_at->format('d/m/Y H:i') }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-inbox" style="font-size: 3rem; color: #d1d5db;"></i>
                        <p class="mt-3 mb-0">Sin postulaciones aún. Promociona tus vacantes para recibir candidatos.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection