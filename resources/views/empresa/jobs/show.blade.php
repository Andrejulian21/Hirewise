@extends('layouts.app')

@section('content')
    <h1>{{ $job->title }}</h1>
    <p><b>Empresa:</b> {{ $job->company->name ?? '-' }}</p>
    <p>{{ $job->description }}</p>
    <p><b>Ubicación:</b> {{ $job->location }}</p>

    @role('Candidato')
        <form action="{{ route('candidato.aplicar', $job) }}" method="POST">
            @csrf
            <button type="submit">Postular</button>
        </form>
        @if (session('status'))
            <p>{{ session('status') }}</p>
        @endif
        @if (session('error'))
            <p>{{ session('error') }}</p>
        @endif
    @endrole
@endsection
