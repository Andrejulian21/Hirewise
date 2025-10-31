<!doctype html>
<html lang="es"><head><meta charset="utf-8"><title>Login</title></head>
<body>
  <h1>Iniciar sesión</h1>

  @if ($errors->any())
    <div style="color:red">{{ $errors->first() }}</div>
  @endif

  <form method="POST" action="{{ route('login.store') }}">
    @csrf
    <div>
      <label>Email</label>
      <input type="email" name="email" value="{{ old('email') }}" required>
    </div>
    <div>
      <label>Contraseña</label>
      <input type="password" name="password" required>
    </div>
    <div>
      <label><input type="checkbox" name="remember"> Recuérdame</label>
    </div>
    <button type="submit">Entrar</button>
  </form>

  <p style="margin-top:16px">
    <a href="{{ route('auth.redirect.google') }}">Continuar con Google</a>
  </p>

  <p>¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate</a></p>
</body></html>
