<!doctype html>
<html lang="es"><head><meta charset="utf-8"><title>Registro</title></head>
<body>
  <h1>Crear cuenta</h1>

  @if ($errors->any())
    <div style="color:red">
      <ul>
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('register.store') }}">
    @csrf
    <div>
      <label>Nombre</label>
      <input type="text" name="name" value="{{ old('name') }}" required>
    </div>
    <div>
      <label>Email</label>
      <input type="email" name="email" value="{{ old('email') }}" required>
    </div>
    <div>
      <label>Contraseña</label>
      <input type="password" name="password" required>
    </div>
    <div>
      <label>Confirmar Contraseña</label>
      <input type="password" name="password_confirmation" required>
    </div>
    <div>
      <label>Rol</label>
      <select name="role" required>
        <option value="">-- Selecciona --</option>
        <option value="Empresa"  @selected(old('role')==='Empresa')>Empresa</option>
        <option value="Candidato"@selected(old('role')==='Candidato')>Candidato</option>
      </select>
    </div>
    <button type="submit">Registrarme</button>
  </form>

  <hr style="margin:16px 0">

  <p>O regístrate con Google conservando el rol elegido:</p>
  <p style="margin-top:16px">
    <!-- redirige a /auth/google/redirect y opcionalmente envía rol -->
    <a href="{{ route('auth.redirect.google', ['rol' => 'Empresa']) }}">Continuar con Google (Empresa)</a>
    <br>
    <a href="{{ route('auth.redirect.google', ['rol' => 'Candidato']) }}">Continuar con Google (Candidato)</a>
  </p>

  <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
</body></html>
