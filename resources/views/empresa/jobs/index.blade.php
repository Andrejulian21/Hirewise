@extends('layoutsempresa.app')
@section('title', 'Mis vacantes')

@section('content')
    <div class="container py-4">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h1 class="h3 mb-1 fw-bold">
                    <i class="bi bi-briefcase me-2" style="color: #1e40af;"></i>
                    Mis vacantes
                </h1>
                <p class="text-muted mb-0">Administra las ofertas publicadas por tu empresa.</p>
            </div>
            <a href="{{ route('empresa.jobs.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nueva vacante
            </a>
        </div>

        {{-- Alertas --}}
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Contenido --}}
        @if($jobs->count() > 0)
            {{-- Estadísticas rápidas --}}
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 1rem; background: linear-gradient(135deg, rgba(30, 64, 175, 0.05), rgba(139, 92, 246, 0.05));">
                        <div class="card-body p-3 d-flex align-items-center gap-3">
                            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #1e40af, #3b82f6); color: white; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                                <i class="bi bi-briefcase-fill"></i>
                            </div>
                            <div>
                                <div class="h4 mb-0 fw-bold">{{ $jobs->total() }}</div>
                                <small class="text-muted">Total vacantes</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 1rem; background: linear-gradient(135deg, rgba(16, 185, 129, 0.05), rgba(5, 150, 105, 0.05));">
                        <div class="card-body p-3 d-flex align-items-center gap-3">
                            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #10b981, #059669); color: white; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                                <i class="bi bi-door-open-fill"></i>
                            </div>
                            <div>
                                <div class="h4 mb-0 fw-bold">{{ $jobs->where('status', 'open')->count() }}</div>
                                <small class="text-muted">Abiertas</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 1rem; background: linear-gradient(135deg, rgba(107, 114, 128, 0.05), rgba(75, 85, 99, 0.05));">
                        <div class="card-body p-3 d-flex align-items-center gap-3">
                            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #6b7280, #4b5563); color: white; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                                <i class="bi bi-lock-fill"></i>
                            </div>
                            <div>
                                <div class="h4 mb-0 fw-bold">{{ $jobs->where('status', 'closed')->count() }}</div>
                                <small class="text-muted">Cerradas</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabla de vacantes --}}
            <div class="card border-0 shadow-sm" style="border-radius: 1rem;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>
                                        <i class="bi bi-briefcase me-2"></i>Vacante
                                    </th>
                                    <th>
                                        <i class="bi bi-geo-alt me-2"></i>Ubicación
                                    </th>
                                    <th>
                                        <i class="bi bi-toggle-on me-2"></i>Estado
                                    </th>
                                    <th>
                                        <i class="bi bi-calendar me-2"></i>Fecha
                                    </th>
                                    <th class="text-end">
                                        <i class="bi bi-gear me-2"></i>Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jobs as $job)
                                    <tr>
                                        <td>
                                            <a href="{{ route('jobs.show', $job) }}"
                                               class="fw-semibold text-decoration-none d-flex align-items-center gap-2">
                                                {{ $job->title }}
                                            </a>
                                            @if($job->description)
                                                <div class="small text-muted mt-1" style="max-width: 400px;">
                                                    {{ Str::limit($job->description, 80) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($job->location)
                                                <span class="small">
                                                    <i class="bi bi-geo-alt-fill me-1" style="color: #06b6d4;"></i>
                                                    {{ $job->location }}
                                                </span>
                                            @else
                                                <span class="text-muted small">Sin especificar</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($job->status === 'open')
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
                                        <td>
                                            <span class="small text-muted">
                                                <i class="bi bi-calendar3 me-1"></i>
                                                {{ $job->created_at->format('d/m/Y') }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex gap-1 justify-content-end">
                                                <a href="{{ route('empresa.jobs.edit', $job) }}"
                                                   class="btn btn-sm btn-outline-secondary"
                                                   title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form method="POST" 
                                                      action="{{ route('empresa.jobs.destroy', $job) }}"
                                                      class="d-inline"
                                                      onsubmit="return confirm('⚠️ Esta acción eliminará definitivamente la vacante y todas sus postulaciones. ¿Estás seguro de continuar?');">
                                                    @csrf @method('DELETE')
                                                    <input type="hidden" name="force" value="1">
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-danger"
                                                            title="Eliminar">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Paginación --}}
            <div class="mt-4 d-flex justify-content-center">
                {{ $jobs->links() }}
            </div>

        @else
            {{-- Estado vacío --}}
            <div class="card border-0 shadow-sm" style="border-radius: 1rem;">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-briefcase" style="font-size: 5rem; color: #d1d5db;"></i>
                    </div>
                    <h3 class="h5 mb-2 fw-semibold">Aún no tienes vacantes publicadas</h3>
                    <p class="text-muted mb-4">
                        Comienza a atraer talento creando tu primera vacante. Es rápido y sencillo.
                    </p>
                    <a href="{{ route('empresa.jobs.create') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>Publicar primera vacante
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection