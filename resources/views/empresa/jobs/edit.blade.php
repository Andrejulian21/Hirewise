@extends('layoutsempresa.app')
@section('title', 'Editar vacante')

@section('content')
<div class="container py-4">
  {{-- Header --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-1 fw-bold">
        <i class="bi bi-pencil-square me-2" style="color: #1e40af;"></i>
        Editar vacante
      </h1>
      <p class="text-muted mb-0">Modifica la información y actualiza tu oferta publicada</p>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('empresa.jobs.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Volver
      </a>
      <form method="POST" action="{{ route('empresa.jobs.destroy', $job) }}"
            onsubmit="return confirm('¿Estás seguro de eliminar esta vacante?');">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-outline-danger">
          <i class="bi bi-trash"></i> Eliminar
        </button>
      </form>
    </div>
  </div>

  @if (session('status'))
    <div class="alert alert-success d-flex align-items-center gap-2">
      <i class="bi bi-check-circle-fill"></i>
      {{ session('status') }}
    </div>
  @endif

  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card border-0 shadow-sm" style="border-radius: 1rem;">
        <div class="card-body p-4 p-md-5">
          <form method="POST" action="{{ route('empresa.jobs.update', $job) }}" novalidate>
            @csrf
            @method('PUT')

            {{-- Información básica --}}
            <div class="mb-5">
              <h2 class="h5 mb-3 fw-semibold">
                <i class="bi bi-info-circle me-2" style="color: #1e40af;"></i>
                Información básica
              </h2>

              <div class="mb-4">
                <label class="form-label fw-semibold">
                  <i class="bi bi-briefcase me-2"></i>Título de la vacante *
                </label>
                <input class="form-control @error('title') is-invalid @enderror"
                       name="title"
                       value="{{ old('title', $job->title) }}"
                       placeholder="Ej: Desarrollador Backend Senior"
                       required>
                @error('title')
                  <div class="invalid-feedback">
                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                  </div>
                @enderror
              </div>

              <div class="mb-4">
                <label class="form-label fw-semibold">
                  <i class="bi bi-geo-alt me-2"></i>Ubicación
                </label>
                <input class="form-control"
                       name="location"
                       value="{{ old('location', $job->location) }}"
                       placeholder="Ciudad, País o 'Remoto'">
                <small class="form-text text-muted">
                  Indica si el trabajo es presencial, híbrido o remoto
                </small>
              </div>
            </div>

            {{-- Descripción --}}
            <div class="mb-5">
              <h2 class="h5 mb-3 fw-semibold">
                <i class="bi bi-file-text me-2" style="color: #1e40af;"></i>
                Descripción del puesto
              </h2>

              <div class="mb-4">
                <label class="form-label fw-semibold">
                  <i class="bi bi-card-text me-2"></i>Descripción general *
                </label>
                <textarea class="form-control @error('description') is-invalid @enderror"
                          name="description"
                          rows="6"
                          placeholder="Describe el rol, responsabilidades, tecnologías y beneficios...">{{ old('description', $job->description) }}</textarea>
                @error('description')
                  <div class="invalid-feedback">
                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                  </div>
                @enderror
              </div>

              <div class="mb-4">
                <label class="form-label fw-semibold">
                  <i class="bi bi-check2-square me-2"></i>Requisitos
                </label>
                <textarea class="form-control"
                          name="requirements"
                          rows="5"
                          placeholder="• Experiencia en Laravel&#10;• Conocimiento en bases de datos SQL&#10;• Inglés intermedio...">{{ old('requirements', $job->requirements) }}</textarea>
              </div>
            </div>

            {{-- Compensación y detalles --}}
            <div class="mb-5">
              <h2 class="h5 mb-3 fw-semibold">
                <i class="bi bi-cash-stack me-2" style="color: #1e40af;"></i>
                Compensación y detalles
              </h2>

              <div class="row g-3 mb-4">
                <div class="col-md-6">
                  <label class="form-label fw-semibold">
                    <i class="bi bi-currency-dollar me-2"></i>Salario mínimo
                  </label>
                  <input class="form-control"
                         type="number"
                         step="0.01"
                         name="salary_min"
                         value="{{ old('salary_min', $job->salary_min) }}"
                         placeholder="0.00">
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-semibold">
                    <i class="bi bi-currency-dollar me-2"></i>Salario máximo
                  </label>
                  <input class="form-control"
                         type="number"
                         step="0.01"
                         name="salary_max"
                         value="{{ old('salary_max', $job->salary_max) }}"
                         placeholder="0.00">
                </div>
              </div>

              <div class="alert alert-info" style="border-left: 4px solid #06b6d4;">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Consejo:</strong> Mantener visible el rango salarial genera más postulaciones y mejores coincidencias.
              </div>
            </div>

            {{-- Estado --}}
            <div class="mb-5">
              <h2 class="h5 mb-3 fw-semibold">
                Estado de la vacante
              </h2>

              <div class="form-check form-check-inline p-3 border rounded" style="border-radius: 0.75rem !important;">
                <input class="form-check-input"
                       type="radio"
                       name="status"
                       id="statusOpen"
                       value="open"
                       @checked(old('status', $job->status) === 'open')>
                <label class="form-check-label fw-semibold" for="statusOpen">
                  <i class="bi bi-circle-fill text-success me-2" style="font-size: 0.5rem;"></i>
                  Abierta
                </label>
                <small class="d-block text-muted mt-1">La vacante está recibiendo postulaciones</small>
              </div>

              <div class="form-check form-check-inline p-3 border rounded ms-3" style="border-radius: 0.75rem !important;">
                <input class="form-check-input"
                       type="radio"
                       name="status"
                       id="statusClosed"
                       value="closed"
                       @checked(old('status', $job->status) === 'closed')>
                <label class="form-check-label fw-semibold" for="statusClosed">
                  <i class="bi bi-lock me-2"></i>
                  Cerrada
                </label>
                <small class="d-block text-muted mt-1">No aceptará nuevas postulaciones</small>
              </div>
            </div>

            {{-- Acciones --}}
            <div class="d-flex gap-2 pt-4 border-top">
              <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-check-circle me-2"></i>Guardar cambios
              </button>
              <a href="{{ route('empresa.jobs.index') }}" class="btn btn-outline-secondary btn-lg">
                <i class="bi bi-x-circle me-2"></i>Cancelar
              </a>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
