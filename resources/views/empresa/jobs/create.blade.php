@extends('layoutsempresa.app')
@section('title', 'Nueva vacante')

@section('content')
<div class="container py-4">
  {{-- Header --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-1 fw-bold">
        <i class="bi bi-plus-circle me-2" style="color: #1e40af;"></i>
        Nueva vacante
      </h1>
      <p class="text-muted mb-0">Completa la información para publicar tu oferta de trabajo</p>
    </div>
    <a href="{{ route('empresa.jobs.index') }}" class="btn btn-outline-secondary">
      <i class="bi bi-arrow-left"></i> Volver
    </a>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card border-0 shadow-sm" style="border-radius: 1rem;">
        <div class="card-body p-4 p-md-5">
          <form method="POST" action="{{ route('empresa.jobs.store') }}" novalidate>
            @csrf

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
                       value="{{ old('title') }}" 
                       placeholder="Ej: Desarrollador Backend Senior"
                       required>
                @error('title') 
                  <div class="invalid-feedback">
                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                  </div> 
                @enderror
                <small class="form-text text-muted">
                  <i class="bi bi-lightbulb me-1"></i>
                  Usa un título claro y específico para atraer candidatos adecuados
                </small>
              </div>

              <div class="mb-4">
                <label class="form-label fw-semibold">
                  <i class="bi bi-geo-alt me-2"></i>Ubicación
                </label>
                <input class="form-control" 
                       name="location" 
                       value="{{ old('location') }}" 
                       placeholder="Ciudad, País o 'Remoto'">
                <small class="form-text text-muted">
                  Indica si el trabajo es presencial, híbrido o 100% remoto
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
                          placeholder="Describe el rol, responsabilidades principales, tecnologías a utilizar, equipo de trabajo y beneficios...">{{ old('description') }}</textarea>
                @error('description') 
                  <div class="invalid-feedback">
                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                  </div> 
                @enderror
                <small class="form-text text-muted">
                  <i class="bi bi-info-circle me-1"></i>
                  Una descripción detallada ayuda a los candidatos a entender mejor la oportunidad
                </small>
              </div>

              <div class="mb-4">
                <label class="form-label fw-semibold">
                  <i class="bi bi-check2-square me-2"></i>Requisitos
                </label>
                <textarea class="form-control" 
                          name="requirements" 
                          rows="5"
                          placeholder="• Experiencia con PHP/Laravel&#10;• Conocimiento en bases de datos SQL&#10;• 3+ años de experiencia&#10;• Inglés intermedio...">{{ old('requirements') }}</textarea>
                <small class="form-text text-muted">
                  Lista las habilidades técnicas, años de experiencia y requisitos específicos
                </small>
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
                         value="{{ old('salary_min') }}"
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
                         value="{{ old('salary_max') }}"
                         placeholder="0.00">
                </div>
              </div>

              <div class="alert alert-info" style="border-left: 4px solid #06b6d4;">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Consejo:</strong> Mostrar el rango salarial aumenta las postulaciones en un 30% y atrae candidatos más calificados.
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
                       @checked(old('status', 'open')==='open')>
                <label class="form-check-label fw-semibold" for="statusOpen">
                  <i class="bi bi-circle-fill text-success me-2" style="font-size: 0.5rem;"></i>
                  Abierta
                </label>
                <small class="d-block text-muted mt-1">La vacante recibirá postulaciones</small>
              </div>

              <div class="form-check form-check-inline p-3 border rounded ms-3" style="border-radius: 0.75rem !important;">
                <input class="form-check-input" 
                       type="radio" 
                       name="status" 
                       id="statusClosed" 
                       value="closed" 
                       @checked(old('status')==='closed')>
                <label class="form-check-label fw-semibold" for="statusClosed">
                  <i class="bi bi-lock me-2"></i>
                  Cerrada
                </label>
                <small class="d-block text-muted mt-1">No aceptará más postulaciones</small>
              </div>
            </div>

            {{-- Acciones --}}
            <div class="d-flex gap-2 pt-4 border-top">
              <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-check-circle me-2"></i>Publicar vacante
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