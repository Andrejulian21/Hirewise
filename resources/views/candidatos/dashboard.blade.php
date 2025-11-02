@extends('layouts.dashboard')

@section('content')
<h1 class="text-xl font-bold mb-4">Dashboard Candidato</h1>

<div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
  <div class="p-4 bg-white rounded shadow">Postulaciones: <b>{{ $totalApps }}</b></div>
  <div class="p-4 bg-white rounded shadow">Compatibilidad prom.: <b>{{ $avgScore ?: 0 }}</b></div>
  <div class="p-4 bg-white rounded shadow">Pendientes: <b>{{ $totalApps }}</b></div>
</div>

<h2 class="font-semibold mb-2">Últimas postulaciones</h2>
<table class="w-full">
  <thead><tr><th>Vacante</th><th>Empresa</th><th>Score</th><th>Fecha</th></tr></thead>
  <tbody>
    @foreach($lastApps as $a)
    <tr class="border-b">
      <td class="py-2">{{ $a->job->title }}</td>
      <td class="py-2">{{ $a->job->company->name }}</td>
      <td class="py-2">{{ $a->score ?? '—' }}</td>
      <td class="py-2">{{ $a->created_at->format('Y-m-d H:i') }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
