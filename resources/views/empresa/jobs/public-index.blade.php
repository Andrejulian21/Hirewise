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

@section('title','Vacantes abiertas')
@section('content')
  <h1 class="h3 mb-3">Vacantes abiertas</h1>

  <div class="list-group">
    @foreach ($jobs as $job)
      <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
         href="{{ route('jobs.show', $job) }}">
        <div>
          <div class="fw-semibold">{{ $job->title }}</div>
          <small class="text-muted">
            {{ $job->company->name ?? 'Empresa' }} — {{ $job->location }}
          </small>
        </div>
        <span class="badge badge-accent">Open</span>
      </a>
    @endforeach
  </div>

  <div class="mt-3">
    {{ $jobs->links() }}
  </div>
@endsection