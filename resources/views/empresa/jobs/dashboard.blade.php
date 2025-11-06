@extends('layoutsempresa.app')
@section('title', 'Dashboard empresa')

@section('content')
    <div class="container py-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h1 class="h4 mb-1">Dashboard de Empresa</h1>
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

        <div class="row g-3 mb-4">
            <div class="col-12 col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="text-muted small">Vacantes</div>
                        <div class="display-6 fw-semibold">{{ $jobsCount }}</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="text-muted small">Abiertas</div>
                        <div class="display-6 fw-semibold">{{ $openJobs }}</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="text-muted small">Postulaciones</div>
                        <div class="display-6 fw-semibold">{{ $appsCount }}</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="text-muted small">Compatibilidad prom.</div>
                        <div class="d-flex align-items-baseline gap-2">
                            <div class="display-6 fw-semibold">{{ $avgPercent }}%</div>
                        </div>
                        <div class="progress mt-2">
                            <div class="progress-bar" style="width: {{ $avgPercent }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Top vacantes por postulaciones --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h2 class="h5 mb-3">Top vacantes por postulaciones</h2>
                @if ($topJobs->count())
                    <div class="table-responsive">
                        <table class="table align-middle table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Título</th>
                                    <th>Estado</th>
                                    <th class="text-end">Postulaciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($topJobs as $j)
                                    <tr>
                                        <td class="fw-semibold">{{ $j->title }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $j->status === 'open' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                                {{ ucfirst($j->status) }}
                                            </span>
                                        </td>
                                        <td class="text-end">{{ $j->applications_count }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-muted">Sin datos por ahora.</div>
                @endif
            </div>
        </div>

        {{-- Últimas postulaciones --}}
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h2 class="h5 mb-3">Últimas postulaciones</h2>

                @if ($lastApps->count())
                    <div class="table-responsive">
                        <table class="table align-middle table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Candidato</th>
                                    <th>Vacante</th>
                                    <th>Score / Comentario</th>
                                    <th>Perfil</th>
                                    <th>CV</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lastApps as $a)
                                    @php
                                        $candidate = $a->candidate ?? null;
                                        $candidateUser = $candidate?->user;
                                        $cvPath = $candidate?->cv_file;
                                        $cvUrl = $cvPath ? asset('storage/' . $cvPath) : null;

                                        // Traer el comentario más reciente de match_scores
                                        $ms = \App\Models\MatchScore::where('job_id', $a->job_id)
                                            ->where('candidate_id', $a->candidate_id)
                                            ->latest('analyzed_at')
                                            ->first();
                                    @endphp

                                    <tr>
                                        <td>{{ $candidateUser->name ?? '—' }}</td>

                                        <td>{{ $a->job->title }}</td>

                                        <td style="max-width: 380px;">
                                            @if (is_numeric($a->score))
                                                <div class="d-flex flex-column">
                                                    <span
                                                        class="badge bg-primary-subtle text-primary align-self-start mb-1">
                                                        {{ (int) round($a->score) }}%
                                                    </span>

                                                    @if ($ms && filled($ms->comment))
                                                        <span class="small text-muted" title="{{ $ms->comment }}">
                                                            {{ \Illuminate\Support\Str::limit($ms->comment, 120) }}
                                                        </span>
                                                    @else
                                                        <span class="small text-muted">Sin comentario</span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('empresa.candidatos.show', $a->candidate_id) }}"
                                                class="text-decoration-none">
                                                {{ optional($a->candidate->user)->name ?? 'Ver perfil' }}
                                            </a>
                                        </td>

                                        <td>
                                            @if ($candidate?->cv_file)
                                                <a href="{{ route('candidato.cv.ver', $candidate->id) }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary">
                                                    Ver CV
                                                </a>
                                            @else
                                                <span class="text-muted small">No adjunto</span>
                                            @endif
                                        </td>

                                        <td class="text-nowrap text-muted">{{ $a->created_at->format('Y-m-d H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-muted">Sin postulaciones aún.</div>
                @endif
            </div>
        </div>
    </div>
@endsection
