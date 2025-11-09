<!doctype html>
<html lang="es" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Hirewise - Plataforma inteligente de selección de talento con IA para pequeñas y medianas empresas">
    <meta name="theme-color" content="#1e40af">

    <title>@yield('title', 'Hirewise — Selección de Talento con IA')</title>

    <!-- Preconnect para optimización -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Tipografía Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Estilos propios -->
    @stack('styles')
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    
    @yield('extra_css')
</head>

<body class="app-body">

    <!-- Navbar -->
    @include('layouts.navbar')

    <!-- Contenido principal -->
    <main class="flex-shrink-0">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- Scripts propios -->
    @stack('scripts')
    <script src="{{ asset('js/welcome.js') }}"></script>
    
    @yield('extra_js')
</body>

</html>