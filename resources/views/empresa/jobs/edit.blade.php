@extends('layoutsempresa.app')
@section('title','Editar vacante')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Editar vacante</h1>
    <div class="d-flex gap-2">
      <a href="{{ route('empresa.jobs.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Volver
      </a>
      {{-- (Opcional) Eliminar desde aquí --}}
      <form method="POST" action="{{ route('empresa.jobs.destroy', $job) }}"
            onsubmit="return confirm('¿Eliminar esta vacante?');">
        @csrf @method('DELETE')
        <button class="btn btn-outline-danger"><i class="bi bi-trash"></i> Eliminar</button>
      </form>
    </div>
  </div>

  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <form method="POST" action="{{ route('empresa.jobs.update', $job) }}" novalidate>
        @csrf
        @method('PUT')

        <div class="row g-3">
          {{-- Título --}}
          <div class="col-12">
            <label class="form-label fw-semibold">Título</label>
            <input class="form-control @error('title') is-invalid @enderror"
                   name="title" value="{{ old('title', $job->title) }}" placeholder="Ej: Desarrollador Backend SR">
            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          {{-- Descripción --}}
          <div class="col-12">
            <label class="form-label fw-semibold">Descripción</label>
            <textarea class="form-control @error('description') is-invalid @enderror"
                      name="description" rows="4"
                      placeholder="Describe el rol, responsabilidades, beneficios...">{{ old('description', $job->description) }}</textarea>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          {{-- Requisitos --}}
          <div class="col-12">
            <label class="form-label fw-semibold">Requisitos</label>
            <textarea class="form-control" name="requirements" rows="3"
                      placeholder="Habilidades técnicas, años de experiencia, herramientas...">{{ old('requirements', $job->requirements) }}</textarea>
          </div>

          {{-- Ubicación / Salarios --}}
          <div class="col-md-6">
            <label class="form-label fw-semibold">Ubicación</label>
            <input class="form-control" name="location"
                   value="{{ old('location', $job->location) }}" placeholder="Ciudad / Remoto">
          </div>

          <div class="col-md-3">
            <label class="form-label fw-semibold">Salario mínimo</label>
            <input class="form-control" type="number" step="0.01" name="salary_min"
                   value="{{ old('salary_min', $job->salary_min) }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Salario máximo</label>
            <input class="form-control" type="number" step="0.01" name="salary_max"
                   value="{{ old('salary_max', $job->salary_max) }}">
          </div>

          {{-- Estado --}}
          <div class="col-md-4">
            <label class="form-label fw-semibold">Estado</label>
            <select class="form-select" name="status">
              <option value="open"   @selected(old('status', $job->status)==='open')>Abierta</option>
              <option value="closed" @selected(old('status', $job->status)==='closed')>Cerrada</option>
            </select>
          </div>
        </div>

        <div class="d-flex gap-2 mt-4">
          <button class="btn btn-primary px-4">Guardar cambios</button>
          <a href="{{ route('empresa.jobs.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
