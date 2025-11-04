@extends('layoutsempresa.app')
@section('title','Nueva vacante')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Nueva vacante</h1>
    <a href="{{ route('empresa.jobs.index') }}" class="btn btn-outline-secondary">
      <i class="bi bi-arrow-left"></i> Volver
    </a>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <form method="POST" action="{{ route('empresa.jobs.store') }}" novalidate>
        @csrf

        <div class="row g-3">
          <div class="col-12">
            <label class="form-label fw-semibold">Título</label>
            <input class="form-control @error('title') is-invalid @enderror"
                   name="title" value="{{ old('title') }}" placeholder="Ej: Desarrollador Backend SR">
            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="col-12">
            <label class="form-label fw-semibold">Descripción</label>
            <textarea class="form-control @error('description') is-invalid @enderror"
                      name="description" rows="4" placeholder="Describe el rol, responsabilidades, beneficios...">{{ old('description') }}</textarea>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="col-12">
            <label class="form-label fw-semibold">Requisitos</label>
            <textarea class="form-control" name="requirements" rows="3"
                      placeholder="Habilidades técnicas, años de experiencia, herramientas...">{{ old('requirements') }}</textarea>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Ubicación</label>
            <input class="form-control" name="location" value="{{ old('location') }}" placeholder="Ciudad / Remoto">
          </div>

          <div class="col-md-3">
            <label class="form-label fw-semibold">Salario mínimo</label>
            <input class="form-control" type="number" step="0.01" name="salary_min" value="{{ old('salary_min') }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Salario máximo</label>
            <input class="form-control" type="number" step="0.01" name="salary_max" value="{{ old('salary_max') }}">
          </div>

          <div class="col-md-4">
            <label class="form-label fw-semibold">Estado</label>
            <select class="form-select" name="status">
              <option value="open"   @selected(old('status')==='open')>Abierta</option>
              <option value="closed" @selected(old('status')==='closed')>Cerrada</option>
            </select>
          </div>
        </div>

        <div class="d-flex gap-2 mt-4">
          <button class="btn btn-primary px-4">Guardar</button>
          <a href="{{ route('empresa.jobs.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
