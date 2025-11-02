@extends('layouts.dashboard')

@section('content')
<h1 class="text-xl font-bold mb-4">Dashboard Empresa</h1>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
  <div class="p-4 bg-white rounded shadow">Vacantes: <b>{{ $jobsCount }}</b></div>
  <div class="p-4 bg-white rounded shadow">Abiertas: <b>{{ $openJobs }}</b></div>
  <div class="p-4 bg-white rounded shadow">Postulaciones: <b>{{ $appsCount }}</b></div>
  <div class="p-4 bg-white rounded shadow">Compatibilidad prom.: <b>{{ $avgScore ?: 0 }}</b></div>
</div>

<h2 class="font-semibold mb-2">Top vacantes por postulaciones</h2>
<table class="w-full mb-6">
  <thead><tr><th>Título</th><th class="text-right">Postulaciones</th></tr></thead>
  <tbody>
    @foreach($topJobs as $j)
    <tr class="border-b">
      <td class="py-2">{{ $j->title }}</td>
      <td class="py-2 text-right">{{ $j->applications_count }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

<h2 class="font-semibold mb-2">Últimas postulaciones</h2>
<table class="w-full">
  <thead><tr><th>Candidato</th><th>Vacante</th><th>Score</th><th>Fecha</th></tr></thead>
  <tbody>
    @foreach($lastApps as $a)
    <tr class="border-b">
      <td class="py-2">{{ optional($a->candidate->user)->name }}</td>
      <td class="py-2">{{ $a->job->title }}</td>
      <td class="py-2">{{ $a->score ?? '—' }}</td>
      <td class="py-2">{{ $a->created_at->format('Y-m-d H:i') }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
