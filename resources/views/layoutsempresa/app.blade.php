<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>@yield('title', 'Hirewise – Empresa')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- Bootstrap + tu CSS común --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

  {{-- Navbar Empresa --}}
    @include('layoutsempresa.navbaremp')

  {{-- Contenido --}}
  <main class="flex-grow-1 py-4">
    <div class="container">
      @yield('content')
    </div>
  </main>

  {{-- Footer --}}
    @include('layouts.footer')

  {{-- Bootstrap JS (no Vite) --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
