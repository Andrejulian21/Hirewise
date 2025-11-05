@extends('layoutscandidatos.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- Título --}}
                <div class="mb-3">
                    <h1 class="h3 mb-1">Editar perfil</h1>
                    <p class="text-muted mb-0">Actualiza tu información profesional para mejorar tu compatibilidad.</p>
                </div>

                {{-- Alertas --}}
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Card --}}
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">

                        <form method="POST" action="{{ route('candidato.perfil.update') }}" enctype="multipart/form-data"
                            id="frmPerfil">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Foto de perfil</label>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $candidate->photo_url }}" alt="Foto" class="rounded-circle"
                                        width="72" height="72">
                                    <input type="file" name="photo" accept="image/*" class="form-control w-auto">
                                </div>
                                @error('photo')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Resumen --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="summary">Resumen profesional</label>
                                <textarea class="form-control" id="summary" name="summary" rows="4"
                                    placeholder="Cuéntanos en pocas líneas tu experiencia y fortalezas.">{{ old('summary', $candidate->summary) }}</textarea>
                            </div>

                            {{-- Años de experiencia --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="experience_years">Años de experiencia</label>
                                <input class="form-control" type="number" id="experience_years" name="experience_years"
                                    value="{{ old('experience_years', $candidate->experience_years) }}" min="0">
                            </div>

                            {{-- Educación --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="education">Educación</label>
                                <input class="form-control" type="text" id="education" name="education"
                                    value="{{ old('education', $candidate->education) }}"
                                    placeholder="Ej: Ingeniería de Sistemas">
                            </div>

                            {{-- LinkedIn --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="linkedin">URL de LinkedIn</label>
                                <input class="form-control" type="url" id="linkedin" name="linkedin_url"
                                    placeholder="https://www.linkedin.com/in/tu-usuario"
                                    value="{{ old('linkedin_url', $candidate->linkedin_url) }}" pattern="https?://.*">
                                <div class="form-text">Debe iniciar con http:// o https:// (se añade automáticamente si lo
                                    omites).</div>
                            </div>

                            {{-- CV --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold" for="cv_file">CV (PDF/DOC/DOCX)</label>
                                <input class="form-control" type="file" id="cv_file" name="cv_file"
                                    accept=".pdf,.doc,.docx">
                                @if ($candidate->cv_file)
                                    <div class="form-text mt-1">
                                        Archivo actual: <a href="{{ route('candidato.cv.ver', $candidate->id) }}"
                                            target="_blank" class="btn btn-sm btn-outline-primary">
                                            Ver CV
                                        </a>
                                    </div>
                                @endif
                            </div>

                            {{-- Acciones --}}
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary px-4">Guardar</button>
                                <a href="{{ route('candidato.perfil.show') }}"
                                    class="btn btn-outline-secondary">Cancelar</a>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Normaliza LinkedIn si el usuario olvida http/https --}}
    <script>
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
    </script>
@endsection
