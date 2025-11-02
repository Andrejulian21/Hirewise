{{-- resources/views/candidato/perfil/edit.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Mi Perfil</h1>

    @if (session('status'))
        <p style="color:green">{{ session('status') }}</p>
    @endif

    @if ($errors->any())
        <ul style="color:red">
            @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('candidato.perfil.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <textarea name="summary" placeholder="Resumen">{{ old('summary', $candidate->summary) }}</textarea>

        <input type="number" name="experience_years" value="{{ old('experience_years', $candidate->experience_years) }}"
            min="0">

        <input type="text" name="education" value="{{ old('education', $candidate->education) }}"
            placeholder="Educación">

        <input type="url" name="linkedin_url" placeholder="https://www.linkedin.com/in/tu-usuario"
            value="{{ old('linkedin_url', $candidate->linkedin_url) }}" pattern="https?://.*">
        <script>
            document.getElementById('linkedin').addEventListener('blur', e => {
                const v = e.target.value.trim();
                if (v && !/^https?:\/\//i.test(v)) e.target.value = 'https://' + v;
            });
        </script>

        <input type="file" name="cv_file" accept=".pdf,.doc,.docx">

        <button type="submit">Guardar</button>
    </form>
@endsection
