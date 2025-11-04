@extends('layoutscandidatos.app')
@section('title', 'Mi perfil')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Mi perfil</h1>
        <a href="{{ route('candidato.perfil.edit') }}" class="btn btn-primary">Editar perfil</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Resumen</dt>
                <dd class="col-sm-9">{{ $candidate->summary ?: '—' }}</dd>

                <dt class="col-sm-3">Años de experiencia</dt>
                <dd class="col-sm-9">{{ $candidate->experience_years ?? 0 }}</dd>

                <dt class="col-sm-3">Educación</dt>
                <dd class="col-sm-9">{{ $candidate->education ?: '—' }}</dd>

                <dt class="col-sm-3">LinkedIn</dt>
                <dd class="col-sm-9">
                    @if ($candidate->linkedin_url)
                        <a href="{{ $candidate->linkedin_url }}" target="_blank" rel="noopener">
                            {{ $candidate->linkedin_url }}
                        </a>
                    @else
                        —
                    @endif
                </dd>

                <dt class="col-sm-3">CV</dt>
                <dd class="col-sm-9">
                    @if ($candidate->cv_file)
                        <a href="{{ route('candidato.cv.ver', $candidate->id) }}" target="_blank"
                            class="btn btn-sm btn-outline-primary">
                            Ver CV
                        </a>
                    @endif
                </dd>
            </dl>
        </div>
    </div>
@endsection
