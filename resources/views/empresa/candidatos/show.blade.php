@extends('layoutsempresa.app')
@section('title','Perfil del candidato')

@section('content')
<div class="container py-4">
  <div class="card shadow-sm border-0">
    <div class="card-body d-flex gap-3 align-items-center">
      <img src="{{ $candidate->photo_url }}" class="rounded-circle" width="84" height="84" alt="Foto">
      <div>
        <h1 class="h5 mb-1">{{ optional($candidate->user)->name }}</h1>
        <div class="text-muted small">{{ optional($candidate->user)->email }}</div>
        @if($candidate->linkedin_url)
          <a href="{{ $candidate->linkedin_url }}" target="_blank" class="small">LinkedIn ↗</a>
        @endif
      </div>
      <div class="ms-auto">
        @if($candidate->cv_file)
          <a class="btn btn-outline-primary btn-sm"
             href="{{ route('candidato.cv.ver', $candidate->id) }}" target="_blank">Ver CV</a>
        @endif
      </div>
    </div>
  </div>

  <div class="row g-3 mt-3">
    <div class="col-md-8">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body">
          <h2 class="h6">Resumen</h2>
          <p class="mb-0">{{ $candidate->summary ?: '—' }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body">
          <h2 class="h6">Información</h2>
          <div class="small text-muted">Experiencia</div>
          <div class="mb-2">{{ (int) $candidate->experience_years }} años</div>
          <div class="small text-muted">Educación</div>
          <div>{{ $candidate->education ?: '—' }}</div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
