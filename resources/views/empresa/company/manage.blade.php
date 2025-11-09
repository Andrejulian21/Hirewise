@extends('layoutsempresa.app')
@section('title', 'Mi empresa')

@section('content')
<div class="container py-4">
  {{-- Header --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-1 fw-bold">
        <i class="bi bi-building me-2" style="color: #1e40af;"></i>
        Mi empresa
      </h1>
      <p class="text-muted mb-0">
        Crea o edita la información de tu empresa. Estos datos se mostrarán en tus vacantes públicas.
      </p>
    </div>
  </div>

  {{-- Alertas --}}
  @if(session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle-fill me-2"></i>
      {{ session('status') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-triangle-fill me-2"></i>
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-triangle-fill me-2"></i>
      <strong>Por favor corrige los siguientes errores:</strong>
      <ul class="mb-0 mt-2">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="row g-4">
    {{-- Columna principal --}}
    <div class="col-12 col-lg-8">
      <div class="company-profile-card">
        @if(!$company)
          <h2 class="h5 mb-4 fw-semibold">
            <i class="bi bi-plus-circle me-2"></i>Crear empresa
          </h2>
          <form method="POST" action="{{ route('empresa.company.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-4">
              <label class="form-label fw-semibold">
                <i class="bi bi-building me-2"></i>Nombre de la empresa *
              </label>
              <input class="form-control" 
                     name="name" 
                     value="{{ old('name') }}" 
                     placeholder="Ej: TechCorp Solutions"
                     required>
              <small class="form-text text-muted">
                <i class="bi bi-info-circle me-1"></i>
                Este nombre aparecerá en todas tus publicaciones
              </small>
            </div>

            <div class="mb-4">
              <label class="form-label fw-semibold">
                <i class="bi bi-file-text me-2"></i>Descripción
              </label>
              <textarea class="form-control" 
                        name="description" 
                        rows="5"
                        placeholder="Describe tu empresa, su misión, valores y lo que la hace especial...">{{ old('description') }}</textarea>
              <small class="form-text text-muted">
                Una buena descripción atrae mejores candidatos
              </small>
            </div>

            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label class="form-label fw-semibold">
                  <i class="bi bi-globe me-2"></i>Sitio web
                </label>
                <input class="form-control" 
                       name="website" 
                       type="url" 
                       placeholder="https://tuempresa.com" 
                       value="{{ old('website') }}">
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">
                  <i class="bi bi-image me-2"></i>Logo
                </label>
                <input class="form-control" 
                       type="file" 
                       name="logo" 
                       accept=".png,.jpg,.jpeg,.webp"
                       id="logoInput">
                <small class="form-text text-muted">
                  PNG, JPG o WEBP. Máximo 2MB
                </small>
              </div>
            </div>

            <div class="d-flex gap-2 pt-3 border-top">
              <button class="btn btn-primary">
                <i class="bi bi-check-circle me-2"></i>Guardar empresa
              </button>
              <a class="btn btn-outline-secondary" href="{{ route('empresa.jobs.dashboard') }}">
                <i class="bi bi-x-circle me-2"></i>Cancelar
              </a>
            </div>
          </form>

        @else
          <h2 class="h5 mb-4 fw-semibold">
            <i class="bi bi-pencil-square me-2"></i>Editar empresa
          </h2>
          <form method="POST" action="{{ route('empresa.company.update') }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            
            <div class="mb-4">
              <label class="form-label fw-semibold">
                <i class="bi bi-building me-2"></i>Nombre de la empresa *
              </label>
              <input class="form-control" 
                     name="name" 
                     value="{{ old('name', $company->name) }}" 
                     placeholder="Ej: TechCorp Solutions"
                     required>
            </div>

            <div class="mb-4">
              <label class="form-label fw-semibold">
                <i class="bi bi-file-text me-2"></i>Descripción
              </label>
              <textarea class="form-control" 
                        name="description" 
                        rows="5"
                        placeholder="Describe tu empresa...">{{ old('description', $company->description) }}</textarea>
            </div>

            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label class="form-label fw-semibold">
                  <i class="bi bi-globe me-2"></i>Sitio web
                </label>
                <input class="form-control" 
                       name="website" 
                       type="url" 
                       placeholder="https://tuempresa.com"
                       value="{{ old('website', $company->website) }}">
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold d-block">
                  <i class="bi bi-image me-2"></i>Logo
                </label>
                @if($company->logo)
                  <div class="d-flex align-items-center gap-3 mb-3">
                    <img src="{{ asset('storage/'.$company->logo) }}" 
                         alt="Logo actual" 
                         class="company-logo-preview">
                    <div class="flex-grow-1">
                      <input class="form-control" 
                             type="file" 
                             name="logo" 
                             accept=".png,.jpg,.jpeg,.webp"
                             id="logoInput">
                      <small class="form-text text-muted d-block mt-1">
                        Sube un nuevo logo para reemplazar el actual
                      </small>
                    </div>
                  </div>
                @else
                  <input class="form-control" 
                         type="file" 
                         name="logo" 
                         accept=".png,.jpg,.jpeg,.webp"
                         id="logoInput">
                  <small class="form-text text-muted">
                    PNG, JPG o WEBP. Máximo 2MB
                  </small>
                @endif
              </div>
            </div>

            <div class="d-flex gap-2 pt-3 border-top">
              <button class="btn btn-primary">
                <i class="bi bi-check-circle me-2"></i>Actualizar
              </button>
              <a class="btn btn-outline-secondary" href="{{ route('empresa.jobs.dashboard') }}">
                <i class="bi bi-arrow-left me-2"></i>Volver
              </a>
            </div>
          </form>
        @endif
      </div>
    </div>

    {{-- Sidebar --}}
    @if($company)
    <div class="col-12 col-lg-4">
      {{-- Vista previa --}}
      <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
        <div class="card-body p-4">
          <h3 class="h6 mb-3 fw-semibold">
            <i class="bi bi-eye me-2"></i>Vista previa
          </h3>
          
          <div class="d-flex align-items-center gap-3 mb-3 pb-3 border-bottom">
            <div class="rounded bg-light d-flex justify-content-center align-items-center" 
                 style="width:64px; height:64px; flex-shrink: 0;">
              @if($company->logo)
                <img src="{{ asset('storage/'.$company->logo) }}" 
                     class="rounded" 
                     style="width:64px; height:64px; object-fit:cover;">
              @else
                <span class="text-muted" style="font-size: 2rem; font-weight: 700;">
                  {{ strtoupper(substr($company->name, 0, 1)) }}
                </span>
              @endif
            </div>
            <div>
              <div class="fw-semibold mb-1">{{ $company->name }}</div>
              @if($company->website)
                <a href="{{ $company->website }}" target="_blank" class="small text-decoration-none">
                  {{ parse_url($company->website, PHP_URL_HOST) ?: $company->website }}
                  <i class="bi bi-box-arrow-up-right ms-1"></i>
                </a>
              @else
                <span class="small text-muted">Sin sitio web</span>
              @endif
            </div>
          </div>

          <p class="small text-muted mb-0">
            {{ Str::limit($company->description, 160) ?: 'Sin descripción' }}
          </p>
        </div>
      </div>

      {{-- Estadísticas --}}
      <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
        <div class="card-body p-4">
          <h3 class="h6 mb-3 fw-semibold">
            <i class="bi bi-graph-up me-2"></i>Estadísticas
          </h3>
          
          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted small">Vacantes publicadas</span>
            <span class="fw-bold">{{ $company->jobs()->count() }}</span>
          </div>
          
          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted small">Vacantes activas</span>
            <span class="fw-bold">{{ $company->jobs()->where('status', 'open')->count() }}</span>
          </div>
          
          <hr>
          
          <a href="{{ route('empresa.jobs.index') }}" class="btn btn-outline-primary w-100">
            <i class="bi bi-briefcase me-2"></i>Ver mis vacantes
          </a>
        </div>
      </div>

      {{-- Eliminar empresa --}}
      <div class="card border-danger shadow-sm" style="border-radius: 1rem;">
        <div class="card-body p-4">
          <h3 class="h6 mb-2 text-danger fw-semibold">
            <i class="bi bi-exclamation-triangle me-2"></i>Zona peligrosa
          </h3>
          <p class="small text-muted mb-3">
            Eliminar la empresa puede afectar tus vacantes publicadas. Esta acción no se puede deshacer.
          </p>
          
          <form method="POST" action="{{ route('empresa.company.destroy') }}"
                onsubmit="return confirm('⚠️ Esta acción eliminará la empresa y puede afectar tus vacantes. ¿Estás seguro de continuar?');">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger w-100">
              <i class="bi bi-trash me-2"></i>Eliminar empresa
            </button>
          </form>
        </div>
      </div>
    </div>
    @endif
  </div>
</div>
@endsection

@push('scripts')
<script>
// Preview de logo antes de subir
(function() {
    const logoInput = document.getElementById('logoInput');
    if (!logoInput) return;
    
    logoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const img = document.querySelector('.company-logo-preview');
                if (img) {
                    img.src = event.target.result;
                }
            };
            reader.readAsDataURL(file);
        }
    });
})();
</script>
@endpush