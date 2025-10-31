<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>@yield('title','Hirewise')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
  <style> .container{max-width:960px;margin:auto} </style>
</head>
<body class="min-h-screen">
  <main class="container">
    @if(session('status'))
      <div class="mb-4" role="alert">{{ session('status') }}</div>
    @endif
    @if(session('error'))
      <div class="mb-4" role="alert">{{ session('error') }}</div>
    @endif
    @yield('content')
  </main>
</body>
</html>
