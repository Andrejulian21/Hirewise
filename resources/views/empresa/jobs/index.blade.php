@extends('layouts.app')

@section('content')
    <h1>Mis Vacantes</h1>

    <a href="{{ route('empresa.jobs.create') }}">Nueva vacante</a>

    @if(session('status')) <p>{{ session('status') }}</p> @endif

    <table>
        <thead><tr><th>Título</th><th>Estado</th><th>Acciones</th></tr></thead>
        <tbody>
        @foreach($jobs as $job)
            <tr>
                <td>{{ $job->title }}</td>
                <td>{{ $job->status }}</td>
                <td>
                    <a href="{{ route('empresa.jobs.edit',$job) }}">Editar</a>
                    <form method="POST" action="{{ route('empresa.jobs.destroy',$job) }}" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $jobs->links() }}
</table>
@endsection
