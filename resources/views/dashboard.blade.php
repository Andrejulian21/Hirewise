@extends('layouts.app')
@section('title','Dashboard')

@section('content')
<div class="flex items-center justify-between mb-6">
  <h1 class="text-2xl font-semibold">Dashboard</h1>
  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button class="border rounded-md px-3 py-1 hover:bg-gray-100">Cerrar sesión</button>
  </form>
</div>

<div class="bg-white border rounded-xl p-6">
  <p class="mb-2"><strong>Usuario:</strong> {{ auth()->user()->name }}</p>
  <p class="mb-2"><strong>Email:</strong> {{ auth()->user()->email }}</p>

  @if(method_exists(auth()->user(), 'hasRole'))
    @hasrole('Admin')
      <p class="mt-4 p-3 bg-indigo-50 border rounded">Rol: Admin ✅</p>
    @endhasrole
    @hasrole('Empresa')
      <p class="mt-4 p-3 bg-amber-50 border rounded">Rol: Empresa ✅</p>
    @endhasrole
    @hasrole('Candidato')
      <p class="mt-4 p-3 bg-emerald-50 border rounded">Rol: Candidato ✅</p>
    @endhasrole
  @endif
</div>
@endsection
