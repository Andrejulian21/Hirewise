@extends('layouts.app')

@section('content')
    <h1>Vacantes abiertas</h1>
    @foreach ($jobs as $job)
        <article>
            <h3><a href="{{ route('jobs.show', $job) }}">{{ $job->title }}</a></h3>
            <p>{{ $job->company->name ?? 'Empresa' }} – {{ $job->location }}</p>
        </article>
    @endforeach
    {{ $jobs->links() }}
@endsection
