@extends('layouts.app')

@section('content')
    <h1>Nueva Vacante</h1>
    <form method="POST" action="{{ route('empresa.jobs.store') }}">
        @csrf
        <input name="title" value="{{ old('title') }}" placeholder="Título">
        @error('title')
            <small>{{ $message }}</small>
        @enderror

        <textarea name="description" placeholder="Descripción">{{ old('description') }}</textarea>
        @error('description')
            <small>{{ $message }}</small>
        @enderror

        <textarea name="requirements" placeholder="Requisitos">{{ old('requirements') }}</textarea>

        <input name="location" value="{{ old('location') }}" placeholder="Ubicación">
        <input type="number" step="0.01" name="salary_min" value="{{ old('salary_min') }}" placeholder="Salario min">
        <input type="number" step="0.01" name="salary_max" value="{{ old('salary_max') }}" placeholder="Salario max">

        <select name="status">
            <option value="open">Abierta</option>
            <option value="closed">Cerrada</option>
        </select>

        <button>Guardar</button>
    </form>
@endsection
