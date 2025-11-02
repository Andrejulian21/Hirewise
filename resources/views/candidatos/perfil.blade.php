@extends('layouts.app')

@section('content')
<h2>Mi Perfil</h2>
<form method="POST" action="{{ route('candidato.perfil.update') }}">
    @csrf
    <label>Nombre</label>
    <input type="text" name="name" value="{{ old('name', $candidato->name) }}" required>

    <label>Descripción</label>
    <textarea name="description">{{ old('description', $candidato->description) }}</textarea>

    <label>Habilidades</label>
    <input type="text" name="skills" value="{{ old('skills', $candidato->skills) }}">

    <button type="submit">Guardar cambios</button>
</form>
@endsection
