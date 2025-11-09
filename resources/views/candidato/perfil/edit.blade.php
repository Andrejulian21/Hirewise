@extends('layoutscandidatos.app')

@section('title', 'Editar perfil')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- Título --}}
                <div class="mb-4">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <a href="{{ route('candidato.perfil.show') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <div>
                            <h1 class="h3 mb-1">Editar perfil</h1>
                            <p class="text-muted mb-0">Actualiza tu información profesional para mejorar tu compatibilidad.</p>
                        </div>
                    </div>
                </div>

                {{-- Alertas --}}
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Por favor corrige los siguientes errores:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Card principal --}}
                <div class="card shadow-sm border-0" style="border-radius: 1rem;">
                    <div class="card-body p-4 p-md-5">

                        <form method="POST" action="{{ route('candidato.perfil.update') }}" enctype="multipart/form-data"
                            id="frmPerfil">
                            @csrf
                            @method('PUT')

                            {{-- Foto de perfil --}}
                            <div class="mb-4 pb-4 border-bottom">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-camera me-2"></i>Foto de perfil
                                </label>
                                <div class="d-flex align-items-center gap-4">
                                    @if($candidate->photo_url)
                                        <img src="{{ $candidate->photo_url }}" 
                                             alt="Foto actual" 
                                             class="rounded-circle"
                                             width="96" 
                                             height="96"
                                             style="object-fit: cover; border: 3px solid #e5e7eb;">
                                    @else
                                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                                             style="width: 96px; height: 96px; background: linear-gradient(135deg, #06b6d4, #3b82f6); border: 3px solid #e5e7eb;">
                                            <span class="text-white fw-bold" style="font-size: 2.5rem;">
                                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                    
                                    <div class="flex-grow-1">
                                        <input type="file" 
                                               name="photo" 
                                               accept="image/*" 
                                               class="form-control"
                                               id="photoInput">
                                        <small class="form-text text-muted d-block mt-2">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Formato JPG, PNG o GIF. Tamaño máximo 2MB.
                                        </small>
                                    </div>
                                </div>
                                @error('photo')
                                    <small class="text-danger d-block mt-2">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </small>
                                @enderror
                            </div>

                            {{-- Resumen profesional --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold" for="summary">
                                    <i class="bi bi-person-lines-fill me-2"></i>Resumen profesional
                                </label>
                                <textarea class="form-control" 
                                          id="summary" 
                                          name="summary" 
                                          rows="5"
                                          placeholder="Describe tu experiencia, fortalezas y objetivos profesionales. Este resumen ayudará a las empresas a conocerte mejor.">{{ old('summary', $candidate->summary) }}</textarea>
                                <small class="form-text text-muted">
                                    <i class="bi bi-lightbulb me-1"></i>
                                    Incluye tus principales logros y lo que te hace destacar.
                                </small>
                            </div>

                            {{-- Años de experiencia --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold" for="experience_years">
                                    <i class="bi bi-briefcase me-2"></i>Años de experiencia
                                </label>
                                <input class="form-control" 
                                       type="number" 
                                       id="experience_years" 
                                       name="experience_years"
                                       value="{{ old('experience_years', $candidate->experience_years) }}" 
                                       min="0"
                                       max="50"
                                       placeholder="Ej: 5">
                                <small class="form-text text-muted">
                                    Indica cuántos años de experiencia profesional tienes en total.
                                </small>
                            </div>

                            {{-- Educación --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold" for="education">
                                    <i class="bi bi-mortarboard me-2"></i>Educación
                                </label>
                                <input class="form-control" 
                                       type="text" 
                                       id="education" 
                                       name="education"
                                       value="{{ old('education', $candidate->education) }}"
                                       placeholder="Ej: Ingeniería de Sistemas - Universidad Nacional">
                                <small class="form-text text-muted">
                                    Incluye tu nivel académico y especialización principal.
                                </small>
                            </div>

                            {{-- LinkedIn --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold" for="linkedin">
                                    <i class="bi bi-linkedin me-2"></i>URL de LinkedIn
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="bi bi-link-45deg"></i>
                                    </span>
                                    <input class="form-control" 
                                           type="url" 
                                           id="linkedin" 
                                           name="linkedin_url"
                                           placeholder="https://www.linkedin.com/in/tu-usuario"
                                           value="{{ old('linkedin_url', $candidate->linkedin_url) }}" 
                                           pattern="https?://.*">
                                </div>
                                <small class="form-text text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Se añadirá automáticamente "https://" si lo omites.
                                </small>
                            </div>

                            {{-- CV --}}
                            <div class="mb-5">
                                <label class="form-label fw-semibold" for="cv_file">
                                    <i class="bi bi-file-earmark-pdf me-2"></i>Currículum vitae (PDF/DOC/DOCX)
                                </label>
                                <input class="form-control" 
                                       type="file" 
                                       id="cv_file" 
                                       name="cv_file"
                                       accept=".pdf,.doc,.docx">
                                
                                @if ($candidate->cv_file)
                                    <div class="alert alert-info mt-3 mb-0 d-flex align-items-center justify-content-between">
                                        <div>
                                            <i class="bi bi-file-check me-2"></i>
                                            <strong>Archivo actual:</strong> CV cargado
                                        </div>
                                        <a href="{{ route('candidato.cv.ver', $candidate->id) }}"
                                           target="_blank" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye me-1"></i>Ver CV
                                        </a>
                                    </div>
                                @else
                                    <small class="form-text text-muted d-block mt-2">
                                        <i class="bi bi-upload me-1"></i>
                                        Sube tu CV para aumentar tus oportunidades. Formatos: PDF, DOC o DOCX.
                                    </small>
                                @endif
                            </div>

                            {{-- Acciones --}}
                            <div class="d-flex gap-2 pt-3 border-top">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-check-circle me-2"></i>Guardar cambios
                                </button>
                                <a href="{{ route('candidato.perfil.show') }}"
                                    class="btn btn-outline-secondary px-4">
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

@push('scripts')
<script>
    // Normaliza LinkedIn si el usuario olvida http/https
    (function() {
        const input = document.getElementById('linkedin');
        if (!input) return;
        
        input.addEventListener('blur', function(e) {
            const v = e.target.value.trim();
            if (v && !/^https?:\/\//i.test(v)) {
                e.target.value = 'https://' + v;
            }
        });
    })();

    // Preview de imagen antes de subir
    (function() {
        const photoInput = document.getElementById('photoInput');
        if (!photoInput) return;
        
        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const img = document.querySelector('img[alt="Foto actual"]') || 
                                document.querySelector('.rounded-circle');
                    if (img.tagName === 'IMG') {
                        img.src = event.target.result;
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    })();
</script>
@endpush