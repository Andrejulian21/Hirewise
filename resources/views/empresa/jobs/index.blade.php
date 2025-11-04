@extends('layoutsempresa.app')
@section('title', 'Mis vacantes')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4 mb-1">Mis vacantes</h1>
                <p class="text-muted mb-0">Administra las ofertas publicadas por tu empresa.</p>
            </div>
            <a href="{{ route('empresa.jobs.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nueva vacante
            </a>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Título</th>
                                <th>Estado</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jobs as $job)
                                <tr>
                                    <td class="fw-semibold">
                                        <a href="{{ route('jobs.show', $job) }}"
                                            class="text-decoration-none">{{ $job->title }}</a>
                                        <div class="small text-muted">{{ $job->location }}</div>
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $job->status === 'open' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                            {{ ucfirst($job->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('empresa.jobs.edit', $job) }}"
                                            class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-pencil"></i> Editar
                                        </a>
                                        <form method="POST" action="{{ route('empresa.jobs.destroy', $job) }}"
                                            class="d-inline"
                                            onsubmit="return confirm('¡Eliminará definitivamente esta vacante! Esta acción no se puede deshacer. ¿Continuar?');">
                                            @csrf @method('DELETE')
                                            <input type="hidden" name="force" value="1">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-x-octagon"></i> Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        Aún no tienes vacantes publicadas. <a href="{{ route('empresa.jobs.create') }}">Crea
                                            la primera</a>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-3">
            {{ $jobs->links() }}
        </div>
    </div>
@endsection
