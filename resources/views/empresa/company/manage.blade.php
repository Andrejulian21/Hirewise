@extends('layoutsempresa.app')
@section('title','Mi empresa')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h1 class="h4 mb-1">Mi empresa</h1>
      <p class="text-muted mb-0">
        Crea o edita la información de tu empresa. Estos datos se mostrarán en tus vacantes públicas.
      </p>
    </div>
  </div>

  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif

  <div class="row g-3">
    <div class="col-12 col-lg-8">
      <div class="card shadow-sm border-0">
        <div class="card-body">
          @if(!$company)
            <h2 class="h5 mb-3">Crear empresa</h2>
            <form method="POST" action="{{ route('empresa.company.store') }}" enctype="multipart/form-data" class="row g-3">
              @csrf
              <div class="col-12">
                <label class="form-label">Nombre *</label>
                <input class="form-control" name="name" value="{{ old('name') }}" required>
              </div>
              <div class="col-12">
                <label class="form-label">Descripción</label>
                <textarea class="form-control" name="description" rows="4">{{ old('description') }}</textarea>
              </div>
              <div class="col-md-6">
                <label class="form-label">Sitio web</label>
                <input class="form-control" name="website" type="url" placeholder="https://example.com" value="{{ old('website') }}">
              </div>
              <div class="col-md-6">
                <label class="form-label">Logo</label>
                <input class="form-control" type="file" name="logo" accept=".png,.jpg,.jpeg,.webp">
              </div>
              <div class="col-12 d-flex gap-2">
                <button class="btn btn-primary">Guardar</button>
                <a class="btn btn-outline-secondary" href="{{ route('empresa.jobs.dashboard') }}">Cancelar</a>
              </div>
            </form>
          @else
            <h2 class="h5 mb-3">Editar empresa</h2>
            <form method="POST" action="{{ route('empresa.company.update') }}" enctype="multipart/form-data" class="row g-3">
              @csrf @method('PUT')
              <div class="col-12">
                <label class="form-label">Nombre *</label>
                <input class="form-control" name="name" value="{{ old('name', $company->name) }}" required>
              </div>
              <div class="col-12">
                <label class="form-label">Descripción</label>
                <textarea class="form-control" name="description" rows="4">{{ old('description', $company->description) }}</textarea>
              </div>
              <div class="col-md-6">
                <label class="form-label">Sitio web</label>
                <input class="form-control" name="website" type="url" placeholder="https://example.com"
                       value="{{ old('website', $company->website) }}">
              </div>
              <div class="col-md-6">
                <label class="form-label d-block">Logo</label>
                @if($company->logo)
                  <div class="d-flex align-items-center gap-3">
                    <img src="{{ asset('storage/'.$company->logo) }}" alt="Logo" class="rounded border" style="width:56px;height:56px;object-fit:cover;">
                    <input class="form-control" type="file" name="logo" accept=".png,.jpg,.jpeg,.webp">
                  </div>
                @else
                  <input class="form-control" type="file" name="logo" accept=".png,.jpg,.jpeg,.webp">
                @endif
              </div>

              <div class="col-12 d-flex gap-2">
                <button class="btn btn-primary">Actualizar</button>
                <a class="btn btn-outline-secondary" href="{{ route('empresa.jobs.dashboard') }}">Volver</a>
              </div>
            </form>
          @endif
        </div>
      </div>
    </div>

    @if($company)
    <div class="col-12 col-lg-4">
      <div class="card shadow-sm border-0">
        <div class="card-body">
          <h3 class="h6 mb-3">Resumen</h3>
          <div class="d-flex align-items-center gap-3 mb-3">
            <div class="rounded bg-light d-flex justify-content-center align-items-center" style="width:56px;height:56px;">
              @if($company->logo)
                <img src="{{ asset('storage/'.$company->logo) }}" class="rounded" style="width:56px;height:56px;object-fit:cover;">
              @else
                <span class="text-muted small">Sin logo</span>
              @endif
            </div>
            <div>
              <div class="fw-semibold">{{ $company->name }}</div>
              <div class="small text-muted">{{ $company->website ?: '—' }}</div>
            </div>
          </div>
          <p class="small text-muted mb-3">{{ Str::limit($company->description, 160) ?: 'Sin descripción' }}</p>

          {{-- Si quieres permitir “eliminar” (soft delete) --}}
          <form method="POST" action="{{ route('empresa.company.destroy') }}"
                onsubmit="return confirm('Esta acción eliminará la empresa (y puede afectar vacantes). ¿Continuar?');">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger w-100">Eliminar empresa</button>
          </form>
        </div>
      </div>
    </div>
    @endif
  </div>
</div>
@endsection
