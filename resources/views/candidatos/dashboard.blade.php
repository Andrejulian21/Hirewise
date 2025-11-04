@extends('layoutscandidatos.app')

@section('content')
<div class="container py-4">
  {{-- Encabezado --}}
  <div class="d-flex align-items-center justify-content-between mb-3">
    <div>
      <h1 class="h3 mb-1">Dashboard de Candidato</h1>
      <p class="text-muted mb-0">Resumen de tus postulaciones y compatibilidad.</p>
    </div>
    <a href="{{ route('jobs.public') }}" class="btn btn-primary">Ver vacantes</a>
  </div>

  {{-- Métricas --}}
  @php
    $avg = $avgScore ?: 0;
    $avgPercent = is_numeric($avg) ? max(0, min(100, (int) round($avg))) : 0;
  @endphp

  <div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <span class="fw-semibold">Postulaciones</span>
            <span class="badge bg-primary-subtle text-primary">Total</span>
          </div>
          <div class="display-6 fw-semibold mt-2">{{ $totalApps }}</div>
          <div class="text-muted small">Enviadas hasta hoy</div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <span class="fw-semibold">Compatibilidad promedio</span>
            <span class="badge bg-info-subtle text-info">AI Match</span>
          </div>
          <div class="d-flex align-items-baseline gap-2 mt-2">
            <div class="display-6 fw-semibold">{{ $avgPercent }}%</div>
          </div>
          <div class="progress mt-2" role="progressbar" aria-valuenow="{{ $avgPercent }}" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar" style="width: {{ $avgPercent }}%"></div>
          </div>
          <div class="text-muted small mt-1">Basado en tus últimas postulaciones</div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <span class="fw-semibold">Pendientes</span>
            <span class="badge bg-warning-subtle text-warning">En proceso</span>
          </div>
          <div class="display-6 fw-semibold mt-2">{{ $totalApps }}</div>
          <div class="text-muted small">Vacantes en evaluación</div>
        </div>
      </div>
    </div>
  </div>

  {{-- Últimas postulaciones --}}
  <div class="card shadow-sm border-0">
    <div class="card-body">
      <div class="d-flex align-items-center justify-content-between mb-2">
        <h2 class="h5 mb-0">Últimas postulaciones</h2>
        <a href="{{ route('jobs.public') }}" class="btn btn-outline-secondary btn-sm">Buscar más vacantes</a>
      </div>

      @if($lastApps->count())
        <div class="table-responsive">
          <table class="table align-middle table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th>Vacante</th>
                <th>Empresa</th>
                <th>Compatibilidad</th>
                <th class="text-nowrap">Fecha</th>
              </tr>
            </thead>
            <tbody>
              @foreach($lastApps as $a)
                <tr>
                  <td>
                    <div class="fw-semibold">{{ optional($a->job)->title }}</div>
                    <div class="text-muted small">{{ optional($a->job)->location }}</div>
                  </td>
                  <td>{{ optional(optional($a->job)->company)->name }}</td>
                  <td>
                    @php $s = $a->score ?? null; @endphp
                    @if(is_numeric($s))
                      <span class="badge bg-primary-subtle text-primary">{{ (int) round($s) }}%</span>
                    @else
                      <span class="text-muted">—</span>
                    @endif
                  </td>
                  <td class="text-muted text-nowrap">{{ $a->created_at->format('Y-m-d H:i') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <div class="text-center text-muted py-4">
          Aún no tienes postulaciones. <a href="{{ route('jobs.public') }}">Explora vacantes</a> y empieza a aplicar.
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
